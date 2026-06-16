<?php

namespace App\Http\Controllers;
use App\Models\standar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class standarController extends Controller
{
    public function index(){
        $standar = standar::all();
        return view('admin.standar.index', compact('standar'));
    }

    public function create(){
        $standar = standar::all();
        return view('admin.standar.create', compact('standar'));
    }

    public function store(Request $request){
        $request->validate([
            'judul' => 'required|string|min:3',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = $request->file('gambar')->store('files','public');

        standar::create([
            "judul" => $request->judul,
            "gambar" => $filePath,
        ]);

        return redirect()->route('standar.index')->with('success', 'Standar Berhasil Ditambah');
    }


    public function edit($id){
        $standar = standar::findOrFail($id);
        return view('admin.standar.edit', compact('standar'));
    }

    public function update(Request $request, $id)
{
    $standar = standar::findOrFail($id);

    $request->validate([
        'judul' => 'min:3|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = [
        'judul' => $request->judul,
    ];

    if ($request->hasFile('gambar')) {

        if ($standar->gambar) {
            Storage::disk('public')->delete($standar->gambar);
        }

        $filePath = $request->file('gambar')->store('files', 'public');
        $data['gambar'] = $filePath;
    }

    $standar->update($data);

    return redirect()->route('standar.index')->with('success', 'Standar Pelayanan Berhasil Diupdate');
}


    public function destroy($id)
{
    $standar = standar::findOrFail($id);

    if ($standar->gambar) {
        Storage::disk('public')->delete($standar->gambar);
    }

    $standar->delete();

    return redirect()->route('standar.index')->with('success', 'standar berhasil dihapus.');
}

}
