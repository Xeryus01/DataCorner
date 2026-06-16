<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\KuisReguler\KuisReguler;
use App\Models\TantanganBulanan\Periode;
use App\Models\KuisReguler\SoalKuisReguler;
use App\Models\KuisReguler\HasilKuisReguler;
use App\Models\KuisReguler\JawabanKuisReguler;
use App\Models\KuisReguler\OpsiSoalKuisReguler;
use App\Models\TantanganBulanan\KuisTantanganBulanan;
use App\Models\TantanganBulanan\JawabanTantanganBulanan;
use App\Models\TantanganBulanan\SoalKuisTantanganBulanan;
use App\Models\TantanganBulanan\HasilKuisTantanganBulanan;
use App\Models\TantanganBulanan\OpsiSoalKuisTantanganBulanan;

class KuisDanTantanganController extends Controller
{
    public function index()
    {
        $kuis = KuisReguler::withCount('soal_reguler')
            ->with(['hasil_kuis_reguler' => function ($q) {
                if (Auth::check()) {
                    $q->where('id_user', Auth::user()->id);
                }
            }])->get();

        // Ambil periode leaderboard yang aktif
        $periode = Periode::where('status_leaderboard', 'aktif')->first();

        $tantangan = null;
        $hariTersisa = null;
        $jumlahUser = 0;
        $topUsers = collect();

        if ($periode) {
            // Ambil tantangan yang sedang berlangsung (opsional untuk info di halaman)
            $tantangan = KuisTantanganBulanan::where('id_periode', $periode->id)
                ->where('status', 'aktif')
                ->where('tanggal_mulai', '<=', now())
                ->where('tanggal_selesai', '>=', now())
                ->first();

            $hariTersisa = $tantangan ? Carbon::now()->diffInDays($tantangan->tanggal_selesai, false) : null;

            // Ambil semua id kuis dalam periode aktif
            $kuisIds = KuisTantanganBulanan::where('id_periode', $periode->id)->pluck('id');

            // Hitung peserta unik
            $jumlahUser = HasilKuisTantanganBulanan::whereIn('id_kuis_tantangan_bulanan', $kuisIds)
                ->distinct('id_user')
                ->count('id_user');

            // Ambil top 10 user berdasarkan total skor dari seluruh kuis dalam periode
            $topUsers = HasilKuisTantanganBulanan::select('id_user', DB::raw('SUM(skor) as total_skor'))
                ->whereIn('id_kuis_tantangan_bulanan', $kuisIds)
                ->groupBy('id_user')
                ->orderByDesc('total_skor')
                ->with('user')
                ->take(10)
                ->get();
        }

        return view('kuis-tantangan.index', compact(
            'kuis',
            'tantangan',
            'hariTersisa',
            'jumlahUser',
            'topUsers',
            'periode'
        ));
    }

    public function showSoalKuisReguler($slug)
    {
        $user = Auth::user();
        $kuis = DB::table('kuis_regulers')->where('slug', $slug)->first();

        if (!$kuis) {
            abort(404);
        }

        $startTimeKey = 'quiz_start_time_' . $kuis->id;

        if (!session()->has($startTimeKey)) {
            session([$startTimeKey => now()->timestamp]);
        }


        // Ambil soal dan acak urutannya
        $soal = DB::table('soal_kuis_regulers')
            ->where('id_kuis_reguler', $kuis->id)
            ->select('id', 'gambar', 'soal', 'jawaban', 'tipe_soal')
            ->get()
            ->shuffle() // Acak soal
            ->map(function ($item) {
                if ($item->tipe_soal === 'Pilihan Ganda') {
                    $opsiAsli = DB::table('opsi_soal_kuis_regulers')
                        ->where('id_soal_kuis_reguler', $item->id)
                        ->select('id', 'teks_opsi')
                        ->get()
                        ->shuffle(); // Acak hanya isi teks

                    // Tetapkan ulang label secara urut A, B, C, D...
                    $labels = ['A', 'B', 'C', 'D'];
                    $item->opsi = collect();

                    foreach ($opsiAsli as $index => $opsi) {
                        $item->opsi->push((object)[
                            'id' => $opsi->id,
                            'label' => $labels[$index],
                            'teks_opsi' => $opsi->teks_opsi,
                        ]);
                    }
                } else {
                    $item->opsi = collect();
                }
                return $item;
            });

        return view('kuis-tantangan.soal', [
            'kuis' => $kuis,
            'soal' => $soal,
            'durasi' => $kuis->durasi_menit,
        ]);
    }

