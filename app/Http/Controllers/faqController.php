<?php

namespace App\Http\Controllers;
use App\Models\faq;
use App\Models\konsultasiKlik;
use Illuminate\Http\Request;

class faqController extends Controller
{
    public function index(){
        $faq = faq::all();
        return view('admin.faq.index', compact('faq'));
    }

    public function pesan()
    {
        $faq = konsultasiKlik::with('user')
            ->orderBy('clicked_at', 'desc')
            ->get();

        return view('admin.faq.pesan', compact('faq'));
    }

    public function hapusPesan($id){
        $faq = konsultasiKlik::findOrFail($id);
        $faq->delete();
        return redirect()->route('faq.pesan')->with('success', 'Pesan berhasil dihapus.');
    }

    public function editPesan($id)
    {
        $pesan = konsultasiKlik::findOrFail($id);
        return view('admin.faq.editPesan', compact('pesan'));
    }

    public function updatePesan(Request $request, $id)
    {
        $pesan = konsultasiKlik::findOrFail($id);

        $request->validate([
            'nama' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'memiliki_akun' => 'nullable|in:ya,tidak',
            'posisi' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'keperluan_data' => 'nullable|string|max:255',
            'data_diminta' => 'nullable|string|max:255',
        ]);

        $pesan->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'memiliki_akun' => $request->memiliki_akun,
            'posisi' => $request->posisi,
            'instansi' => $request->instansi,
            'keperluan_data' => $request->keperluan_data,
            'data_diminta' => $request->data_diminta,
        ]);

        return redirect()->route('faq.pesan')->with('success', 'Pesan berhasil diperbarui.');
    }

    public function create(){
        $faq = faq::all();
        return view('admin.faq.create', compact('faq'));
    }

    public function store(Request $request){
        $request->validate([
            'judul' => 'required|min:5|string',
            'deskripsi' => 'required|min:5|string',
        ]);

        faq::create([
            "judul" => $request->judul,
            "deskripsi" => $request->deskripsi,
        ]);
        return redirect()->route('faq.index')->with('success', 'Admin Berhasil Ditambah');
    }

    public function edit($id){
        $faq = faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, $id){
        $faq = faq::findOrFail($id);
        $request->validate([
            'judul' => 'string',
            'deskripsi' => 'string',
        ]);
        $data = [
            "judul" => $request->judul,
            "deskripsi" => $request->deskripsi,
        ];

        $faq->update($data);

        return redirect()->route('faq.index')->with('success', 'FAQ Berhasil Diubah');
    }

    public function destroy($id){
        $faq = faq::findOrFail($id);
        $faq->delete();
        return redirect()->route('faq.index')->with('success', 'FAQ Berhasil Dihapus');
    }
}
