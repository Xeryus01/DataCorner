<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\akunuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserLogin extends Controller
{
    public function dataUser(){
        $user = akunuser::all();
        return view('admin.user.index', compact('user'));
    }

    public function loginUser()
    {
        return view('login.User');
    }

   /* public function prosesloginUser(Request $request)
    {
        $request->merge([
            'no_hp' => '62' . ltrim($request->no_hp, '0')
        ]);

        $request->validate([
            'no_hp' => 'required|regex:/^62[0-9]{9,12}$/',
            'password' => 'required|min:5|string',
        ], [
            'no_hp.required' => 'Nomor Handphone Tidak Boleh Kosong',
            'no_hp.regex' => 'Nomor Handphone Tidak Valid',
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min' => 'Password Minimal 5 Karakter',
        ]);

        $throttleKey = Str::lower($request->no_hp) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'no_hp' => "Terlalu banyak percobaan login. Silakan coba lagi ."
            ])->withInput();
        }

        $user = akunuser::where('no_hp', $request->no_hp)->first();

    if (!$user) {
        RateLimiter::hit($throttleKey, 120);

        return back()->withErrors([
            'invalid_no_hp' => 'Nomor Handphone tidak terdaftar'
        ])->withInput();
    }

    if (!Hash::check($request->password, $user->password)) {
        RateLimiter::hit($throttleKey, 120);

        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah'
        ])->withInput();
    }

    RateLimiter::clear($throttleKey);

    Auth::login($user, $request->has('remember'));
    RateLimiter::hit($throttleKey, 120);

    return redirect()->route('home');
    }
 */

    public function prosesloginUser(Request $request)
{
    // Format nomor HP (ubah 08 jadi 628)
    $request->merge([
        'no_hp' => '62' . ltrim($request->no_hp, '0')
    ]);

    // Validasi input
    $request->validate([
        'no_hp' => 'required|regex:/^62[0-9]{9,12}$/',
        'password' => 'required|min:5|string',
    ], [
        'no_hp.required' => 'Nomor Handphone Tidak Boleh Kosong',
        'no_hp.regex' => 'Nomor Handphone Tidak Valid',
        'password.required' => 'Password Tidak Boleh Kosong',
        'password.min' => 'Password Minimal 5 Karakter',
    ]);

    // Key untuk rate limiter
    $throttleKey = Str::lower($request->no_hp) . '|' . $request->ip();

    // Cek terlalu banyak percobaan login
    if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
        return back()->withErrors([
            'no_hp' => "Terlalu banyak percobaan login. Silakan coba lagi."
        ])->withInput();
    }

    // Cari user berdasarkan no_hp
    $user = akunuser::where('no_hp', $request->no_hp)->first();

    // Jika user tidak ditemukan
    if (!$user) {
        RateLimiter::hit($throttleKey, 120);

        return back()->withErrors([
            'invalid_no_hp' => 'Nomor Handphone tidak terdaftar'
        ])->withInput();
    }

    // Jika password salah
    if (!Hash::check($request->password, $user->password)) {
        RateLimiter::hit($throttleKey, 120);

        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah'
        ])->withInput();
    }

    // Reset limiter jika login berhasil
    RateLimiter::clear($throttleKey);

    Auth::login($user, $request->has('remember'));
    // ✅ SIMPAN SESSION LOGIN
    Session::put('login_user', true);
    Session::put('user_id', $user->id);

    session()->save();
    // Redirect ke halaman utama
    return redirect()->route('home');
}

/*     public function logoutUser(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
} */

    public function logoutUser(Request $request)
{
    Auth::logout();

    Session::forget('login_user');
    Session::forget('user_id');

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
}

    function registerUser(){
        return view('register.index');
    }

    function daftar(Request $request){
    $request->merge([
        'no_hp' => '62' . ltrim($request->no_hp, '0')
    ]);

    $request->validate([
        'no_hp' => 'required|unique:users,no_hp|regex:/^62[0-9]{9,12}$/',
        'nama' => 'required|string|min:2',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:5',
    ], [
        'no_hp.required' => 'Nomor Handphone Wajib Diisi',
        'no_hp.unique' => 'Nomor Handphone Telah Digunakan',
        'no_hp.regex' => 'Nomor Handphone Salah',
        'nama.required' => 'Username Wajib Diisi',
        'nama.min' => 'Username Harus Lebih Dari 2 karakter',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah digunakan',
        'password.required' => 'Password Wajib Diisi',
        'password.min' => 'Password Harus Lebih Dari 5 karakter',
    ]);

    $data = [
        'no_hp' => $request->no_hp,
        'nama' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ];

    akunuser::create($data);
    return redirect()->route('loginUser')->with('success', 'Pendaftaran Berhasil');
}

}
