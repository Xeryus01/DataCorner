<?php

namespace App\Http\Controllers\Statistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananProdukStatistik;

class ProdukStatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = $request->tahun ?? date('Y');
        $data = LayananProdukStatistik::orderBy('periode', 'desc')
        ->paginate(12);

        return view(
            'admin.produk-statistik.index',
            compact('data')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.produk-statistik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bulan'                => 'required|digits:2',
            'tahun'                => 'required|digits:4',
            'pemohon_nol_rupiah'   => 'required|integer|min:0',
            'penjualan_data_mikro' => 'required|numeric|min:0',
            'penjualan_peta'       => 'required|integer|min:0',
            'publikasi_elektronik' => 'required|integer|min:0',            
        ]);

        // Format periode (YYYY-MM)
        $periode = $validated['tahun'] . '-' . $validated['bulan'];
        
        if (LayananProdukStatistik::where('periode', $periode)->exists()) {
            return back()
                ->withErrors(['bulan' => 'Data untuk periode ini sudah ada'])
                ->withInput();
        }
        
        $jumlah = $validated['pemohon_nol_rupiah'] + $validated['penjualan_data_mikro']
                + $validated['penjualan_peta'] + $validated['publikasi_elektronik'];

        LayananProdukStatistik::create([
            'periode'               => $periode,
            'pemohon_nol_rupiah'    => $validated['pemohon_nol_rupiah'],
            'penjualan_data_mikro'  => $validated['penjualan_data_mikro'],
            'penjualan_peta'        => $validated['penjualan_peta'],
            'publikasi_elektronik'  => $validated['publikasi_elektronik'],
            'jumlah'                => $jumlah,
        ]);

        return redirect()
            ->route('statistik.produk-statistik.index')
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
        $data = LayananProdukStatistik::findOrFail($id);
        return view('admin.produk-statistik.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'bulan'                => 'required|digits:2',
        'tahun'                => 'required|digits:4',        
        'pemohon_nol_rupiah'   => 'required|integer|min:0',
        'penjualan_data_mikro' => 'required|numeric|min:0',
        'penjualan_peta'       => 'required|integer|min:0',
        'publikasi_elektronik' => 'required|integer|min:0', 
    ]);

    $data = LayananProdukStatistik::findOrFail($id);

    // Format periode
    $periode = $validated['tahun'] . '-' . $validated['bulan'];

    if (LayananProdukStatistik::where('periode', $periode)
        ->where('id', '!=', $id)
        ->exists()) {

        return back()
            ->withErrors(['bulan' => 'Periode sudah digunakan'])
            ->withInput();
    }

    // Hitung jumlah
    $jumlah = $validated['pemohon_nol_rupiah'] + $validated['penjualan_data_mikro']
            + $validated['penjualan_peta'] + $validated['publikasi_elektronik'];

    $data->update([
        'periode'               => $periode,
        'pemohon_nol_rupiah'    => $validated['pemohon_nol_rupiah'],
        'penjualan_data_mikro'  => $validated['penjualan_data_mikro'],
        'penjualan_peta'        => $validated['penjualan_peta'],
        'publikasi_elektronik'  => $validated['publikasi_elektronik'],        
        'jumlah'                => $jumlah,
    ]);

    return redirect()
        ->route('statistik.produk-statistik.index')
        ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = LayananProdukStatistik::findOrFail($id);

        $data->delete();

        return redirect()
            ->route('statistik.produk-statistik.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
