<?php

namespace App\Http\Controllers;

use App\Models\jadwal;
use App\Models\janjitemu;
use App\Models\konsultan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class jadwalController extends Controller
{
    public function index()
    {
        $janjiTemu = janjitemu::with('user', 'jadwal.konsultan')
            ->paginate(10);            
        $konsultans = konsultan::where('status', 'tersedia')->get();

        return view('admin.jadwalAdmin.index', compact('janjiTemu', 'konsultans'));
    }

    public function scheduleAndApprove(Request $request, $id)
    {
        // Validasi input dari admin
        $request->validate([
            'konsultan_id' => 'required|exists:konsultans,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required|date_format:H:i',
        ]);

        // Cari janji temu dan update dengan data baru
        $janjiTemu = janjitemu::findOrFail($id);
        $janjiTemu->update([
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'status' => 'diterima',
        ]);

        // Buat atau update data jadwal konsultan
        jadwal::updateOrCreate(
            ['janjitemu_id' => $janjiTemu->id],
            ['konsultan_id' => $request->konsultan_id]
        );

        // --- Logika Chatbot Terima ---
        $janjiTemu->load('user', 'jadwal.konsultan');
        $user = $janjiTemu->user;
        $konsultan = $janjiTemu->jadwal->konsultan->nama ?? 'Belum ditentukan';
        $tanggalFormatted = Carbon::parse($janjiTemu->tanggal)->isoFormat('dddd, D MMMM Y');
        $jamFormatted = substr($janjiTemu->jam, 0, 5);

        $pesan = "Halo {$user->nama}, janji temu Anda telah *DITERIMA*.\n\n";
        $pesan .= "Berikut adalah detail jadwalnya:\n";
        $pesan .= "🗓️ Tanggal: *{$tanggalFormatted}*\n";
        $pesan .= "⏰ Pukul: *{$jamFormatted}*\n";
        $pesan .= "👤 Konsultan: *{$konsultan}*\n\n";

        if ($janjiTemu->jenis === 'online') {
            $pesan .= "💻 Jenis Janji Temu: *Online*\n";
            $pesan .= "🔗 Link Zoom akan dikirim sebelum waktu janji temu.\n";
        } else {
            $pesan .= "🏢 Jenis Janji Temu: *Offline*\n";
            $pesan .= "Silakan datang ke lokasi yang telah disepakati.\n";
        }

        DB::table('notifikasi_wa')->insert([
            'no_hp' => $user->no_hp, 'pesan' => $pesan, 'status' => 'pending', 'created_at' => now(), 'updated_at' => now(),
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Janji temu berhasil dijadwalkan dan notifikasi akan dikirim.');
    }

    /**
     * Menolak Janji Temu
     */
    public function tolak(Request $request, $id)
    {
        $janji = janjitemu::with('user')->findOrFail($id);
        $janji->status = 'ditolak';
        $janji->save();

        // Cek jika tanggal ada sebelum membuat pesan
        $tanggalPesan = $janji->tanggal ? "pada tanggal {$janji->tanggal} " : "";

        DB::table('notifikasi_wa')->insert([
            'no_hp' => $janji->user->no_hp,
            'pesan' => "Halo {$janji->user->nama}, mohon maaf, janji temu Anda {$tanggalPesan}*DITOLAK*. ❌",
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Janji temu ditolak dan notifikasi dikirim.');
    }

    /**
     * Menampilkan Form Kirim Link Zoom
     */
    public function formZoom($id)
    {
        $janjiTemu = janjitemu::with('user')->findOrFail($id);

        if ($janjiTemu->jenis !== 'online' || $janjiTemu->status !== 'diterima') {
            return redirect()->back()->with('error', 'Janji temu ini bukan online atau belum diterima.');
        }

        // Pastikan nama view Anda benar, contoh: 'admin.jadwal.zoom'
        return view('admin.jadwalAdmin.zomm', compact('janjiTemu'));
    }

    /**
     * Memproses dan Mengirim Link Zoom via Chatbot
     */
    public function kirimZoom(Request $request, $id)
    {
        $request->validate(['link_zoom' => 'required|url',]);

        $janjiTemu = janjitemu::with(['user', 'jadwal.konsultan'])->findOrFail($id);

        // Simpan link Zoom ke database
        $janjiTemu->update([
            'zoom_link' => $request->link_zoom,
        ]);

        $namaUser = $janjiTemu->user->nama;
        $no_hp = $janjiTemu->user->no_hp;
        $namaKonsultan = $janjiTemu->jadwal && $janjiTemu->jadwal->konsultan ? $janjiTemu->jadwal->konsultan->nama : 'Belum ditentukan';
        $tanggalFormatted = Carbon::parse($janjiTemu->tanggal)->isoFormat('dddd, D MMMM Y');
        $jamFormatted = substr($janjiTemu->jam, 0, 5);

        $pesan = "Halo {$namaUser}, berikut adalah *Link Zoom* untuk janji temu Anda:\n\n";
        $pesan .= "📅 Tanggal: *{$tanggalFormatted}*\n";
        $pesan .= "⏰ Pukul: *{$jamFormatted}*\n";
        $pesan .= "👤 Konsultan: *{$namaKonsultan}*\n";
        $pesan .= "🔗 Link Zoom: {$request->link_zoom}\n\n";
        $pesan .= "Silakan bergabung tepat waktu. Terima kasih.";

        DB::table('notifikasi_wa')->insert([
            'no_hp' => $no_hp, 'pesan' => $pesan, 'status' => 'pending', 'created_at' => now(), 'updated_at' => now(),
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Link Zoom berhasil dikirim.');
    }

    /**
     * Membatalkan jadwal yang sudah diterima.
     */
    public function batalJadwal($jadwal_id)
    {
        $jadwal = jadwal::findOrFail($jadwal_id);
        $janjiTemu = janjitemu::find($jadwal->janjitemu_id);
        $jadwal->delete();

        if ($janjiTemu) {
            $janjiTemu->update(['status' => 'menunggu', 'tanggal' => null, 'jam' => null,]);
        }
        return redirect()->back()->with('success', 'Jadwal berhasil dibatalkan.');
    }

    /**
     * Menghapus data janji temu secara permanen.
     */
    public function destroy($janjitemu_id)
    {
        $janjiTemu = janjitemu::findOrFail($janjitemu_id);
        $janjiTemu->delete(); // Jadwal terkait akan ikut terhapus jika relasi di database diatur dengan "on cascade delete"

        return redirect()->route('jadwal.index')->with('success', 'Janji temu berhasil dihapus.');
    }

    /**
     * Menghapus data janji temu secara permanen (alias route hapus).
     */
    public function hapus($id)
    {
        $janjiTemu = janjitemu::findOrFail($id);
        $janjiTemu->delete();

        return redirect()->route('jadwal.index')->with('success', 'Janji temu berhasil dihapus.');
    }


}
