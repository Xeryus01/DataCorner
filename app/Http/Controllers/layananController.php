<?php

namespace App\Http\Controllers;
use App\Models\layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class layananController extends Controller
{
    public function index(){
        $layanan = layanan::all();
        return view('admin.layanan24.index', compact('layanan'));
    }

    public function create(){
        $layanan = layanan::all();
        return view('admin.layanan24.create', compact('layanan'));
    }

    public function store(Request $request){
        $request -> validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul'  => 'required|min:3|string',
            'deskripsi' => 'required|min:3|string',
            'link' => 'required|url',
        ]);

       $filePath = $request->file('gambar')->store('files','public');

        layanan::create([
            "gambar" => $filePath,
            "judul" => $request->judul,
            "deskripsi" => $request->deskripsi,
            "link" => $request->link,
        ]);

        return redirect()->route('layanan.index')->with('success', 'Layanan Berhasil Ditambah');
    }

    public function edit($id){
        $layanan = layanan::findOrFail($id);
        return view('admin.layanan24.edit', compact('layanan'));
    }

    public function update(Request $request, $id)
{
    $layanan = layanan::findOrFail($id);

    $request->validate([
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'judul' => 'min:3|string',
        'deskripsi' => 'min:3|string',
        'link' => 'url',
    ]);

    $data = [
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'link' => $request->link,
    ];

    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($layanan->gambar) {
            Storage::disk('public')->delete($layanan->gambar);
        }

        // Simpan gambar baru
        $filePath = $request->file('gambar')->store('files', 'public');
        $data['gambar'] = $filePath;
    }

    $layanan->update($data);

    return redirect()->route('layanan.index')->with('success', 'layanan Pelayanan Berhasil Diupdate');
}

    public function destroy($id)
{
    $layanan = layanan::findOrFail($id);

    if ($layanan->gambar) {
        Storage::disk('public')->delete($layanan->gambar);
    }

    $layanan->delete();

    return redirect()->route('layanan.index')->with('success', 'layanan berhasil dihapus.');
}

}
