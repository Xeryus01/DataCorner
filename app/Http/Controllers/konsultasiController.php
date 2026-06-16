<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\konsultasiKlik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class konsultasiController extends Controller
{
    public function index()
    {
        $user = User::find(Session::get('user_id'));

        if (!$user) {
            return redirect()->route('loginUser')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('konsultasi.index', compact('user'));
    }

    public function store(Request $request)
{
    $user = User::find(Session::get('user_id'));

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Validasi form input
    $validated = $request->validate([
        'instansi' => 'required|string',
        'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        'data_diminta' => 'required|string',        
        'memiliki_akun' => 'required|in:ya,tidak',
        'posisi' => 'required|string',
        'keperluan_data' => 'required|array|min:1',
        'keperluan_data.*' => 'string',
    ]);

    $keperluanData = implode(', ', $validated['keperluan_data']);

    // Simpan ke database
    konsultasiKlik::create([
        'users_id' => $user->id,
        'clicked_at' => now(),
        'instansi' => $validated['instansi'],
        'jenis_kelamin' => $validated['jenis_kelamin'],
        'data_diminta' => $validated['data_diminta'],        
        'keperluan_data' => $keperluanData,
        'memiliki_akun' => $validated['memiliki_akun'],
        'posisi' => $validated['posisi'],
    ]);

    $labelPosisi = [
        'asn' => 'Aparatur Sipil Negara',
        'karyawan_swasta' => 'Karyawan Swasta',
        'wiraswasta' => 'Wiraswasta',
        'peneliti' => 'Peneliti',
        'pelajar_mahasiswa' => 'Pelajar/Mahasiswa',
        'lainnya' => 'Lainnya',
    ];

    // Format pesan WA
    $pesan = "*Permintaan Konsultasi Baru*\n\n";
    $pesan .= "👤 Nama Pengaju: {$user->nama}\n";
    $pesan .= "📧 Email: {$user->email}\n";
    $pesan .= "🚻 Jenis Kelamin: {$validated['jenis_kelamin']}\n";
    $pesan .= "📌 Dari Instansi: {$validated['instansi']}\n";
    $pesan .= "📌 Data yang Diminta: {$validated['data_diminta']}\n";    
    $pesan .= "📌 Keperluan Data: {$keperluanData}\n";
    $pesan .= "📌 Memiliki Akun PST BPS: {$validated['memiliki_akun']}\n";
    $pesan .= "📌 Posisi Sebagai: {$labelPosisi[$validated['posisi']]}\n";

    // Nomor bot WhatsApp
    $botPhoneNumber = '6285355609323'; //ganti dengan nomor bot WA yang digunakan

    // Redirect ke WA Web dengan pesan
    // $url = "https://api.whatsapp.com/send?phone=$botPhoneNumber&text=" . urlencode($pesan);
    $url = "https://web.whatsapp.com/send?phone=$botPhoneNumber&text=" . urlencode($pesan);
    return redirect()->away($url);
}
    public function jumlah()
{
    $userId = Session::get('user_id');
    $user = User::find($userId);

    $today = $user->jumlahKlik()->whereDate('clicked_at', Carbon::today())->count();
    $month = $user->jumlahKlik()->whereMonth('clicked_at', Carbon::now()->month)->count();
    $total = $user->jumlahKlik()->count();

    return view('user.user', compact('today', 'month', 'total'));
}


}
