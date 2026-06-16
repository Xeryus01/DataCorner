<?php

namespace App\Http\Controllers\Admin\KuisTantangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TantanganBulanan\Periode;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periods = Periode::all();
        return view('admin.kuis-tantangan-bulanan.periode.index', compact('periods'));
    }

    public function setLeaderboard($id)
    {
        // Reset semua periode
        Periode::query()->update(['status_leaderboard' => 'nonaktif']);

        // Set yang dipilih menjadi aktif
        Periode::where('id', $id)->update(['status_leaderboard' => 'aktif']);

        return redirect()->route('admin_periode.index')->with('success', 'Periode berhasil dijadikan leaderboard aktif.');
    }

    public function nonaktifkanLeaderboard()
    {
        Periode::query()->update(['status_leaderboard' => 'nonaktif']);

        return redirect()->route('admin_periode.index')->with('success', 'Leaderboard berhasil dinonaktifkan.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|numeric',
        ]);

        Periode::create([
            'periode' => $request->periode,
        ]);

        return redirect()->route('admin_periode.index')->with('success', 'Periode berhasil ditambahkan');
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
    public function edit(Periode $periode)
    {
        return view('admin.kuis-tantangan-bulanan.periode.edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periode $periode)
    {
        $request->validate([
            'periode' => 'required|numeric',
        ]);

        $periode->update([
            'periode' => $request->periode,
        ]);

        return redirect()->route('admin_periode.index')->with('success', 'Periode berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periode $periode)
    {
        $periode->delete();
        return redirect()->route('admin_periode.index')->with('success', 'Periode berhasil dihapus');
    }
}
