<?php

namespace App\Http\Controllers\Statistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananKonsultasi;

class KonsultasiStatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = $request->tahun ?? date('Y');
        $data = LayananKonsultasi::orderBy('periode', 'desc')
        ->paginate(12);

        return view(
            'admin.konsultasi-statistik.index',
            compact('data')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.konsultasi-statistik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bulan'                => 'required|digits:2',
            'tahun'                => 'required|digits:4',
            'konsultasi_online'    => 'required|integer|min:0',
            'kunjungan_langsung'   => 'required|numeric|min:0',
            'datapedia'            => 'required|integer|min:0',
            'surat'                => 'required|integer|min:0',
        ]);

        // Format periode (YYYY-MM)
        $periode = $validated['tahun'] . '-' . $validated['bulan'];
        
        if (LayananKonsultasi::where('periode', $periode)->exists()) {
            return back()
                ->withErrors(['bulan' => 'Data untuk periode ini sudah ada'])
                ->withInput();
        }

        //Jumlah hanya dari datapedia + digital
        $jumlah = $validated['konsultasi_online'] + $validated['kunjungan_langsung']
                + $validated['datapedia'] + $validated['surat'];

        LayananKonsultasi::create([
            'periode'              => $periode,
            'konsultasi_online'    => $validated['konsultasi_online'],
            'kunjungan_langsung'   => $validated['kunjungan_langsung'],
            'datapedia'            => $validated['datapedia'],            
            'surat'                => $validated['surat'],
            'jumlah'               => $jumlah,
        ]);

        return redirect()
            ->route('statistik.konsultasi-statistik.index')
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
         $data = LayananKonsultasi::findOrFail($id);
        return view('admin.konsultasi-statistik.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'bulan'                => 'required|digits:2',
        'tahun'                => 'required|digits:4',
        'konsultasi_online'    => 'required|integer|min:0',
        'kunjungan_langsung'   => 'required|numeric|min:0',
        'datapedia'            => 'required|integer|min:0',
        'surat'                => 'required|integer|min:0',
    ]);

    $data = LayananKonsultasi::findOrFail($id);

    // Format periode
    $periode = $validated['tahun'] . '-' . $validated['bulan'];

    if (LayananKonsultasi::where('periode', $periode)
        ->where('id', '!=', $id)
        ->exists()) {

        return back()
            ->withErrors(['bulan' => 'Periode sudah digunakan'])
            ->withInput();
    }

    // Hitung jumlah
    $jumlah = $validated['konsultasi_online'] + $validated['kunjungan_langsung']
            + $validated['datapedia'] + $validated['surat'];


    $data->update([
        'periode'              => $periode,
        'konsultasi_online'    => $validated['konsultasi_online'],
        'kunjungan_langsung'   => $validated['kunjungan_langsung'],
        'datapedia'            => $validated['datapedia'],
        'surat'                => $validated['surat'],
        'jumlah'               => $jumlah,
    ]);

    return redirect()
        ->route('statistik.konsultasi-statistik.index')
        ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $data = LayananKonsultasi::findOrFail($id);

        $data->delete();

        return redirect()
            ->route('statistik.konsultasi-statistik.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
