<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            switch ($admin->getRoleNames()->first()) {
                case 'admin':
                    return redirect()->route('admin_dashboard');
                case 'operator':
                    return redirect()->route('admin_operator.dashboard');
                case 'operator magang':
                    return redirect()->route('admin_magang.dashboard');
                case 'operator kepegawaian':
                    return redirect()->route('admin_kepegawaian.dashboard');
                default:
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin_login')->withErrors(['email' => 'Role tidak diizinkan.']);
            }
        }

        return redirect()->route('admin_login')->withErrors(['email' => 'Username atau password salah.']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login');
    }
}
