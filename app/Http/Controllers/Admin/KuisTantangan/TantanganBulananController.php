<?php

namespace App\Http\Controllers\Admin\KuisTantangan;

use COM;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TantanganBulanan\Periode;
use App\Models\TantanganBulanan\KuisTantanganBulanan;

class TantanganBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KuisTantanganBulanan::with('periode');
        if ($request->filled('periode')) {
            $query->where('id_periode', $request->periode);
        }
        $kuis = $query->get();
        $listPeriode = Periode::all(); // daftar untuk dropdown
        return view('admin.kuis-tantangan-bulanan.index', compact('kuis', 'listPeriode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periode = Periode::all();
        return view('admin.kuis-tantangan-bulanan.create', compact('periode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|exists:periodes,id',
            'judul' => 'required',
            'deskripsi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'durasi_menit' => 'required|integer',
        ]);

        $slug = Str::slug($request->judul);

        KuisTantanganBulanan::create([
            'id_periode' => $request->periode,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi_menit' => $request->durasi_menit,
            'status' => 'nonaktif',
            'slug' => $slug,
        ]);

        return redirect()->route('admin_kuis-tantangan-bulanan.index')->with('success', 'Kuis Tantangan Bulanan berhasil ditambahkan');
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
    public function edit(KuisTantanganBulanan $kuis_tantangan_bulanan)
    {
        $periode = Periode::all();
        return view('admin.kuis-tantangan-bulanan.edit', compact('kuis_tantangan_bulanan', 'periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KuisTantanganBulanan $kuis_tantangan_bulanan)
    {
        $request->validate([
            'periode' => 'required|exists:periodes,id',
            'judul' => 'required',
            'deskripsi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'durasi_menit' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Cek apakah user ingin mengubah status menjadi "aktif"
        if ($request->status === 'aktif') {
            $adaAktifLain = KuisTantanganBulanan::where('status', 'aktif')
                ->where('id', '!=', $kuis_tantangan_bulanan->id)
                ->exists();

            if ($adaAktifLain) {
                return redirect()->back()->withInput()->withErrors(['status' => 'Ada tantangan bulanan lain yang aktif']);
            }
        }

        $slug = Str::slug($request->judul);

        $kuis_tantangan_bulanan->update([
            'id_periode' => $request->periode,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi_menit' => $request->durasi_menit,
            'status' => $request->status,
            'slug' => $slug
        ]);

        return redirect()->route('admin_kuis-tantangan-bulanan.index')->with('success', 'Kuis Tantangan Bulanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KuisTantanganBulanan $kuis_tantangan_bulanan)
    {
        $kuis_tantangan_bulanan->delete();
        return redirect()->route('admin_kuis-tantangan-bulanan.index')->with('success', 'Kuis Tantangan Bulanan berhasil dihapus');
    }
}
