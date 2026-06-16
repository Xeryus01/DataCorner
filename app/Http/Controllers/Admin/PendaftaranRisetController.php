<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Mail\MailRisetDitolak;
use App\Mail\MailRisetDiterima;
use App\Models\PendaftaranRiset;
use App\Mail\SertifikatRisetMail;
use App\Mail\MailPendaftaranRiset;
use App\Mail\NotifikasiRisetAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PendaftaranRisetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Cek apakah user sudah pernah mendaftar dan statusnya belum selesai
        $pendaftaran = PendaftaranRiset::where('user_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->first();

        return view('program-riset.daftar-riset', compact('pendaftaran'));
    }

    public function index_admin(Request $request)
    {
        $search = $request->input('search');
        $pendaftaran = PendaftaranRiset::when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
            ->where('status', 'diproses')
            ->latest()
            ->paginate(10);
        return view('admin.pendaftaran-riset.index', compact('pendaftaran'));
    }

    public function risetDiterima(Request $request)
    {
        $search = $request->input('search');
        $pendaftaran = PendaftaranRiset::when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
            ->where('status', 'diterima')
            ->latest()
            ->paginate(10);
        return view('admin.pendaftaran-riset.pendaftar-diterima', compact('pendaftaran'));
    }

    public function risetDitolak(Request $request)
    {
        $search = $request->input('search');
        $pendaftaran = PendaftaranRiset::when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
            ->where('status', 'ditolak')
            ->latest()
            ->paginate(10);
        return view('admin.pendaftaran-riset.pendaftar-ditolak', compact('pendaftaran'));
    }

    public function riwayatRiset(Request $request)
    {
        $search = $request->input('search');
        $pendaftaran = PendaftaranRiset::when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
            ->where('status', 'selesai')
            ->latest()
            ->paginate(10);
        return view('admin.pendaftaran-riset.riwayat-pendaftar', compact('pendaftaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();


        // Cek apakah user sudah pernah mendaftar dan statusnya belum selesai
        $existingPendaftaran = PendaftaranRiset::where('user_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->first();

        if ($existingPendaftaran) {
            return redirect()->route('daftar-riset.index')
                ->with('error', 'Anda sudah memiliki pendaftaran yang sedang diproses.');
        }

        $request->validate([
            'judul_riset' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'surat_permohonan' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB
            'surat_motivasi' => 'nullable|string',
            'is_agreed' => 'required|accepted',
        ]);

        $fileCV = $request->file('cv_file')->store('cv_riset_user', 'public');
        $filePermohonan = $request->file('surat_permohonan')->store('surat_permohonan_riset_user', 'public');

        // Simpan data pendaftaran
        $pendaftaran = PendaftaranRiset::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'judul_riset' => $request->judul_riset,
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

        Mail::to($pendaftaran->email)->queue(new MailPendaftaranRiset($pendaftaran));
        Mail::to(env('ADMIN_EMAIL'))->queue(new NotifikasiRisetAdmin($pendaftaran));

        return redirect()->route('daftar-riset.index')
            ->with('success', 'Pendaftaran berhasil dikirim!');
    }

    public function uploadLaporan(Request $request, PendaftaranRiset $pendaftaran_riset)
    {
        $request->validate([
            'laporan_riset' => 'required|file|mimes:pdf',
        ]);

        if ($pendaftaran_riset->laporan_riset) {
            Storage::disk('public')->delete($pendaftaran_riset->laporan_riset);
        }

        $file = $request->file('laporan_riset');
        $namaFile = Auth::user()->slug . '.' . $file->getClientOriginalName();

        $filePath = $file->storeAs('laporan_riset', $namaFile, 'public');

        $pendaftaran_riset->update([
            'laporan_riset' => $filePath,
        ]);

        return redirect()->route('daftar-riset.index')->with('success', 'Laporan Riset berhasil diunggah');
    }

    public function hapusLaporan(PendaftaranRiset $pendaftaran_riset)
    {
        Storage::disk('public')->delete($pendaftaran_riset->laporan_riset);
        $pendaftaran_riset->laporan_riset = null;
        $pendaftaran_riset->save();
        return redirect()->route('daftar-riset.index')->with('success', 'Laporan Riset berhasil dihapus');
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
    public function edit(PendaftaranRiset $pendaftaran_riset)
    {
        return view('admin.pendaftaran-riset.edit', compact('pendaftaran_riset'));
    }

    public function editDiterima(PendaftaranRiset $pendaftaran_riset)
    {
        return view('admin.pendaftaran-riset.edit-diterima', compact('pendaftaran_riset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PendaftaranRiset $pendaftaran_riset)
    {
        $request->validate([
            'status' => 'required',
        ]);

        // Simpan status lama untuk pengecekan
        $statusLama = $pendaftaran_riset->status;
        $statusBaru = $request->status;

        // Update status
        $pendaftaran_riset->update([
            'status' => $statusBaru,
        ]);


        // Kirim email hanya jika status berubah dari 'diproses' ke 'diterima' atau 'ditolak'
        if ($statusLama === 'diproses' && in_array($statusBaru, ['diterima', 'ditolak'])) {
            if ($statusBaru === 'diterima') {
                // Kirim email diterima
                Mail::to($pendaftaran_riset->email)->queue(new MailRisetDiterima($pendaftaran_riset));
            } elseif ($statusBaru === 'ditolak') {
                // Kirim email ditolak
                Mail::to($pendaftaran_riset->email)->queue(new MailRisetDitolak($pendaftaran_riset));
            }
        }

        if ($statusLama === 'diterima' && $statusBaru === 'selesai') {
            return redirect()->route('admin_daftar-riset.risetDiterima')->with('success', 'Status pendaftaran berhasil diperbarui');
        } else if ($statusLama === 'ditolak' && $statusBaru === 'selesai') {
            return redirect()->route('admin_daftar-riset.risetDitolak')->with('success', 'Status pendaftaran berhasil diperbarui');
        } else {
            return redirect()->route('admin_daftar-riset.index-admin')->with('success', 'Status pendaftaran berhasil diperbarui');
        }
    }

    public function editSertifikat(PendaftaranRiset $pendaftaran_riset)
    {
        return view('admin.pendaftaran-riset.upload-sertifikat', compact('pendaftaran_riset'));
    }


    public function uploadSertifikat(Request $request, PendaftaranRiset $pendaftaran_riset)
    {
        $request->validate([
            'sertifikat_riset' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        if ($pendaftaran_riset->sertifikat_riset) {
            Storage::disk('public')->delete($pendaftaran_riset->sertifikat_riset);
        }

        $file = $request->file('sertifikat_riset')->store('sertifikat_riset_user', 'public');

        $pendaftaran_riset->update([
            'sertifikat_riset' => $file,
        ]);

        Mail::to($pendaftaran_riset->email)->queue(new SertifikatRisetMail($pendaftaran_riset));

        return redirect()->route('admin_daftar-riset.riwayatRiset')->with('success', 'Sertifikat Riset berhasil diunggah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PendaftaranRiset $pendaftaran_riset)
    {
        Storage::disk('public')->delete($pendaftaran_riset->cv_file);
        Storage::disk('public')->delete($pendaftaran_riset->surat_permohonan);
        $pendaftaran_riset->delete();
        return redirect()->route('admin_daftar-riset.index-admin')->with('success', 'Data Pendaftar Kolaborasi Riset berhasil dihapus');
    }
}
