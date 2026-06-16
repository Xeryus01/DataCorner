<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdminLogin extends Controller
{
    public function dashboard()
    {
        return view('admin.layout');
    }

    public function loginAdmin()
    {
        return view('login.Admin');
    }

//    public function prosesloginAdmin(Request $request)
// {
//      $email = $request->input('email');
//     $password = $request->input('password');

//     $admin = Admin::where('email', $email)->first();

//     if ($admin && Hash::check($password, $admin->password)) {
//         Session::put('loginStatus', true);
//         Session::put('adminLogin', $admin);
//         return redirect()->route('dashboard.index');
//     }

//     return back()->withErrors(['email' => 'Email atau password salah']);
// }
    public function prosesloginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        }

        return back()->withErrors(['email' => 'Login gagal']);
    }


    // public function logoutAdmin()
    // {
    //     Session::flush();
    //     return redirect()->route('loginAdmin');
    // }
    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('loginAdmin');
    }

}
