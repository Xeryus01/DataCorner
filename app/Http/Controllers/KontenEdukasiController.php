<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Infografis;
use Illuminate\Support\Str;
use App\Models\SubjekMateri;
use Illuminate\Http\Request;
use App\Models\SubJudulArtikel;
use App\Models\VideoPembelajaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailSubJudulArtikel;
use Illuminate\Support\Facades\Storage;
use App\Models\ProgresBelajar\VideoDilihat;
use App\Models\ProgresBelajar\ArtikelDibaca;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ProgresBelajar\InfografisDilihat;

class KontenEdukasiController extends Controller
{
    public function show(Request $request, $slug)
    {
        $subjek = SubjekMateri::where('slug', $slug)->firstOrFail();
        $subjeks = SubjekMateri::all();

        $filterTipe = $request->get('tipe');   // artikel / video / infografis
        $filterTahun = $request->get('tahun'); // contoh 2024

        // Artikel
        $artikels = Artikel::where('subjek_materi_id', $subjek->id)
            ->when($filterTahun, fn($q) => $q->whereYear('created_at', $filterTahun))
            ->get()
            ->map(fn($a) => (object)[
                'id' => $a->id,
                'judul' => $a->judul,
                'slug' => $a->slug,
                'deskripsi' => $a->deskripsi,
                'created_at' => $a->created_at,
                'tipe' => 'artikel',
                'thumbnail' => $a->gambar ? Storage::url($a->gambar) : null,
                'file_infografis' => null,
            ]);

        // Video
        $videos = VideoPembelajaran::where('subjek_materi_id', $subjek->id)
            ->when($filterTahun, fn($q) => $q->whereYear('created_at', $filterTahun))
            ->get()
            ->map(fn($v) => (object)[
                'id' => $v->id,
                'judul' => $v->judul,
                'slug' => $v->slug,
                'deskripsi' => $v->deskripsi,
                'created_at' => $v->created_at,
                'tipe' => 'video',
                'thumbnail' => $v->thumbnail,
                'file_infografis' => null,
            ]);

        // Infografis
        $infografis = Infografis::where('subjek_materi_id', $subjek->id)
            ->when($filterTahun, fn($q) => $q->whereYear('created_at', $filterTahun))
            ->get()
            ->map(fn($i) => (object)[
                'id' => $i->id,
                'judul' => $i->judul,
                'slug' => null,
                'deskripsi' => $i->deskripsi,
                'created_at' => $i->created_at,
                'tipe' => 'infografis',
                'thumbnail' => $i->gambar ? Storage::url($i->gambar) : null,
                'file_infografis' => $i->file_infografis,
            ]);

        // Gabung
        $merged = collect();
        if (!$filterTipe || $filterTipe === 'artikel') $merged = $merged->concat($artikels);
        if (!$filterTipe || $filterTipe === 'video') $merged = $merged->concat($videos);
        if (!$filterTipe || $filterTipe === 'infografis') $merged = $merged->concat($infografis);

        $merged = $merged->sortByDesc('created_at')->values();

        // Pagination manual
        $page = $request->get('page', 1);
        $perPage = 10;
        $items = $merged->slice(($page - 1) * $perPage, $perPage)->all();

        $kontens = new LengthAwarePaginator(
            $items,
            $merged->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('konten-edukasi.index', compact('subjek', 'subjeks', 'kontens'));
    }


    public function showArtikel($subjek_slug, $artikel_slug)
    {
        $subjek = SubjekMateri::where('slug', $subjek_slug)->firstOrFail();

        $artikel = Artikel::where('subjek_materi_id', $subjek->id)
            ->where('slug', $artikel_slug)
            ->with([
                'subjudul_artikel' => function ($query) {
                    $query->orderBy('urutan', 'asc');
                },
                'subjudul_artikel.detail_sub_judul_artikel' => function ($query) {
                    $query->orderBy('urutan', 'asc');
                }
            ])
            ->firstOrFail();

        // Simpan progres artikel jika user login
        if (Auth::check()) {
            ArtikelDibaca::firstOrCreate([
                'id_user' => Auth::id(),
                'id_artikel' => $artikel->id,
            ]);
        }

        return view('konten-edukasi.artikel', compact('artikel', 'subjek'));
    }

    public function showVideo($subjek_slug, $video_slug)
    {
        $subjek = SubjekMateri::where('slug', $subjek_slug)->firstOrFail();
        $video = VideoPembelajaran::where('subjek_materi_id', $subjek->id)->where('slug', $video_slug)->firstOrFail();

        // Simpan progres video jika user login
        if (Auth::check()) {
            VideoDilihat::firstOrCreate([
                'id_user' => Auth::id(),
                'id_video' => $video->id,
            ]);
        }
        return view('konten-edukasi.video-pembelajaran', compact('video', 'subjek'));
    }

    public function lihatInfografis($id)
    {
        $infografis = Infografis::findOrFail($id);

        // Catat bahwa user membuka infografis
        if (Auth::check()) {
            InfografisDilihat::firstOrCreate([
                'id_user' => Auth::id(),
                'id_infografis' => $infografis->id,
            ]);
        }

        // Redirect ke file asli
        return redirect(Storage::url($infografis->file_infografis));
    }
}
