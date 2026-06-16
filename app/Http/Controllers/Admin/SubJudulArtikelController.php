<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubJudulArtikel;

class SubJudulArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_artikel, Request $request)
    {
        $search = $request->input('search');
        $subjuduls = SubJudulArtikel::where('id_artikel', $id_artikel)
            ->when($search, function ($query, $search) {
                $query->where('sub_judul', 'like', '%' . $search . '%')
                    ->orWhere('urutan', 'like', '%' . $search . '%');
            })
            ->orderBy('urutan', 'asc')
            ->paginate(10);

        $artikel = Artikel::findOrFail($id_artikel);
        return view('admin.artikel.sub_judul_artikel.index', compact('subjuduls', 'artikel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id_artikel)
    {
        $artikel = Artikel::where('id', $id_artikel)->first();
        return view('admin.artikel.sub_judul_artikel.create', compact('artikel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_artikel' => 'required|exists:artikels,id',
            'sub_judul' => 'required',
            'urutan' => 'required|numeric',
        ]);

        SubJudulArtikel::create([
            'id_artikel' => $request->id_artikel,
            'sub_judul' => $request->sub_judul,
            'urutan' => $request->urutan,
        ]);

        return redirect()->route('admin_subjudul-artikel.index', $request->id_artikel)->with('success', 'Sub Judul Artikel berhasil ditambahkan');
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
    public function edit($id)
    {
        $subjudul_artikel = SubJudulArtikel::with('artikel')->findOrFail($id);
        return view('admin.artikel.sub_judul_artikel.edit', compact('subjudul_artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subjudul_artikel = SubJudulArtikel::findOrFail($id);
        $request->validate([
            'id_artikel' => 'required|exists:artikels,id',
            'sub_judul' => 'required',
            'urutan' => 'required|numeric',
        ]);

        $subjudul_artikel->update([
            'id_artikel' => $request->id_artikel,
            'sub_judul' => $request->sub_judul,
            'urutan' => $request->urutan,
        ]);

        return redirect()->route('admin_subjudul-artikel.index', $request->id_artikel)->with('success', 'Sub Judul Artikel berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubJudulArtikel $subjudul_artikel)
    {
        $subjudul_artikel->delete();
        return redirect()->route('admin_subjudul-artikel.index', $subjudul_artikel->id_artikel)->with('success', 'Sub Judul Artikel berhasil dihapus');
    }
}
