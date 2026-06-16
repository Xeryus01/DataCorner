<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\KonsultasiKlik;
use App\Models\akunuser;
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
        'posisi' => 'required|string|max:255', // Pastikan validasi hanya untuk posisi
    ]);

    // 2. Tentukan ID pengguna default
    // GANTI angka '1' ini dengan ID pengguna "Input Manual Admin" di database Anda.
    $defaultUserId = 2;

    // 3. Cari pengguna default
    $user = akunuser::find($defaultUserId);

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
        'posisi'     => $request->posisi,
        'instansi'   => 'Konsultasi via WhatsApp',
        'data_diminta' => 'Input manual oleh admin',
        'clicked_at' => now(),
    ]);

    // 6. Redirect ke halaman sukses
    return redirect()->route('faq.pesan')->with('success', 'Data konsultasi manual berhasil ditambahkan.');
}
}
