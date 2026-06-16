<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiMagang;
use App\Models\PendaftaranMagang;
use App\Models\PengaturanPresensi;
use App\Models\LogHarianMagangUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class PresensiMagangController extends Controller
{
    /**
     * Halaman presensi
     */
    public function index(Request $request)
    {
        if ($request->has('mobile')) {
            session(['is_mobile' => true]);
        }

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->first();

        $presensiHariIni = null;
        $logHarianHariIni = null;

        if ($pendaftaran) {
            $presensiHariIni = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)
                ->where('tanggal', Carbon::now()->toDateString()) // FIX
                ->first();
            
            $logHarianHariIni = $pendaftaran->log_harian_magang_users()
                ->where('tanggal', Carbon::now()->toDateString())
                ->first();
        }

        $setting = PengaturanPresensi::where('is_active', 1)->first();

        $bolehPulang = true;
        $batasPulang = null;

        if ($setting && $setting->jam_pulang_mulai) {
            $batasPulang = Carbon::today()->setTimeFromTimeString($setting->jam_pulang_mulai);
        }

        return view('presensi.index', compact(
            'presensiHariIni',
            'pendaftaran',
            'bolehPulang',
            'batasPulang',
            'logHarianHariIni',
            'setting'
        ));
    }


    /**
     * Show form page for presensi masuk
     */
    public function formMasuk($pendaftaran = null)
    {
        $user = Auth::user();        
        if ($pendaftaran) {
            $p = PendaftaranMagang::find($pendaftaran);
            if (! $p || $p->user_id !== $user->id || $p->status !== 'diterima') {
                $pendaftaran = null;
            } else {
                $pendaftaran = $p;
            }
        } else {
            $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
                ->where('status', 'diterima')
                ->first();
        }

        $pengaturanList = PengaturanPresensi::with('wilayahBps')
            ->where('is_active', 1)
            ->orderBy('id')
            ->get();
        
        $setting = null;
        if ($pendaftaran && $pendaftaran->wilayah_bps_id) {
            $setting = $pengaturanList->firstWhere('wilayah_bps_id', $pendaftaran->wilayah_bps_id);
        }
        if (! $setting) {
            $setting = $pengaturanList->first();
        }

        $now = Carbon::now();

        $terlambat = false;
        if ($setting && $setting->jam_masuk_selesai && $now->gt(Carbon::parse($setting->jam_masuk_selesai))) {
            $terlambat = true;
        }

        $diLuarRadius = false;

        $wajibKeterangan = $terlambat || $diLuarRadius;        
        $serverDate = $now->format('d-m-Y');
        $serverTime = $now->format('H:i:s');

        return view('presensi.masuk', compact(
            'pendaftaran',
            'pengaturanList',
            'setting',
            'serverDate',
            'serverTime',
            'terlambat',
            'diLuarRadius',  
            'wajibKeterangan'
        ));
    }


    /**
     * Show form page for presensi pulang
     */
    public function formPulang($pendaftaran = null)
    {
        $user = Auth::user();
        
        if ($pendaftaran) {
            $p = PendaftaranMagang::find($pendaftaran);
            if (! $p || $p->user_id !== $user->id || $p->status !== 'diterima') {
                $pendaftaran = null;
            } else {
                $pendaftaran = $p;
            }
        } else {
            $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
                ->where('status', 'diterima')
                ->first();
        }
    
        $presensiHariIni = null;
        if ($pendaftaran) {
            $presensiHariIni = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();
        }
        
        $pengaturanList = PengaturanPresensi::with('wilayahBps')
            ->where('is_active', 1)
            ->orderBy('id')
            ->get();

        $setting = null;
        if ($pendaftaran && $pendaftaran->wilayah_bps_id) {
            $setting = $pengaturanList->firstWhere('wilayah_bps_id', $pendaftaran->wilayah_bps_id);
        }
        if (! $setting) {
            $setting = $pengaturanList->first();
        }

        $now = Carbon::now();

        $pulangCepat = false;
        if ($setting && $setting->jam_pulang_mulai &&
            $now->lt(Carbon::today()->setTimeFromTimeString($setting->jam_pulang_mulai))) {
            $pulangCepat = true;
        }

        $diLuarRadius = false;
        $wajibKeterangan = $pulangCepat || $diLuarRadius;

        $serverDate = $now->format('d-m-Y');
        $serverTime = $now->format('H:i:s');

        return view('presensi.pulang', compact(
            'pendaftaran',
            'presensiHariIni',
            'pengaturanList',
            'setting',
            'serverDate',
            'serverTime',
            'pulangCepat',
            'diLuarRadius',
            'wajibKeterangan'
        ));
    }



    /**
     * User: lihat riwayat presensi (own pendaftaran)
     */
    public function history()
    {
        $user = Auth::user();
        $pendaftaran = PendaftaranMagang::where('user_id', $user->id)->where('status', 'diterima')->first();
        if (! $pendaftaran) {
            return back()->with('error', 'Anda belum memiliki pendaftaran magang yang diterima.');
        }

        $presensis = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)->orderBy('tanggal', 'desc')->get();
        return view('presensi.history', compact('pendaftaran', 'presensis'));
    }

    /**
     * Admin: lihat daftar hadir peserta untuk pendaftaran tertentu
     */
    public function adminIndex($pendaftaran_id)
    {
        $pendaftaran = PendaftaranMagang::findOrFail($pendaftaran_id);
        $presensis = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)->orderBy('tanggal', 'desc')->get();
        return view('admin.pendaftaran-magang.presensi-magang', compact('pendaftaran', 'presensis'));
    }

    /**
     * Presensi Masuk
     */
    public function presensiMasuk(Request $request)
    {
        $request->validate([
            'pengaturan_presensi_id' => 'required|exists:pengaturan_presensi,id',
            'lat_masuk'  => 'required|numeric',
            'long_masuk' => 'required|numeric',
            'keterangan_masuk' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();

            $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
                ->where('status', 'diterima')
                ->firstOrFail();

            $today = Carbon::today();

            // cek sudah presensi
            $cek = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)
                ->whereDate('tanggal', $today)
                ->first();

            if ($cek) {
                return redirect()->route('daftar-magang.presensi')
                    ->with('error', 'Anda sudah presensi masuk hari ini.');
            }

            $setting = PengaturanPresensi::findOrFail($request->input('pengaturan_presensi_id'));

            $now = Carbon::now();

            // TERLAMBAT
            $jamBatasMasuk = Carbon::today()->setTimeFromTimeString($setting->jam_masuk_selesai);
            $terlambat = $now->gt($jamBatasMasuk);

            // RADIUS
            $jarak = $this->hitungJarak(
                $request->lat_masuk,
                $request->long_masuk,
                $setting->lat_kantor,
                $setting->long_kantor
            );

            $diLuarRadius = $jarak > (float) $setting->radius_kantor;

            // STATUS
            $statusMasuk = 'tepat_waktu';

            if ($terlambat && $diLuarRadius) {
                $statusMasuk = 'terlambat_luar_area';
            } elseif ($terlambat) {
                $statusMasuk = 'terlambat';
            } elseif ($diLuarRadius) {
                $statusMasuk = 'luar_area';
            }

            // WAJIB KETERANGAN
            if (($terlambat || $diLuarRadius) && !$request->filled('keterangan_masuk')) {
                return back()
                    ->withInput()
                    ->with('alert', 'Anda terlambat atau di luar area kantor. Keterangan wajib diisi!');
            }

            // SIMPAN PRESENSI
            PresensiMagang::create([
                'id_pendaftaran_magang' => $pendaftaran->id,
                'tanggal'               => $today,
                'jam_masuk'             => $now->format('H:i:s'),
                'lat_masuk'             => $request->lat_masuk,
                'long_masuk'            => $request->long_masuk,
                'keterangan_masuk'      => $request->keterangan_masuk,
                'status_masuk'          => $statusMasuk,
            ]);

            // BUAT LOG KOSONG TANPA JAM
            LogHarianMagangUser::firstOrCreate(
                [
                    'id_pendaftaran_magang' => $pendaftaran->id,
                    'tanggal' => $today
                ],
                [
                    'status_kehadiran' => 'draft'
                ]
            );

            DB::commit();

            return redirect()->route('daftar-magang.presensi')
                ->with('success', 'Presensi masuk berhasil.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Presensi masuk gagal. ' . $e->getMessage());
        }
    }


    /**
     * Presensi Pulang
     */
    public function presensiPulang(Request $request)
    {
        $request->validate([            
            'lat_pulang'  => 'required|numeric',
            'long_pulang' => 'required|numeric',
            'keterangan_pulang' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();

            $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
                ->where('status', 'diterima')
                ->firstOrFail();

            $today = Carbon::today();

            $presensi = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)
                ->whereDate('tanggal', $today)
                ->first();

            if (!$presensi) {
                return redirect()->route('daftar-magang.presensi')
                    ->with('error', 'Anda belum melakukan presensi masuk hari ini.');
            }

            $setting = PengaturanPresensi::findOrFail($request->input('pengaturan_presensi_id'));

            $now = Carbon::now();
            $pulangCepat = false;
            if ($setting->jam_pulang_mulai &&
                $now->lt(Carbon::today()->setTimeFromTimeString($setting->jam_pulang_mulai))) {
                $pulangCepat = true;
            }

            $jarak = $this->hitungJarak(
                $request->lat_pulang,
                $request->long_pulang,
                $setting->lat_kantor,
                $setting->long_kantor
            );

            $diLuarRadius = $jarak > (float) $setting->radius_kantor;
            $statusPulang = 'tepat_waktu';

            if ($pulangCepat && $diLuarRadius) {
                $statusPulang = 'pulang_cepat_luar_area';
            } elseif ($pulangCepat) {
                $statusPulang = 'pulang_cepat';
            } elseif ($diLuarRadius) {
                $statusPulang = 'luar_area';
            }

            if (($pulangCepat || $diLuarRadius) && !$request->filled('keterangan_pulang')) {
                return back()
                    ->withInput()
                    ->with('alert', 'Anda pulang sebelum jam kerja atau berada di luar area kantor. Keterangan wajib diisi!');
            }

            $isUpdate = $presensi->jam_pulang ? true : false;

            $presensi->update([
                'jam_pulang'        => $now->format('H:i:s'),
                'lat_pulang'        => $request->lat_pulang,
                'long_pulang'       => $request->long_pulang,
                'keterangan_pulang' => $request->keterangan_pulang,
                'status_pulang'     => $statusPulang,
            ]);

            LogHarianMagangUser::firstOrCreate(
                [
                    'id_pendaftaran_magang' => $pendaftaran->id,
                    'tanggal' => $today
                ],
                [
                    'status_kehadiran' => 'draft'
                ]
            );

            DB::commit();

            return redirect()->route('daftar-magang.presensi')
                ->with('success', $isUpdate
                    ? 'Presensi pulang berhasil diperbarui.'
                    : 'Presensi pulang berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Presensi pulang gagal. ' . $e->getMessage());
        }
    }


    /**
     * Hitung jarak user ke kantor (Radius)
     */
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    } 

}
