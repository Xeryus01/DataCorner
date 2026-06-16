<?php

namespace App\Http\Controllers;
use App\Models\konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\BidangKeahlian;

class konsultanController extends Controller
{
    public function index(){
        $konsultan = konsultan::with('bidangKeahlian')->get();
        return view('admin.konsultan.index', compact('konsultan'));
    }

    private function daftarPosisi()
    {
        return [
            'Pimpinan' => [
                'Kepala BPS',
                'Kepala Subbagian Umum',
            ],

            'Statistisi' => [
                'Statistisi Ahli Madya',
                'Statistisi Ahli Muda',
                'Statistisi Ahli Pertama',
                'Statistisi Penyelia',
                'Statistisi Mahir',
                'Statistisi Terampil',
            ],

            'Pranata Komputer' => [
                'Pranata Komputer Ahli Madya',
                'Pranata Komputer Ahli Muda',
                'Pranata Komputer Ahli Pertama',
                'Pranata Komputer Mahir',
                'Pranata Komputer Terampil',
            ],

            'Administrasi dan Keuangan' => [
                'Analis Anggaran Ahli Madya',
                'Analis Pengelolaan Keuangan APBN Ahli Muda',
                'Analis Pengelolaan Keuangan APBN Ahli Pertama',
                'Pranata Keuangan APBN Penyelia',
                'Pranata Keuangan APBN Mahir',
                'Pranata Keuangan APBN Terampil',
            ],

            'SDM dan Umum' => [
                'Analis SDM Aparatur Ahli Madya',
                'Analis SDM Aparatur Ahli Muda',
                'Analis SDM Aparatur Ahli Pertama',
                'Pranata SDM Aparatur Terampil',
                'Arsiparis Ahli Muda',
                'Arsiparis Ahli Pertama',
                'Arsiparis Mahir',
                'Arsiparis Terampil',
                'Staf',
            ],
        ];
    }

    public function create()
    {
        $daftarPosisi = $this->daftarPosisi();
        $konsultan = konsultan::all();

        $bidangKeahlian = BidangKeahlian::where('status', 'aktif')
            ->orderBy('nama_bidang', 'asc')
            ->get();

        return view('admin.konsultan.create', compact('konsultan', 'daftarPosisi', 'bidangKeahlian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:konsultans,email|string',
            'nama' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posisi' => 'required|string',
            'bidang_keahlian_id' => 'required|array',
            'bidang_keahlian_id.*' => 'exists:bidang_keahlians,id',
            'password' => 'required|min:5|string',
        ]);

        $filePath = $request->file('gambar')->store('files', 'public');

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('files', 'public')
            : null;

        $konsultan = konsultan::create([
            'email' => $request->email,
            'nama' => $request->nama,
            'image' => $imagePath,
            'gambar' => $filePath,
            'posisi' => $request->posisi,
            'password' => Hash::make($request->password),
        ]);

        $konsultan->bidangKeahlian()->sync($request->bidang_keahlian_id);

        return redirect()
            ->route('konsultan.index')
            ->with('success', 'Konsultan berhasil ditambahkan.');
    }


    public function edit($id){
        $daftarPosisi = $this->daftarPosisi();
           $konsultan = konsultan::with('bidangKeahlian')->findOrFail($id);

        $bidangKeahlian = BidangKeahlian::where('status', 'aktif')
        ->orderBy('nama_bidang', 'asc')
        ->get();

        return view('admin.konsultan.edit', compact('konsultan' , 'daftarPosisi', 'bidangKeahlian'));
    }

    public function update(Request $request, konsultan $konsultan){
        $request->validate([            
            'email' => 'required|string|unique:konsultans,email,' . $konsultan->id,
            'nama' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posisi' => 'required|string',
            'bidang_keahlian_id' => 'required|array',
            'bidang_keahlian_id.*' => 'exists:bidang_keahlians,id',
            'password' => 'nullable|min:5|string',        
        ]);

        $konsultan->email = $request->email;
        $konsultan->nama = $request->nama;
        $konsultan->posisi = $request->posisi;        

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

        $konsultan->bidangKeahlian()->sync($request->bidang_keahlian_id);

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
