<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function showForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // cari berdasarkan email lama atau pending_email
        $user = User::where('email', $request->email)
            ->orWhere('pending_email', $request->email)
            ->firstOrFail();

        // tentukan email tujuan OTP
        $targetEmail = $user->pending_email ?? $user->email;

        return view('auth.verify-otp', [
            'email' => $targetEmail,
            'expired_at' => $user->otp_expires_at,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        // cari user berdasarkan email lama atau pending_email
        $user = User::where('email', $request->email)
            ->orWhere('pending_email', $request->email)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan']);
        }

        // cek OTP valid
        if ($user->otp_code === $request->otp && $user->otp_expires_at > now()) {

            $redirectRoute = 'login'; // default untuk register

            // kalau user masih proses register
            if (!$user->is_verified) {
                $user->is_verified = true;
            }

            // kalau ini verifikasi update email
            if ($user->pending_email) {
                $user->email = $user->pending_email;
                $user->pending_email = null;

                // setelah update email sukses, arahkan balik ke profil
                $redirectRoute = 'profil.show';
            }

            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            // redirect sesuai skenario
            if ($redirectRoute === 'login') {
                return redirect()->route('login')
                    ->with('status', 'Email berhasil diverifikasi, silakan login.');
            }

            return redirect()->route($redirectRoute, $user->slug)
                ->with('success', 'Profil berhasil diperbarui');
        }

        return back()->withErrors(['otp' => 'OTP salah atau sudah kadaluarsa']);
    }


    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)
            ->orWhere('pending_email', $request->email)
            ->first();

        if (! $user) {
            return back()->withErrors(['email' => 'User tidak ditemukan']);
        }

        // generate OTP baru
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(3);
        $user->save();

        // tentukan email tujuan (email lama atau pending_email)
        $targetEmail = $user->pending_email ?? $user->email;

        Mail::to($targetEmail)->queue(new OtpMail($otp));

        return back()->with('status', 'Kode OTP baru sudah dikirim ke email.');
    }
}
