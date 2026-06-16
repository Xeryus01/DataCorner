<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artikel;
use Illuminate\Support\Str;
use App\Models\SubjekMateri;
use Illuminate\Http\Request;
use App\Models\SubJudulArtikel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $artikels = Artikel::with('subjek_materi')
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhereHas('subjek_materi', function ($q) use ($search) {
                        $q->where('judul', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(10);
        return view('admin.artikel.index', compact('artikels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjek_materi = SubjekMateri::all();
        return view('admin.artikel.create', compact('subjek_materi'));
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
            'gambar' => 'required|image|mimes:jpg,jpeg,png'
        ]);

        $slug = Str::slug($request->judul);

        $filePath = $request->file('gambar')->store('artikel', 'public');

        Artikel::create([
            'subjek_materi_id' => $request->subjek_materi,
            'slug' => $slug,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $filePath
        ]);

        return redirect()->route('admin_artikel.index')->with('success', 'Artikel berhasil ditambahkan');
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
    public function edit(Artikel $artikel)
    {
        $subjek_materi = SubjekMateri::all();
        return view('admin.artikel.edit', compact('artikel', 'subjek_materi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'subjek_materi_id' => 'required|exists:subjek_materis,id',
            'judul' => 'required',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $slug = Str::slug($request->judul);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($artikel->gambar);
            $filePath = $request->file('gambar')->store('artikel', 'public');
            $artikel->gambar = $filePath;
        }

        $artikel->update([
            'subjek_materi_id' => $request->subjek_materi_id,
            'slug' => $slug,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin_artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        Storage::disk('public')->delete($artikel->gambar);
        $artikel->delete();
        return redirect()->route('admin_artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}
