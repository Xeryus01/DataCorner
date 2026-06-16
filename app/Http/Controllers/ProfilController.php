<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\KuisReguler\HasilKuisReguler;
use App\Models\TantanganBulanan\HasilKuisTantanganBulanan;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        [$id, $nameSlug] = explode('-', $slug, 2);

        $user = \App\Models\User::findOrFail($id);

        if (Str::slug($user->name) !== $nameSlug) {
            abort(404); // atau redirect ke URL yang benar
        }

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        // Ambil total skor dari user ini saja
        $totalSkor = HasilKuisTantanganBulanan::where('id_user', $user->id)
            ->sum('skor');

        return view('profil.index', compact('user', 'totalSkor'));
    }

    public function showArtikelDibaca($slug)
    {
        [$id, $nameSlug] = explode('-', $slug, 2);

        $user = User::findOrFail($id);

        if (Str::slug($user->name) !== $nameSlug) {
            abort(404);
        }

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        // Ambil daftar artikel yang sudah dibaca oleh user
        $artikelDibaca = $user->artikel_dibaca()->latest()->paginate(6);

        return view('profil.artikel-dibaca', compact('user', 'artikelDibaca'));
    }

    public function showVideoDilihat($slug)
    {
        [$id, $nameSlug] = explode('-', $slug, 2);

        $user = User::findOrFail($id);

        if (Str::slug($user->name) !== $nameSlug) {
            abort(404);
        }

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        // Ambil daftar artikel yang sudah dibaca oleh user
        $videoDilihat = $user->video_dilihat()->latest()->paginate(6);
        return view('profil.video-dilihat', compact('user', 'videoDilihat'));
    }

    public function showKuisRegulerDiselesaikan($slug)
    {
        [$id, $nameSlug] = explode('-', $slug, 2);

        $user = User::findOrFail($id);

        if (Str::slug($user->name) !== $nameSlug) {
            abort(404);
        }

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        $hasilReguler = HasilKuisReguler::with('kuis_reguler')->where('id_user', $user->id)->latest()->paginate(6);
        return view('profil.kuis-diselesaikan.kuis-reguler', compact('user', 'hasilReguler'));
    }

    public function showKuisTantanganDiselesaikan($slug)
    {
        [$id, $nameSlug] = explode('-', $slug, 2);

        $user = User::findOrFail($id);

        if (Str::slug($user->name) !== $nameSlug) {
            abort(404);
        }

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        $hasilTantangan = HasilKuisTantanganBulanan::with('kuis_tantangan_bulanan')->where('id_user', $user->id)->latest()->paginate(6);
        return view('profil.kuis-diselesaikan.kuis-tantangan-bulanan', compact('user', 'hasilTantangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        // Pisahkan ID dan nama-slug
        [$id, $nameSlug] = explode('-', $slug, 2);

        // Ambil user berdasarkan ID
        $user = \App\Models\User::findOrFail($id);

        // Validasi slug dari nama
        if (Str::slug($user->name) !== $nameSlug) {
            abort(404); // atau bisa redirect ke URL yang benar
        }

        // Validasi bahwa hanya pemilik akun yang bisa edit
        if (Auth::id() !== $user->id) {
            abort(403);
        }

        return view('profil.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'instansi' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $slug = Str::slug($request->name);

        // handle foto
        if ($request->hasFile('foto')) {
            if (!is_null($user->foto) && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $filePath = $request->file('foto')->store('users', 'public');
            $user->foto = $filePath;
        }

        // handle password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // cek apakah email diubah
        if ($request->email !== $user->email) {
            // simpan ke pending_email, jangan update email langsung
            $user->pending_email = $request->email;
            $user->otp_expires_at = now()->addMinutes(3);

            // generate OTP
            $otp = rand(100000, 999999);
            cache()->put('otp_' . $user->id, $otp, now()->addMinutes(3));

            // kirim email OTP
            Mail::to($user->pending_email)->queue(new OtpMail($otp));

            $user->save();

            return redirect()->route('verification.otp', ['email' => $user->pending_email])
                ->with('status', 'Kami sudah mengirim kode OTP ke email baru Anda. Silakan verifikasi dalam 3 menit.');
        }

        // update data lain
        $user->update([
            'name' => $request->name,
            'jenis_kelamin' => $request->jenis_kelamin,
            'instansi' => $request->instansi,
            'no_hp' => $request->no_hp,
            'slug' => $slug,
        ]);

        return redirect()->route('profil.show', $user->slug)
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = auth()->user();
        if (!is_null($user->foto) && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }
        $user->delete();
        return redirect()->route('home')->with('success', 'Profil berhasil dihapus');
    }
}
