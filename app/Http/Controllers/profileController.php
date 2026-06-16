<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\janjitemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class profileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $userId = session('user_id');
    //     $user = akunuser::find($userId); // hanya ambil user yang login
    //     return view('user.profile', compact('user'));
    // }

    public function index()
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('loginUser')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $jadwalUser = janjitemu::where('users_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        return view('user.profile', compact('user', 'jadwalUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('user.editProfile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validasi
    $request->validate([
        'nama' => 'required|string|max:100',
        'no_hp' => 'required|regex:/^62[0-9]{9,13}$/',
        'password' => 'nullable|string|min:5',
    ]);

    // Simpan data
    $user->nama = $request->nama;
    $user->no_hp = $request->no_hp;

    if (!empty($request->password)) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
