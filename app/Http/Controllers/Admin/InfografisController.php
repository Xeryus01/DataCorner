<?php

namespace App\Http\Controllers\Admin;

use App\Models\Infografis;
use App\Models\SubjekMateri;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\View\Components\Info;

class InfografisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $infografis = Infografis::with('subjek_materi')
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhereHas('subjek_materi', function ($q) use ($search) {
                        $q->where('judul', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(10);
        return view('admin.infografis.index', compact('infografis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjek_materi = SubjekMateri::all();
        return view('admin.infografis.create', compact('subjek_materi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subjek_materi' => 'required|exists:subjek_materis,id',
            'judul' => 'required',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpg,jpeg,png',
            'file_infografis' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $fileGambar = $request->file('gambar')->store('infografis', 'public');
        $filePath = $request->file('file_infografis')->store('infografis', 'public');

        Infografis::create([
            'subjek_materi_id' => $request->subjek_materi,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $fileGambar,
            'file_infografis' => $filePath,
        ]);

        return redirect()->route('admin_infografis.index')->with('success', 'Infografis berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infografis $infografi)
    {
        $subjek_materi = SubjekMateri::all();
        return view('admin.infografis.edit', compact('infografi', 'subjek_materi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Infografis $infografi)
    {
        $request->validate([
            'subjek_materi_id' => 'required|exists:subjek_materis,id',
            'judul' => 'required',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
            'file_infografis' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // Jika ada gambar baru diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($infografi->gambar);
            // Upload gambar baru
            $fileGambar = $request->file('gambar')->store('infografis', 'public');
            $infografi->gambar = $fileGambar;
        }

        // Jika ada file baru diupload
        if ($request->hasFile('file_infografis')) {
            // Hapus file lama
            Storage::disk('public')->delete($infografi->file_infografis);
            // Upload file baru
            $filePath = $request->file('file_infografis')->store('infografis', 'public');
            $infografi->file_infografis = $filePath;
        }

        $infografi->update([
            'subjek_materi_id' => $request->subjek_materi_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin_infografis.index')->with('success', 'Infografis berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infografis $infografi)
    {
        Storage::disk('public')->delete($infografi->file_infografis);
        Storage::disk('public')->delete($infografi->gambar);
        $infografi->delete();
        return redirect()->route('admin_infografis.index')->with('success', 'Infografis berhasil dihapus');
    }
}
