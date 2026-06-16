<?php

namespace App\Http\Controllers\Statistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananWebsite;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $tahun = $request->tahun ?? date('Y');
        $data = LayananWebsite::orderBy('periode', 'desc')
        ->paginate(12);

        return view(
            'admin.website.index',
            compact('data')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.website.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ubah koma menjadi titik
        $request->merge([
            'bounce_rate' => str_replace(',', '.', $request->bounce_rate)
        ]);

        // Validasi
        $request->validate([

            'bulan'           => 'required|digits:2',
            'tahun'           => 'required|digits:4',

            'active_users'    => 'required|integer|min:0',
            'new_users'       => 'required|integer|min:0',
            'returning_users' => 'required|integer|min:0',
            'total_users'     => 'required|integer|min:0',
            'sessions'        => 'required|integer|min:0',

            'bounce_rate'     => 'required|numeric|min:0',

        ]);

        // Buat format periode
        $periode = $request->tahun . '-' . $request->bulan;

        // Cek apakah data sudah ada
        if (LayananWebsite::where('periode', $periode)->exists()) {

            return back()
                ->withErrors([
                    'bulan' => 'Data periode tersebut sudah ada.'
                ])
                ->withInput();
        }

        // Simpan data
        LayananWebsite::create([

            // INI YANG PENTING
            'periode' => $periode,

            'active_users'    => $request->active_users,
            'new_users'       => $request->new_users,
            'returning_users' => $request->returning_users,
            'total_users'     => $request->total_users,
            'sessions'        => $request->sessions,

            'bounce_rate'     => $request->bounce_rate,

        ]);

        return redirect()
            ->route('statistik.website.index')
            ->with('success', 'Data berhasil ditambahkan.');
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
        $data = LayananWebsite::findOrFail($id);
        return view('admin.website.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = LayananWebsite::findOrFail($id);

        $request->validate([

            'bulan'           => 'required|digits:2',
            'tahun'           => 'required|digits:4',
            'active_users'    => 'required|integer',
            'new_users'       => 'required|integer',
            'returning_users' => 'required|integer',
            'total_users'     => 'required|integer',
            'sessions'        => 'required|integer',
            'bounce_rate'     => 'required|numeric',

        ]);

        $periode = $request['tahun'] . '-' . $request['bulan'];
        
        if (LayananWebsite::where('periode', $periode)
            ->where('id', '!=', $id)
            ->exists()) {

            return back()
                ->withErrors(['bulan' => 'Periode sudah digunakan'])
                ->withInput();
        }

        $data->update([

            'periode'         => $periode,
            'active_users'    => $request->active_users,
            'new_users'       => $request->new_users,
            'returning_users' => $request->returning_users,
            'total_users'     => $request->total_users,
            'sessions'        => $request->sessions,
            'bounce_rate'     => $request->bounce_rate,
        ]);

        return redirect()
            ->route('statistik.website.index')
            ->with('success', 'Data berhasil diupdate');       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $website = LayananWebsite::findOrFail($id);
        $website->delete();

        return redirect()
            ->route('statistik.website.index')
            ->with('success', 'Data berhasil dihapus');
    }
    
}
