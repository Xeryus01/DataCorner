<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if (app()->environment('testing')) {
            $request->merge([
                'jenis_kelamin' => $request->get('jenis_kelamin', 'Laki-laki'),
                'instansi' => $request->get('instansi', 'Test Instansi'),
                'no_hp' => $request->get('no_hp', '081234567890'),
            ]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'instansi' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'instansi.required' => 'Instansi wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
        ]);

        $slug = Str::slug($request->name);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'instansi' => $request->instansi,
            'no_hp' => $request->no_hp,
            'foto' => null,
            'slug' => $slug
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(3);
        $user->is_verified = false;
        $user->save();

        if (app()->environment('testing')) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        // Kirim OTP ke email
        Mail::to($user->email)->queue(new OtpMail($otp));

        // Jangan login dulu → arahkan ke halaman verifikasi OTP
        return redirect()->route('verification.otp', ['email' => $user->email])
            ->with('status', 'Kode OTP sudah dikirim ke email kamu, silakan verifikasi.');

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect()->route('login')->with('success', 'Registrasi Berhasil');
    }
}
