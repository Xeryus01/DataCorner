<?php

namespace App\Http\Controllers\Admin\KuisReguler;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KuisReguler\KuisReguler;
use Illuminate\Support\Facades\Storage;

class KuisRegulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kuis = KuisReguler::when($search, function ($query, $search) {
            $query->where('judul', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate(10);
        return view('admin.kuis-reguler.index', compact('kuis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kuis-reguler.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpg,jpeg,png',
            'durasi_menit' => 'required|integer',
        ]);

        $slug = Str::slug($request->judul);

        $filePath = $request->file('gambar')->store('kuis_reguler', 'public');

        KuisReguler::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $filePath,
            'slug' => $slug,
            'durasi_menit' => $request->durasi_menit
        ]);

        return redirect()->route('admin_kuis-reguler.index')->with('success', 'Kuis Reguler berhasil ditambahkan');
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
    public function edit(KuisReguler $kuis_reguler)
    {
        return view('admin.kuis-reguler.edit', compact('kuis_reguler'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KuisReguler $kuis_reguler)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
            'durasi_menit' => 'required|integer',
        ]);

        $slug = Str::slug($request->judul);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($kuis_reguler->gambar);
            $filePath = $request->file('gambar')->store('kuis_reguler', 'public');
            $kuis_reguler->gambar = $filePath;
        }

        $kuis_reguler->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'slug' => $slug,
            'durasi_menit' => $request->durasi_menit
        ]);

        return redirect()->route('admin_kuis-reguler.index')->with('success', 'Kuis Reguler berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KuisReguler $kuis_reguler)
    {
        Storage::disk('public')->delete($kuis_reguler->gambar);
        $kuis_reguler->delete();
        return redirect()->route('admin_kuis-reguler.index')->with('success', 'Kuis Reguler berhasil dihapus');
    }
}
