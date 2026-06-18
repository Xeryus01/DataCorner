<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\KonsultasiKlik;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminKonsultasiController extends Controller
{

    // Menampilkan form input manual
    public function create()
    {
        return view('admin.konsultasi.create');
    }

    // Menyimpan data dari input manual admin
    public function store(Request $request)
{

    // 1. Validasi input
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'memiliki_akun' => 'nullable|in:ya,tidak',
            'posisi' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'keperluan_data' => 'nullable|string|max:255',
            'data_diminta' => 'nullable|string|max:255',
        ]);

    // 2. Tentukan ID pengguna default
    // GANTI angka '1' ini dengan ID pengguna "Input Manual Admin" di database Anda.
    $defaultUserId = 2;

    // 3. Cari pengguna default
    $user = User::find($defaultUserId);

    // 4. JIKA PENGGUNA TIDAK DITEMUKAN, kembalikan dengan pesan error
    if (!$user) {
        // Redirect kembali dengan pesan error spesifik
        return redirect()->back()
                         ->withInput() // withInput() agar isian form tidak hilang
                         ->with('error', 'Konfigurasi error: Pengguna default untuk input manual tidak ditemukan.');
    }

    // 5. Buat data konsultasi jika pengguna ditemukan
        KonsultasiKlik::create([
            'users_id'   => $user->id,
            'nama'       => $request->nama ?: $user->nama,
            'no_hp'      => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'memiliki_akun' => $request->memiliki_akun,
            'posisi'     => $request->posisi,
            'instansi'   => $request->instansi ?: 'Konsultasi via WhatsApp',
            'keperluan_data' => $request->keperluan_data,
            'data_diminta' => $request->data_diminta ?: 'Input manual oleh admin',
            'clicked_at' => now(),
        ]);

    // 6. Redirect ke halaman sukses
    return redirect()->route('faq.pesan')->with('success', 'Data konsultasi manual berhasil ditambahkan.');
}
}