    public function submit(Request $request, $slug)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $request->validate([
                'kuis_id' => 'required|exists:kuis_regulers,id',
                'durasi_pengerjaan' => 'required|integer|min:0',
                'start_time_js' => 'required|integer'
            ]);

            $kuis = KuisReguler::findOrFail($request->kuis_id);
            $soalList = SoalKuisReguler::where('id_kuis_reguler', $kuis->id)->get();

            // Hitung skor
            $jawabanBenar = 0;
            $jawabanSalah = 0;
            $jawabanDetails = [];

            foreach ($soalList as $soal) {
                $jawabanUser = $request->input("jawaban_{$soal->id}");
                $isBenar = false;

                if ($soal->tipe_soal === 'Pilihan Ganda') {
                    // Untuk pilihan ganda, bandingkan dengan ID opsi yang benar
                    if ($jawabanUser) {
                        $opsiBenar = OpsiSoalKuisReguler::where('id_soal_kuis_reguler', $soal->id)
                            ->where('label', $soal->jawaban)
                            ->first();

                        if ($opsiBenar && $jawabanUser == $opsiBenar->id) {
                            $isBenar = true;
                            $jawabanBenar++;
                        } else {
                            $jawabanSalah++;
                        }
                    } else {
                        $jawabanSalah++;
                    }
                } else if ($soal->tipe_soal === 'Isian Singkat') {
                    // Untuk isian singkat, bandingkan teks (case-insensitive)
                    if ($jawabanUser && strtolower(trim($jawabanUser)) === strtolower(trim($soal->jawaban))) {
                        $isBenar = true;
                        $jawabanBenar++;
                    } else {
                        $jawabanSalah++;
                    }
                }

                $jawabanDetails[] = [
                    'id_soal' => $soal->id,
                    'jawaban_user' => $jawabanUser ?? '',
                    'benar' => $isBenar
                ];
            }

            // Hitung skor (misalnya dari 0-100)
            $totalSoal = count($soalList);
            $skor = $totalSoal > 0 ? round(($jawabanBenar / $totalSoal) * 100) : 0;

            // Simpan hasil kuis dengan durasi
            $hasilKuis = HasilKuisReguler::create([
                'id_user' => Auth::id(),
                'id_kuis_reguler' => $kuis->id,
                'skor' => $skor,
                'jawaban_benar' => $jawabanBenar,
                'jawaban_salah' => $jawabanSalah,
                'durasi_pengerjaan' => $request->durasi_pengerjaan // Simpan durasi dalam detik
            ]);

            // Simpan detail jawaban
            foreach ($jawabanDetails as $detail) {
                JawabanKuisReguler::create([
                    'id_hasil_kuis_reguler' => $hasilKuis->id,
                    'id_soal_kuis_reguler' => $detail['id_soal'],
                    'jawaban_user' => $detail['jawaban_user'],
                    'benar' => $detail['benar']
                ]);
            }

            DB::commit();

