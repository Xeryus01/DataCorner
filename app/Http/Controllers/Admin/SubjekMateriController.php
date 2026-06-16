<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artikel;
use Illuminate\Support\Str;
use App\Models\SubjekMateri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SubjekMateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjek = SubjekMateri::all();
        return view('admin.subjek_materi.index', compact('subjek'));
    }

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
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $slug = Str::slug($request->judul);

        $filePath = $request->file('gambar')->store('subjek_materi', 'public');

        SubjekMateri::create([
            'slug' => $slug,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $filePath,
        ]);

        return redirect()->route('admin_subjek-materi.index')->with('success', 'Subjek Materi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjekMateri $subjek_materi)
    {
        return view('admin.subjek_materi.edit', compact('subjek_materi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubjekMateri $subjek_materi)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $slug = Str::slug($request->judul);

        // jika ada file gambar yang diupload
        if ($request->hasFile('gambar')) {
            // hapus file gambar lama
            Storage::disk('public')->delete($subjek_materi->gambar);

            // upload file gambar baru
            $filePath = $request->file('gambar')->store('subjek_materi', 'public');
            $subjek_materi->gambar = $filePath;
        }

        // update subjek_materi
        $subjek_materi->update([
            'slug' => $slug,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin_subjek-materi.index')->with('success', 'Subjek Materi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjekMateri $subjek_materi)
    {
        // hapus file gambar
        Storage::disk('public')->delete($subjek_materi->gambar);

        // hapus subjek_materi
        $subjek_materi->delete();

        return redirect()->route('admin_subjek-materi.index')->with('success', 'Subjek Materi berhasil dihapus.');
    }
}
