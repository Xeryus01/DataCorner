<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\konsultan;
use Illuminate\Http\Request;
use App\Rules\LoginKonsultanCheck;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class KonsultanLogin extends Controller
{

    public function loginKonsultan()
    {
        return view('login.Konsultan');
    }

    public function prosesloginKonsultan(Request $request)
{
        $email = $request->input('email');
        $password = $request->input('password');

        $konsultan = konsultan::where('email', $email)->first();

        // Validasi login
        if ($konsultan && Hash::check($password, $konsultan->password)) {
            Session::put('login_konsultan', true);
            Session::put('konsultan_id', $konsultan->id);

            session(['konsultan_id' => $konsultan->id]);
            return redirect()->route('konsultan.jadwal.index');
        }

        // Jika login gagal, tambahkan pesan error dan kembali ke halaman sebelumnya
        return redirect()->back()->withErrors(['email' => 'Email atau kata sandi salah.']);

}


    public function logoutKonsultan()
    {
        Session::forget('login_konsultan');
        Session::forget('konsultan_id');

        return redirect()->route('loginKonsultan');

    }
}