            // Redirect ke halaman hasil
            return redirect()->route('kuis.hasil', ['slug' => $slug, 'hasil_id' => $hasilKuis->id]);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan jawaban: ' . $e->getMessage()]);
        }
    }

    public function hasil($slug, $hasil_id)
    {
        $hasil = HasilKuisReguler::where('id', $hasil_id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        return view('kuis-tantangan.hasil', compact('hasil'));
    }

    public function lihatJawaban($slug, $hasil_id)
    {
        // Ambil data hasil kuis berdasarkan ID
        $hasil = HasilKuisReguler::with(['kuis_reguler', 'user'])
            ->whereHas('kuis_reguler', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->where('id', $hasil_id)
            ->where('id_user', Auth::id()) // Pastikan user hanya bisa melihat hasil sendiri
            ->firstOrFail();

        // Ambil semua soal kuis dengan opsi dan jawaban user
        $soalWithJawaban = SoalKuisReguler::with(['opsi'])
            ->where('id_kuis_reguler', $hasil->id_kuis_reguler)
            ->get()
            ->map(function ($soal) use ($hasil) {
                // Ambil jawaban user untuk soal ini
                $jawabanUser = JawabanKuisReguler::where('id_hasil_kuis_reguler', $hasil->id)
                    ->where('id_soal_kuis_reguler', $soal->id)
                    ->first();

                // Untuk pilihan ganda, cari opsi yang dipilih user
                $opsiTerpilih = null;
                $opsiBenar = null;

                if ($soal->tipe_soal === 'Pilihan Ganda') {
                    // Cari opsi yang dipilih user
                    if ($jawabanUser && is_numeric($jawabanUser->jawaban_user)) {
                        $opsiTerpilih = OpsiSoalKuisReguler::find($jawabanUser->jawaban_user);
                    }

                    // Cari opsi yang benar berdasarkan jawaban soal
                    $opsiBenar = $soal->opsi->firstWhere('label', $soal->jawaban);
                }

                return [
                    'soal' => $soal,
                    'jawaban_user' => $jawabanUser,
                    'opsi_terpilih' => $opsiTerpilih,
                    'opsi_benar' => $opsiBenar,
                    'is_correct' => $jawabanUser ? $jawabanUser->benar : false
                ];
            });

        return view('kuis-tantangan.lihat-jawaban', compact('hasil', 'soalWithJawaban'));
    }

    public function riwayatKuis($slug)
    {
        // Find the quiz by slug
        $kuis = KuisReguler::where('slug', $slug)->firstOrFail();

        // Get user's quiz history for this specific quiz, ordered by latest first
        $riwayatPengerjaan = HasilKuisReguler::where('id_user', Auth::id())
            ->where('id_kuis_reguler', $kuis->id)
            ->with('kuis_reguler')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Calculate statistics
        $totalAttempts = $riwayatPengerjaan->total();
        $bestScore = $riwayatPengerjaan->max('skor') ?? 0;
        $averageScore = $riwayatPengerjaan->avg('skor') ?? 0;
        $latestScore = $riwayatPengerjaan->first()->skor ?? 0;

        return view('kuis-tantangan.riwayat-pengerjaan', compact(
            'kuis',
            'riwayatPengerjaan',
            'totalAttempts',
            'bestScore',
            'averageScore',
            'latestScore'
        ));
    }

    public function showSoalTantanganBulanan($slug)
    {
        $user = Auth::user();
        $kuis = DB::table('kuis_tantangan_bulanans')->where('slug', $slug)->first();

        if (!$kuis) {
            abort(404);
        }

        // Cek apakah user sudah submit kuis ini
        $hasil = HasilKuisTantanganBulanan::with('kuis_tantangan_bulanan')
            ->where('id_user', $user->id)
            ->where('id_kuis_tantangan_bulanan', $kuis->id)
            ->first();

        if ($hasil) {
            return redirect()->route('tantangan-bulanan.hasil', ['slug' => $kuis->slug, 'hasil_id' => $hasil->id]);
        }

        $startTimeKey = 'quiz_start_time_' . $kuis->id;

        if (!session()->has($startTimeKey)) {
            session([$startTimeKey => now()->timestamp]);
        }

        // Ambil soal dan opsi
        $soal = DB::table('soal_kuis_tantangan_bulanans')
            ->where('id_kuis_tantangan_bulanan', $kuis->id)
            ->select('id', 'gambar', 'soal', 'jawaban', 'tipe_soal')
            ->get()
            ->shuffle()
            ->map(function ($item) {
                if ($item->tipe_soal === 'Pilihan Ganda') {
                    $opsiAsli = DB::table('opsi_soal_kuis_tantangan_bulanans')
                        ->where('id_soal_tantangan', $item->id)
                        ->select('id', 'teks_opsi')
                        ->get()
                        ->shuffle();

                    $labels = ['A', 'B', 'C', 'D'];
                    $item->opsi = collect();

                    foreach ($opsiAsli as $index => $opsi) {
                        $item->opsi->push((object) [
                            'id' => $opsi->id,
                            'label' => $labels[$index],
                            'teks_opsi' => $opsi->teks_opsi
                        ]);
                    }
                } else {
                    $item->opsi = collect();
                }
                return $item;
            });

        return view('kuis-tantangan.tantangan-bulanan.soal', [
            'kuis' => $kuis,
            'soal' => $soal,
            'durasi' => $kuis->durasi_menit
        ]);
    }

    public function submitTantanganBulanan(Request $request, $slug)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $request->validate([
                'kuis_id' => 'required|exists:kuis_tantangan_bulanans,id',
                'durasi_pengerjaan' => 'required|integer|min:0',
                'start_time_js' => 'required|integer'
            ]);

            $kuis = KuisTantanganBulanan::findOrFail($request->kuis_id);
            $soalList = SoalKuisTantanganBulanan::where('id_kuis_tantangan_bulanan', $kuis->id)->get();

            // Hitung skor
            $jawabanBenar = 0;
            $jawabanSalah = 0;
            $jawabanDetails = [];

            foreach ($soalList as $soal) {
                $jawabanUser = $request->input("jawaban_{$soal->id}");
                $isBenar = false;

                if ($soal->tipe_soal === 'Pilihan Ganda') {
                    // Untuk pilihan ganda, bandingkan dengan ID opsi yang benar
                    if ($jawabanUser) {
                        $opsiBenar = OpsiSoalKuisTantanganBulanan::where('id_soal_tantangan', $soal->id)
                            ->where('label', $soal->jawaban)
                            ->first();

                        if ($opsiBenar && $jawabanUser == $opsiBenar->id) {
                            $isBenar = true;
                            $jawabanBenar++;
                        } else {
                            $jawabanSalah++;
                        }
                    } else {
                        $jawabanSalah++;
                    }
                } else if ($soal->tipe_soal === 'Isian Singkat') {
                    // Untuk isian singkat, bandingkan teks (case-insensitive)
                    if ($jawabanUser && strtolower(trim($jawabanUser)) === strtolower(trim($soal->jawaban))) {
                        $isBenar = true;
                        $jawabanBenar++;
                    } else {
                        $jawabanSalah++;
                    }
                }

                $jawabanDetails[] = [
                    'id_soal' => $soal->id,
                    'jawaban_user' => $jawabanUser ?? '',
                    'benar' => $isBenar
                ];
            }

            // Hitung skor (misalnya dari 0-100)
            $totalSoal = count($soalList);
            $skor = $totalSoal > 0 ? round(($jawabanBenar / $totalSoal) * 100) : 0;

            // Simpan hasil kuis dengan durasi
            $hasilKuis = HasilKuisTantanganBulanan::create([
                'id_user' => Auth::id(),
                'id_kuis_tantangan_bulanan' => $kuis->id,
                'skor' => $skor,
                'jawaban_benar' => $jawabanBenar,
                'jawaban_salah' => $jawabanSalah,
                'durasi_pengerjaan' => $request->durasi_pengerjaan // Simpan durasi dalam detik
            ]);

            // Simpan detail jawaban
            foreach ($jawabanDetails as $detail) {
                JawabanTantanganBulanan::create([
                    'id_hasil_tantangan_bulanan' => $hasilKuis->id,
                    'id_soal_tantangan_bulanan' => $detail['id_soal'],
                    'jawaban_user' => $detail['jawaban_user'],
                    'benar' => $detail['benar']
                ]);
            }

            DB::commit();

            // Redirect ke halaman hasil
            return redirect()->route('tantangan-bulanan.hasil', ['slug' => $slug, 'hasil_id' => $hasilKuis->id]);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan jawaban: ' . $e->getMessage()]);
        }
    }

    public function hasilTantanganBulanan($slug, $hasil_id)
    {
        $hasil = HasilKuisTantanganBulanan::where('id', $hasil_id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        return view('kuis-tantangan.tantangan-bulanan.hasil', compact('hasil'));
    }
}
