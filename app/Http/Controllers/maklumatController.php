<?php

namespace App\Http\Controllers;
use App\Models\maklumat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class maklumatController extends Controller
{
    public function index(){
        $maklumat = maklumat::all();
        return view('admin.maklumat.index', compact('maklumat'));
    }

    public function create(){
        $maklumat = maklumat::all();
        return view('admin.maklumat.create', compact('maklumat'));
    }

    public function store(Request $request){
        $request->validate([
            'judul' => 'required|string|min:3',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = $request->file('file')->store('files','public');

        maklumat::create([
            "judul" => $request->judul,
            "file" => $filePath,
        ]);

        return redirect()->route('maklumat.index')->with('success', 'Maklumat Berhasil Ditambah');
    }

    public function edit($id){
        $maklumat = maklumat::findOrFail($id);
        return view('admin.maklumat.edit', compact('maklumat'));
    }

    public function update(Request $request, $id)
{
    $maklumat = maklumat::findOrFail($id);

    $data = [
        'judul' => $request->judul,
    ];

    if ($request->hasFile('file')) {

        if ($maklumat->file) {
            Storage::disk('public')->delete($maklumat->file);
        }

        $filePath = $request->file('file')->store('files', 'public');
        $data['file'] = $filePath;
    }

    $maklumat->update($data);

    return redirect()->route('maklumat.index')->with('success', 'Maklumat Berhasil Diupdate');
}


    public function destroy($id)
{
    $maklumat = maklumat::findOrFail($id);

    if ($maklumat->file) {
        Storage::disk('public')->delete($maklumat->file);
    }

    $maklumat->delete();

    return redirect()->route('maklumat.index')->with('success', 'Maklumat berhasil dihapus.');
}
}
