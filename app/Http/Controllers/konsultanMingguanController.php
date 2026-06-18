<?php

namespace App\Http\Controllers;

use App\Models\konsultan;
use App\Models\petugas;
use App\Models\PetugasBerprestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class konsultanMingguanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Session::has('konsultanLogin')) {
            return redirect()->route('loginKonsultan')->with('error', 'Silakan login terlebih dahulu.');
        }

        $konsultan = Session::get('konsultanLogin');
        $konsultanId = $konsultan->id;

        $petugasMingguan = petugas::with('konsultan')
            ->where('konsultan_id', $konsultanId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('jadwal.mingguan', compact('petugasMingguan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Session::has('konsultanLogin')) {
            return redirect()->route('loginKonsultan')->with('error', 'Silakan login terlebih dahulu.');
        }

        $konsultan = Session::get('konsultanLogin');
        $konsultanData = konsultan::find($konsultan->id);

        return view('jadwal.mingguan-create', compact('konsultanData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Session::has('konsultanLogin')) {
            return redirect()->route('loginKonsultan')->with('error', 'Silakan login terlebih dahulu.');
        }

        $konsultan = Session::get('konsultanLogin');

        $request->validate([
            'tanggal' => 'required|date',
        ]);

        // Check if already exists for this date
        $existing = petugas::where('konsultan_id', $konsultan->id)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Anda sudah memiliki jadwal pada tanggal tersebut.')
                ->withInput();
        }

        petugas::create([
            'konsultan_id' => $konsultan->id,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()
            ->route('mingguan.index')
            ->with('success', 'Jadwal petugas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Session::has('konsultanLogin')) {
            return redirect()->route('loginKonsultan')->with('error', 'Silakan login terlebih dahulu.');
        }

        $konsultan = Session::get('konsultanLogin');
        $petugas = petugas::where('konsultan_id', $konsultan->id)
            ->findOrFail($id);

        return view('jadwal.mingguan-edit', compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Session::has('konsultanLogin')) {
            return redirect()->route('loginKonsultan')->with('error', 'Silakan login terlebih dahulu.');
        }

        $konsultan = Session::get('konsultanLogin');

        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $petugas = petugas::where('konsultan_id', $konsultan->id)
            ->findOrFail($id);

        // Check for duplicate date (excluding current record)
        $duplicate = petugas::where('konsultan_id', $konsultan->id)
            ->where('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
            ->first();

        if ($duplicate) {
            return redirect()->back()
                ->with('error', 'Anda sudah memiliki jadwal pada tanggal tersebut.')
                ->withInput();
        }

        $petugas->update([
            'tanggal' => $request->tanggal,
        ]);

        return redirect()
            ->route('mingguan.index')
            ->with('success', 'Jadwal petugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Session::has('konsultanLogin')) {
            return redirect()->route('loginKonsultan')->with('error', 'Silakan login terlebih dahulu.');
        }

        $konsultan = Session::get('konsultanLogin');

        $petugas = petugas::where('konsultan_id', $konsultan->id)
            ->findOrFail($id);

        $petugas->delete();

        return redirect()
            ->route('mingguan.index')
            ->with('success', 'Jadwal petugas berhasil dihapus.');
    }

    /**
     * Display petugas berprestasi for the logged-in konsultan.
     */
    public function berprestasi()
    {
        if (!Session::has('konsultanLogin')) {
            return redirect()->route('loginKonsultan')->with('error', 'Silakan login terlebih dahulu.');
        }

        $konsultan = Session::get('konsultanLogin');

        $prestasiData = PetugasBerprestasi::with('konsultan')
            ->where('konsultan_id', $konsultan->id)
            ->orderBy('tahun', 'desc')
            ->orderBy('triwulan', 'desc')
            ->get();

        return view('jadwal.berprestasi', compact('prestasiData'));
    }
}
