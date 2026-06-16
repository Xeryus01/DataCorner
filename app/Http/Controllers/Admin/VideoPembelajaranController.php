<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\SubjekMateri;
use Illuminate\Http\Request;
use App\Models\VideoPembelajaran;
use App\Http\Controllers\Controller;

class VideoPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $videos = VideoPembelajaran::with('subjek_materi')
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhereHas('subjek_materi', function ($q) use ($search) {
                        $q->where('judul', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(10);
        return view('admin.video-pembelajaran.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjek_materi = SubjekMateri::all();
        return view('admin.video-pembelajaran.create', compact('subjek_materi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subjek_materi' => 'required|exists:subjek_materis,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link' => 'required|string',
        ]);

        $slug = Str::slug($request->judul);

        VideoPembelajaran::create([
            'subjek_materi_id' => $request->subjek_materi,
            'judul' => $request->judul,
            'slug' => $slug,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
        ]);

        return redirect()->route('admin_video-pembelajaran.index')->with('success', 'Video Pembelajaran berhasil ditambahkan');
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
    public function edit(VideoPembelajaran $video_pembelajaran)
    {
        $subjek_materi = SubjekMateri::all();
        return view('admin.video-pembelajaran.edit', compact('video_pembelajaran', 'subjek_materi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoPembelajaran $video_pembelajaran)
    {
        $request->validate([
            'subjek_materi_id' => 'required|exists:subjek_materis,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link' => 'required|string',
        ]);

        $slug = Str::slug($request->judul);

        $video_pembelajaran->update([
            'subjek_materi_id' => $request->subjek_materi_id,
            'judul' => $request->judul,
            'slug' => $slug,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
        ]);

        return redirect()->route('admin_video-pembelajaran.index')->with('success', 'Video Pembelajaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoPembelajaran $video_pembelajaran)
    {
        $video_pembelajaran->delete();
        return redirect()->route('admin_video-pembelajaran.index')->with('success', 'Video Pembelajaran berhasil dihapus');
    }
}
