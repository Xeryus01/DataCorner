<?php

namespace App\Http\Controllers;
use App\Models\konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class konsultanController extends Controller
{
    public function index(){
        $konsultan = konsultan::all();
        return view('admin.konsultan.index', compact('konsultan'));
    }

    public function create(){
        $konsultan = konsultan::all();
        return view('admin.konsultan.create', compact('konsultan'));
    }

    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|unique:konsultans|string',
        'nama' => 'required|string',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'posisi' => 'required|string',
        'keahlian' => 'required|string',
        'password' => 'required|min:5|string',
    ]);

    // ✅ Upload file
    $filePath = $request->file('gambar')->store('files', 'public');
    // dd($filePath);
    // ✅ Simpan data ke DB
    konsultan::create([
        "email" => $request->email,
        "nama" => $request->nama,
        "image" => $filePath,
        "gambar" => $filePath,
        "posisi" => $request->posisi,
        "keahlian" => $request->keahlian,
        "password" => Hash::make($request->password),
    ]);

    return redirect()->route('konsultan.index')->with('success', 'Konsultan berhasil ditambahkan.');
}


    public function edit($id){
        $konsultan = konsultan::findOrFail($id);
        return view('admin.konsultan.edit', compact('konsultan'));
    }

    public function update(Request $request, konsultan $konsultan){
        $request->validate([
            'email' => 'string',
            'nama' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posisi' => 'string',
            'keahlian' => 'string',
            'password' => 'nullable|min:5|string',
        ]);

        $konsultan->email = $request->email;
        $konsultan->nama = $request->nama;
        $konsultan->posisi = $request->posisi;
        $konsultan->keahlian = $request->keahlian;

        if ($request->hasFile('gambar')) {

        if ($konsultan->gambar) {
            Storage::disk('public')->delete($konsultan->gambar);
        }

        $filePath = $request->file('gambar')->store('files', 'public');
        $konsultan['gambar'] = $filePath;
    }
        if ($request->hasFile('image')) {

        if ($konsultan->image) {
            Storage::disk('public')->delete($konsultan->image);
        }

        $filePath = $request->file('image')->store('files', 'public');
        $konsultan['image'] = $filePath;
    }
        if ($request->filled('password')) {
            $konsultan->password = Hash::make($request->password);
        }

        $konsultan->save();

        return redirect()->route('konsultan.index')->with('success', 'Admin Berhasil Diubah');
    }

    public function destroy($id){
        $konsultan = konsultan::findOrFail($id);

        if ($konsultan->gambar) {
        Storage::disk('public')->delete($konsultan->gambar);
    }
        if ($konsultan->image) {
        Storage::disk('public')->delete($konsultan->image);
    }

        $konsultan->delete();
        return redirect()->route('konsultan.index')->with('success', 'Admin Berhasil Dihapus');
    }
}
