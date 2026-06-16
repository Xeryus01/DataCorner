<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformasiMagang;
use App\Models\PendaftaranMagang;
use App\Models\LogHarianMagangUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Container\Attributes\Log;
use App\Mail\NotifikasiLogHarianMagangUser;
use App\Models\PresensiMagang;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LogHarianMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
     public function index(Request $request)
    {
        $user = Auth::user();
        
        $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->firstOrFail();
        
        $query = LogHarianMagangUser::where(
            'id_pendaftaran_magang',
            $pendaftaran->id
        );

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        if (! $request->filled('start_date') && ! $request->filled('end_date')) {
            $query->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);
        }

        if ($request->filled('status')) {
            $query->where('status_kehadiran', $request->status);
        }
        
        $logs = $query
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('program-magang.log-harian', compact('logs'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->firstOrFail();
    
        $tanggal = $request->query('tanggal', now()->toDateString());

        $presensi = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        $log = LogHarianMagangUser::where('id_pendaftaran_magang', $pendaftaran->id)
        ->whereDate('tanggal', $tanggal)
        ->first();

        return view('program-magang.create-log', compact('pendaftaran', 'presensi', 'log', 'tanggal'));
    }

    public function store(Request $request)
    {                
        $user = Auth::user();
        $request->validate([
            'tanggal' => [
                'required',
                'date',
                'after_or_equal:' . now()->startOfMonth()->toDateString(),
                'before_or_equal:' . now()->endOfMonth()->toDateString(),
            ],
        ]);

        $tanggal = $request->tanggal;        
        if ($request->status_kehadiran === 'izin') {
            $request->validate([
                'uraian_kegiatan' => 'nullable',
                'catatan' => 'nullable',
                'status_kehadiran' => 'required|in:izin',
                'bukti_izin' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', 
            ]);
        }elseif ($request->status_kehadiran === 'tanpa_keterangan') {
            $request->validate([
                'uraian_kegiatan' => 'nullable',
                'catatan' => 'nullable',
                'status_kehadiran' => 'required|in:tanpa_keterangan',
            ]);
        }
        else {
            $request->validate([
                'uraian_kegiatan' => 'required',
                'catatan' => 'nullable',
                'status_kehadiran' => 'nullable',
            ]);
        }        

        $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->firstOrFail();
        
        // ambil presensi hari ini
        $presensi = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        $buktiPath = null;
        if ($request->status_kehadiran === 'izin' && $request->hasFile('bukti_izin')) {
            $buktiPath = $request->file('bukti_izin')->store('bukti_izin', 'public');
        }
        
        if (in_array($request->status_kehadiran, ['izin', 'tanpa_keterangan'])) {
            LogHarianMagangUser::updateOrCreate(
                [
                    'id_pendaftaran_magang' => $pendaftaran->id,
                    'tanggal' => $tanggal,
                ],
                [
                    'uraian_kegiatan' => $request->uraian_kegiatan,
                    'catatan' => $request->catatan,
                    'status_kehadiran' => $request->status_kehadiran,
                    'bukti_izin' => $buktiPath, // simpan path bukti izin jika ada
                ]
            );

            return redirect()->route('daftar-magang.log-harian')
                ->with('success', 'Log harian berhasil disimpan (Izin/Tanpa Keterangan).');            
        }
        
        if (!$presensi || !$presensi->jam_masuk) {
            return back()->with('error', 'Anda harus presensi masuk terlebih dahulu.');
        }

        LogHarianMagangUser::updateOrCreate(
            [
                'id_pendaftaran_magang' => $pendaftaran->id,
                'tanggal' => $tanggal,
            ],
            [
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'catatan' => $request->catatan,
                'status_kehadiran' => 'hadir',
            ]
        );

            return redirect()->route('daftar-magang.log-harian')
                ->with('success', 'Log harian berhasil disimpan dan kehadiran tercatat.');           
    } 

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $log = LogHarianMagangUser::findOrFail($id);
        return view('program-magang.show-log', compact('log'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $log = LogHarianMagangUser::with('pendaftaran_magang')
            ->where('id', $id)
            ->whereHas('pendaftaran_magang', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();
        
        if (! $log) {
            return redirect()->route('daftar-magang.log-harian')
                ->with('error', 'Log tidak ditemukan.');
        }

        //hanya bisa edit jika status verifikasi masih pending atau revisi  
        if (!in_array($log->status_verifikasi, ['pending', 'revisi'])) {

            if ($log->status_verifikasi == 'disetujui') {
                $pesan = 'Log harian tidak dapat diedit karena sudah disetujui oleh admin.';
            } elseif ($log->status_verifikasi == 'ditolak') {
                $pesan = 'Log harian tidak dapat diedit karena telah ditolak oleh admin.';
            } else {
                $pesan = 'Log harian tidak dapat diedit.';
            }

            return redirect()
                ->route('daftar-magang.log-harian')
                ->with('error', $pesan);
        }

        return view('program-magang.edit-log', compact('log'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $log = LogHarianMagangUser::findOrFail($id);

        // hanya pending dan revisi yang boleh update
        if (!in_array($log->status_verifikasi, ['pending', 'revisi'])) {
            return redirect()->route('daftar-magang.log-harian')
                ->with('error', 'Log ini tidak dapat diperbarui.');
        }

        // rule dasar
        $rules = [
            'id_pendaftaran_magang' => 'required|exists:pendaftaran_magangs,id',
            'tanggal' => 'required|date',
            'status_kehadiran' => 'required|in:hadir,izin,tanpa_keterangan',
            'catatan' => 'nullable',
        ];

        // jika hadir → wajib isi uraian
        if ($request->status_kehadiran == 'hadir') {
            $rules['uraian_kegiatan'] = 'required';
        } else {
            $rules['uraian_kegiatan'] = 'nullable';
        }

        if ($request->status_kehadiran === 'izin') {
            $rules['bukti_izin'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'; // wajib upload bukti jika pilih izin
        }

        $request->validate($rules);

        $log = LogHarianMagangUser::findOrFail($id);
        $data = [
            'id_pendaftaran_magang' => $request->id_pendaftaran_magang,
            'tanggal' => $request->tanggal,
            'status_kehadiran' => $request->status_kehadiran,
            'uraian_kegiatan' => $request->uraian_kegiatan,
            'catatan' => $request->catatan,
        ];

        if ($request->status_kehadiran === 'izin' && $request->hasFile('bukti_izin')){
            $data['bukti_izin'] = $request->file('bukti_izin')->store('bukti_izin', 'public');
        }

        if ($request->status_kehadiran !== 'izin') {
            $data['bukti_izin'] = null; // hapus bukti izin jika status bukan izin
        }

        // jika sebelumnya revisi, maka reset ke pending saat update
        if ($log->status_verifikasi === 'revisi') {
            $data['status_verifikasi'] = 'pending';
        }

        $log->update($data);

        return redirect()->route('daftar-magang.log-harian')
            ->with('success', 'Log harian berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        LogHarianMagangUser::findOrFail($id)->delete();
        return redirect()->route('daftar-magang.log-harian')
            ->with('success', 'Log harian berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        $pendaftaran = PendaftaranMagang::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->firstOrFail();

        $presensi = PresensiMagang::where('id_pendaftaran_magang', $pendaftaran->id)->get();

        $logs = LogHarianMagangUser::where('id_pendaftaran_magang', $pendaftaran->id)
            ->when($request->start_date, function ($query) use ($request) {
                $query->whereDate('tanggal', '>=', $request->start_date);
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->whereDate('tanggal', '<=', $request->end_date);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status_kehadiran', $request->status);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('program-magang.log-harian-pdf', compact('logs', 'presensi'));

        // Format tanggal untuk nama file
        $start = $request->start_date
            ? Carbon::parse($request->start_date)->format('d-m-Y')
            : 'awal';

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->format('d-m-Y')
            : 'akhir';

        $filename = "riwayat-log-{$start}_sampai_{$end}.pdf";

        return $pdf->stream($filename);
    }
}
