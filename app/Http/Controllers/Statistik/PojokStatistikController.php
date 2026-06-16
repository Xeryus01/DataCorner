<?php

namespace App\Http\Controllers\Statistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananPojokStatistik;

class PojokStatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = $request->tahun ?? date('Y');
        $data = LayananPojokStatistik::orderBy('periode', 'desc')
        ->paginate(12);

        return view(
            'admin.pojok-statistik.index',
            compact('data')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pojok-statistik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bulan'                => 'required|digits:2',
            'tahun'                => 'required|digits:4',
            'pengunjung_unik'      => 'required|integer|min:0',
            'rata_harian'          => 'required|numeric|min:0',
            'kunjungan'            => 'required|integer|min:0',
            'layanan_tercetak'     => 'required|integer|min:0',
            'digilib_online'       => 'required|integer|min:0',
        ]);

        // Format periode (YYYY-MM)
        $periode = $validated['tahun'] . '-' . $validated['bulan'];
        
        if (LayananPojokStatistik::where('periode', $periode)->exists()) {
            return back()
                ->withErrors(['bulan' => 'Data untuk periode ini sudah ada'])
                ->withInput();
        }

        //Ambil langsung dari input (tidak dihitung ulang)
        $rata_harian = $validated['rata_harian'];

        //Jumlah hanya dari kunjungan + digital
        $jumlah = $validated['kunjungan'] + $validated['digilib_online'];

        LayananPojokStatistik::create([
            'periode'              => $periode,
            'pengunjung_unik'      => $validated['pengunjung_unik'],
            'kunjungan'            => $validated['kunjungan'],
            'rata_harian'          => $rata_harian,
            'layanan_tercetak'     => $validated['layanan_tercetak'],
            'digilib_online'       => $validated['digilib_online'],
            'jumlah'               => $jumlah,
        ]);

        return redirect()
            ->route('statistik.pojok-statistik.index')
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
        $data = LayananPojokStatistik::findOrFail($id);
        return view('admin.pojok-statistik.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {    
        $validated = $request->validate([
        'bulan'                => 'required|digits:2',
        'tahun'                => 'required|digits:4',
        'pengunjung_unik'      => 'required|integer|min:0',
        'rata_harian'          => 'required|numeric|min:0',
        'kunjungan'            => 'required|integer|min:0',
        'layanan_tercetak'     => 'required|integer|min:0',
        'digilib_online'       => 'required|integer|min:0',
    ]);

    $data = LayananPojokStatistik::findOrFail($id);

    // Format periode
    $periode = $validated['tahun'] . '-' . $validated['bulan'];

    if (LayananPojokStatistik::where('periode', $periode)
        ->where('id', '!=', $id)
        ->exists()) {

        return back()
            ->withErrors(['bulan' => 'Periode sudah digunakan'])
            ->withInput();
    }

    // Hitung jumlah
    $jumlah = $validated['kunjungan'] + $validated['digilib_online'];

    $data->update([
        'periode'              => $periode,
        'pengunjung_unik'      => $validated['pengunjung_unik'],
        'kunjungan'            => $validated['kunjungan'],
        'rata_harian'          => $validated['rata_harian'],
        'layanan_tercetak'     => $validated['layanan_tercetak'],
        'digilib_online'       => $validated['digilib_online'],
        'jumlah'               => $jumlah,
    ]);

    return redirect()
        ->route('statistik.pojok-statistik.index')
        ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = LayananPojokStatistik::findOrFail($id);

        $data->delete();

        return redirect()
            ->route('statistik.pojok-statistik.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
