<?php

namespace App\Http\Controllers;

use App\Models\jadwal;
use App\Models\janjitemu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class konsultanJadwalController extends Controller
{
    public function index()
    {
        $konsultanId = Session::get('konsultan_id');

        $jadwals = jadwal::with('janjitemu.user')
                    ->where('konsultan_id', $konsultanId)
                    ->whereNotNull('konsultan_id')
                    ->get();

        return view('jadwal.index', compact('jadwals'));
    }

    /**
     * Mengembalikan detail janji temu dalam format JSON (untuk modal).
     */
    public function detail($id)
    {
        $konsultanId = Session::get('konsultan_id');

        $janji = janjitemu::with('user')
            ->whereHas('jadwal', function ($q) use ($konsultanId) {
                $q->where('konsultan_id', $konsultanId);
            })
            ->find($id);

        if (!$janji) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        return response()->json($janji);
    }

    /**
     * Konsultan mengirim link Zoom ke user.
     */
    public function kirimZoom(Request $request, $id)
    {
        $request->validate([
            'link_zoom' => 'required|url',
        ]);

        $konsultanId = Session::get('konsultan_id');

        $janji = janjitemu::with('user')
            ->whereHas('jadwal', function ($q) use ($konsultanId) {
                $q->where('konsultan_id', $konsultanId);
            })
            ->findOrFail($id);

        $janji->update([
            'zoom_link' => $request->link_zoom,
        ]);

        $namaUser = $janji->user->nama;
        $no_hp = $janji->user->no_hp;
        $tanggalFormatted = $janji->tanggal
            ? Carbon::parse($janji->tanggal)->isoFormat('dddd, D MMMM Y')
            : '-';
        $jamFormatted = $janji->jam ? substr($janji->jam, 0, 5) : '-';

        $pesan = "Halo {$namaUser}, berikut adalah *Link Zoom* untuk janji temu Anda:\n\n";
        $pesan .= "📅 Tanggal: *{$tanggalFormatted}*\n";
        $pesan .= "⏰ Pukul: *{$jamFormatted} WIB*\n";
        $pesan .= "🔗 Link Zoom: {$request->link_zoom}\n\n";
        $pesan .= "Silakan bergabung tepat waktu. Terima kasih.";

        DB::table('notifikasi_wa')->insert([
            'no_hp' => $no_hp,
            'pesan' => $pesan,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('konsultan.jadwal.index')
            ->with('success', 'Link Zoom berhasil dikirim ke WhatsApp user.');
    }

    /**
     * Konsultan menandai janji temu sebagai selesai.
     */
    public function selesai($id)
    {
        $konsultanId = Session::get('konsultan_id');

        $janji = janjitemu::with('user')
            ->whereHas('jadwal', function ($q) use ($konsultanId) {
                $q->where('konsultan_id', $konsultanId);
            })
            ->findOrFail($id);

        $janji->update([
            'status' => 'selesai',
        ]);

        // Kirim notifikasi ke user
        if ($janji->user && $janji->user->no_hp) {
            DB::table('notifikasi_wa')->insert([
                'no_hp' => $janji->user->no_hp,
                'pesan' => "Halo {$janji->user->nama}, janji temu Anda telah *SELESAI*. ✅\n\nTerima kasih telah menggunakan layanan Datapedia.",
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('konsultan.jadwal.index')
            ->with('success', 'Janji temu berhasil ditandai sebagai selesai.');
    }
}
