<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\MailMagangDitolak;
use App\Models\InformasiMagang;
use App\Mail\MailMagangDiterima;
use App\Models\PendaftaranMagang;
use App\Mail\SertifikatMagangMail;
use App\Mail\NotifikasiMagangAdmin;
use App\Models\LogHarianMagangUser;
use App\Models\PresensiMagang;
use App\Models\WilayahBps;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Colors\Rgb\Channels\Red;
use App\Mail\PendaftaranMagang as MailPendaftaranMagang;

class PendaftaranMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->first();
            
        $wilayahBps = WilayahBps::orderBy('nama_wilayah')->get();

        return view('program-magang.daftar-magang', compact('pendaftaran', 'wilayahBps'));
    }
    
    public function index_admin(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        $pendaftaran = PendaftaranMagang::when($search, function ($query, $search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->where('status', 'diproses')            
            ->when(
                in_array($user->getRoleNames()->first(), ['operator magang', 'operator kepegawaian']),
                function ($query) use ($user) {
                    $query->where('wilayah_bps_id', $user->wilayah_id);
                }
            )

            ->latest()
            ->paginate(10);

        return view('admin.pendaftaran-magang.index', compact('pendaftaran'));
    }
        
    public function magangDiterima(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        $pendaftaran = PendaftaranMagang::when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
            ->where('status', 'diterima')    
            ->when(
                in_array($user->getRoleNames()->first(), ['operator magang', 'operator kepegawaian']),
                function ($query) use ($user) {
                    $query->where('wilayah_bps_id', $user->wilayah_id);
                }
            )
            ->latest()
            ->paginate(10);
        return view('admin.pendaftaran-magang.pendaftar-diterima', compact('pendaftaran'));
    }

    public function magangDitolak(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        $pendaftaran = PendaftaranMagang::when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
            ->where('status', 'ditolak')
            ->when(
                in_array($user->getRoleNames()->first(), ['operator magang', 'operator kepegawaian']),
                function ($query) use ($user) {
                    $query->where('wilayah_bps_id', $user->wilayah_id);
                }
            )
            ->latest()
            ->paginate(10);
        return view('admin.pendaftaran-magang.pendaftar-ditolak', compact('pendaftaran'));
    }

    public function riwayatMagang(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        $pendaftaran = PendaftaranMagang::when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
            ->where('status', 'selesai')
            ->when(
                in_array($user->getRoleNames()->first(), ['operator magang', 'operator kepegawaian']),
                function ($query) use ($user) {
                    $query->where('wilayah_bps_id', $user->wilayah_id);
                }
            )   
            ->latest()
            ->paginate(10);
        return view('admin.pendaftaran-magang.riwayat-pendaftar', compact('pendaftaran'));
    } 

    public function logHarian($pendaftaran_id)
    {
        $user = Auth::user();
        $pendaftaran = PendaftaranMagang::findOrFail($pendaftaran_id);
        
        if (in_array($user->getRoleNames()->first(), ['operator magang', 'operator kepegawaian'])) {
            if ($pendaftaran->wilayah_bps_id != $user->wilayah_id) {
                abort(403, 'Tidak punya akses');
            }
        }

        $logs = LogHarianMagangUser::where('id_pendaftaran_magang', $pendaftaran_id)
            ->where('status_verifikasi', 'disetujui')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        $verifikasi = LogHarianMagangUser::where('id_pendaftaran_magang', $pendaftaran_id)
            ->where('status_verifikasi', 'pending')
            ->get();
        
        $presensis = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran_id)
            ->get()
            ->keyBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        return view(
            'admin.pendaftaran-magang.log-harian',
            compact('logs', 'pendaftaran', 'verifikasi', 'presensis')
        );
    }   

    public function verifikasiSetuju($id)
    {
        $user = Auth::user();

        $log = LogHarianMagangUser::findOrFail($id);
        $pendaftaran = PendaftaranMagang::findOrFail($log->id_pendaftaran_magang);
        
        if (in_array($user->getRoleNames()->first(), ['operator magang', 'operator kepegawaian'])) {
            if ($pendaftaran->wilayah_bps_id != $user->wilayah_id) {
                abort(403);
            }
        }

        $log->update(['status_verifikasi' => 'disetujui']);

        return redirect()->back();
    }

    public function verifikasiRevisi($id)
    {
        LogHarianMagangUser::where('id', $id)->update(['status_verifikasi' => 'revisi']);
        return redirect()->back();
    }

    public function verifikasiTolak($id)
    {
        LogHarianMagangUser::where('id', $id)->update(['status_verifikasi' => 'ditolak']);
        return redirect()->back();
    }

    public function presensiMagang($pendaftaran_id)
    {
        $user = Auth::user();
        
        $pendaftaran = PendaftaranMagang::findOrFail($pendaftaran_id);
        
        if (in_array($user->getRoleNames()->first(), ['operator magang', 'operator kepegawaian'])) {
            if ($pendaftaran->wilayah_bps_id != $user->wilayah_id) {
                abort(403, 'Tidak punya akses');
            }
        }
        
        $logs = PresensiMagang::with('pendaftaran_magang')
            ->where('id_pendaftaran_magang', $pendaftaran_id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view(
            'admin.pendaftaran-magang.presensi-magang',
            compact('logs', 'pendaftaran')
        );
    }

    public function detailLog($id)
    {
        $user = Auth::user();
        $log = LogHarianMagangUser::where('id', $id)
        ->firstOrFail();

        $pendaftaran = PendaftaranMagang::findOrFail($log->id_pendaftaran_magang);        
        if (in_array($user->getRoleNames()->first(), ['operator magang', 'operator kepegawaian'])) {
            if ($pendaftaran->wilayah_bps_id != $user->wilayah_id) {
                abort(403, 'Tidak punya akses');
            }
        }

        $presensi = PresensiMagang::where('id_pendaftaran_magang', $log->id_pendaftaran_magang)
            ->whereDate('tanggal', $log->tanggal)
            ->first();

        return view(
            'admin.pendaftaran-magang.detail-log-harian',
            compact('log', 'presensi')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = Auth::user();

        $existingPendaftaran = PendaftaranMagang::where('user_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->first();

        if ($existingPendaftaran) {
            return redirect()->route('daftar-magang.index')
                ->with('error', 'Anda sudah memiliki pendaftaran yang sedang diproses.');
        }

        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'wilayah_bps_id' => 'required|exists:wilayah_bps,id',
            'is_difabel' => 'nullable|boolean',
            'surat_permohonan' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB
            'surat_motivasi' => 'nullable|string',
            'is_agreed' => 'required|accepted',
        ]);

        $fileCV = $request->file('cv_file')->store('cv_magang_user', 'public');
        $filePermohonan = $request->file('surat_permohonan')->store('surat_permohonan_magang_user', 'public');
        
        $pendaftaran = PendaftaranMagang::create([
            'user_id' => $user->id,
            'wilayah_bps_id' => $request->wilayah_bps_id,
            'is_difabel' => $request->boolean('is_difabel'),
            'nama' => $user->name,
            'email' => $user->email,
            'no_hp' => $user->no_hp,
            'cv_file' => $fileCV,
            'surat_permohonan' => $filePermohonan,
            'surat_motivasi' => $request->surat_motivasi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'diproses', // status default
            'is_agreed' => true,
            'agreed_at' => now(),
        ]);

        Mail::to($pendaftaran->email)->queue(new MailPendaftaranMagang($pendaftaran));
        Mail::to(env('ADMIN_EMAIL'))->queue(new NotifikasiMagangAdmin($pendaftaran));

        return redirect()->route('daftar-magang.index')
            ->with('success', 'Pendaftaran berhasil dikirim!');
    }

    public function uploadLaporan(Request $request, PendaftaranMagang $pendaftaran_magang)
    {
        $request->validate([
            'laporan_magang' => 'required|file|mimes:pdf',
        ]);

        if ($pendaftaran_magang->laporan_magang) {
            Storage::disk('public')->delete($pendaftaran_magang->laporan_magang);
        }

        $file = $request->file('laporan_magang');
        $namaFile = Auth::user()->slug . '.' . $file->getClientOriginalName();

        $filePath = $file->storeAs('laporan_magang', $namaFile, 'public');

        $pendaftaran_magang->update([
            'laporan_magang' => $filePath,
        ]);

        return redirect()->route('daftar-magang.index')->with('success', 'Laporan Magang berhasil diunggah');
    }

    public function hapusLaporan(PendaftaranMagang $pendaftaran_magang)
    {
        Storage::disk('public')->delete($pendaftaran_magang->laporan_magang);
        $pendaftaran_magang->laporan_magang = null;
        $pendaftaran_magang->save();
        return redirect()->route('daftar-magang.index')->with('success', 'Laporan Magang berhasil dihapus');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PendaftaranMagang $pendaftaran_magang)
    {
        return view('admin.pendaftaran-magang.edit', compact('pendaftaran_magang'));
    }

    public function editDiterima(PendaftaranMagang $pendaftaran_magang)
    {
        return view('admin.pendaftaran-magang.edit-diterima', compact('pendaftaran_magang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PendaftaranMagang $pendaftaran_magang)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $statusLama = $pendaftaran_magang->status;
        $statusBaru = $request->status;

        // Update status
        $pendaftaran_magang->update([
            'status' => $statusBaru,
        ]);


        // Kirim email hanya jika status berubah dari 'diproses' ke 'diterima' atau 'ditolak'
        if ($statusLama === 'diproses' && in_array($statusBaru, ['diterima', 'ditolak'])) {
            if ($statusBaru === 'diterima') {
                // Kirim email diterima
                Mail::to($pendaftaran_magang->email)->queue(new MailMagangDiterima($pendaftaran_magang));
            } elseif ($statusBaru === 'ditolak') {
                // Kirim email ditolak
                Mail::to($pendaftaran_magang->email)->queue(new MailMagangDitolak($pendaftaran_magang));
            }
        }

        if ($statusLama === 'diterima' && $statusBaru === 'selesai') {
            return redirect()->route('admin_daftar-magang.magangDiterima')->with('success', 'Status pendaftaran berhasil diperbarui');
        } else if ($statusLama === 'ditolak' && $statusBaru === 'selesai') {
            return redirect()->route('admin_daftar-magang.magangDitolak')->with('success', 'Status pendaftaran berhasil diperbarui');
        } else {
            return redirect()->route('admin_daftar-magang.index-admin')->with('success', 'Status pendaftaran berhasil diperbarui');
        }
    }

    public function editSertifikat(PendaftaranMagang $pendaftaran_magang)
    {
        return view('admin.pendaftaran-magang.upload-sertifikat', compact('pendaftaran_magang'));
    }


    public function uploadSertifikat(Request $request, PendaftaranMagang $pendaftaran_magang)
    {
        $request->validate([
            'sertifikat_magang' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        if ($pendaftaran_magang->sertifikat_magang) {
            Storage::disk('public')->delete($pendaftaran_magang->sertifikat_magang);
        }

        $file = $request->file('sertifikat_magang')->store('sertifikat_magang_user', 'public');

        $pendaftaran_magang->update([
            'sertifikat_magang' => $file,
        ]);

        Mail::to($pendaftaran_magang->email)->queue(new SertifikatMagangMail($pendaftaran_magang));

        return redirect()->route('admin_daftar-magang.riwayatMagang')->with('success', 'Sertifikat Magang berhasil diunggah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PendaftaranMagang $pendaftaran_magang)
    {
        Storage::disk('public')->delete($pendaftaran_magang->cv_file);
        Storage::disk('public')->delete($pendaftaran_magang->surat_permohonan);
        $pendaftaran_magang->delete();
        return redirect()->route('admin_daftar-magang.index-admin')->with('success', 'Data Pendaftar Magang berhasil dihapus');
    }
}
