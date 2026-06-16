<?php

namespace App\Http\Controllers\Statistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananRekomendasi;

class RekomendasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = $request->tahun ?? date('Y');
        $data = LayananRekomendasi::orderBy('periode', 'desc')
        ->paginate(12);

        return view(
            'admin.rekomendasi.index',
            compact('data')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rekomendasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bulan'        => 'required|digits:2',
            'tahun'        => 'required|digits:4',
            'survei'       => 'required|integer|min:0',
            'kompromin'    => 'required|numeric|min:0',
            'opd'          => 'required|integer|min:0',
            'instansi'     => 'required|integer|min:0',
        ]);

        // Format periode (YYYY-MM)
        $periode = $validated['tahun'] . '-' . $validated['bulan'];
        
        if (LayananRekomendasi::where('periode', $periode)->exists()) {
            return back()
                ->withErrors(['bulan' => 'Data untuk periode ini sudah ada'])
                ->withInput();
        }

        //Jumlah hanya dari SURVEI + KOMPROMIN
        $jumlah = $validated['survei'] + $validated['kompromin'];

        LayananRekomendasi::create([
            'periode'      => $periode,
            'survei'       => $validated['survei'],
            'opd'          => $validated['opd'],
            'kompromin'    => $validated['kompromin'],
            'instansi'     => $validated['instansi'],
            'jumlah'       => $jumlah,
        ]);

        return redirect()
            ->route('statistik.rekomendasi.index')
            ->with('success', 'Data berhasil ditambahkan');
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
    public function edit(string $id)
    {
        $data = LayananRekomendasi::findOrFail($id);
        return view('admin.rekomendasi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'bulan'        => 'required|digits:2',
        'tahun'        => 'required|digits:4',
        'survei'       => 'required|integer|min:0',
        'kompromin'    => 'required|numeric|min:0',
        'opd'          => 'required|integer|min:0',
        'instansi'     => 'required|integer|min:0',
    ]);

    $data = LayananRekomendasi::findOrFail($id);

    // Format periode
    $periode = $validated['tahun'] . '-' . $validated['bulan'];

    if (LayananRekomendasi::where('periode', $periode)
        ->where('id', '!=', $id)
        ->exists()) {

        return back()
            ->withErrors(['bulan' => 'Periode sudah digunakan'])
            ->withInput();
    }

    // Hitung jumlah
    $jumlah = $validated['survei'] + $validated['kompromin'];

    $data->update([
        'periode'      => $periode,
        'survei'       => $validated['survei'],
        'opd'          => $validated['opd'],
        'kompromin'    => $validated['kompromin'],
        'instansi'     => $validated['instansi'],
        'jumlah'       => $jumlah,
    ]);

    return redirect()
        ->route('statistik.rekomendasi.index')
        ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = LayananRekomendasi::findOrFail($id);

        $data->delete();

        return redirect()
            ->route('statistik.rekomendasi.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
