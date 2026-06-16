<?php

namespace App\Http\Controllers;

use App\Models\PetugasBerprestasi;
use App\Models\konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetugasBerprestasiController extends Controller
{
    public function index()
    {
        $data = PetugasBerprestasi::with('konsultan')
            ->orderBy('tahun', 'desc')
            ->orderBy('triwulan', 'desc')
            ->get();

        return view('admin.petugas-berprestasi.index', compact('data'));
    }

    public function create()
    {
        $konsultan = konsultan::where('status', 'tersedia')
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.petugas-berprestasi.create', compact('konsultan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'konsultan_id' => 'required|exists:konsultans,id',
            'triwulan' => 'required|in:1,2,3,4',
            'tahun' => 'required|digits:4',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $sertifikat = null;

        if ($request->hasFile('sertifikat')) {
            $sertifikat = $request->file('sertifikat')->store('sertifikat', 'public');
        }

        PetugasBerprestasi::create([
            'konsultan_id' => $request->konsultan_id,
            'triwulan' => $request->triwulan,
            'tahun' => $request->tahun,
            'nilai' => $request->nilai,
            'sertifikat' => $sertifikat,
        ]);

        return redirect()
            ->route('petugas-berprestasi.index')
            ->with('success', 'Data petugas berprestasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $prestasi = PetugasBerprestasi::findOrFail($id);

        $konsultan = konsultan::where('status', 'tersedia')
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.petugas-berprestasi.edit', compact('prestasi', 'konsultan'));
    }

    public function update(Request $request, $id)
    {
        $prestasi = PetugasBerprestasi::findOrFail($id);

        $request->validate([
            'konsultan_id' => 'required|exists:konsultans,id',
            'triwulan' => 'required|in:1,2,3,4',
            'tahun' => 'required|digits:4',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $sertifikat = $prestasi->sertifikat;

        if ($request->hasFile('sertifikat')) {
            if ($prestasi->sertifikat && Storage::disk('public')->exists($prestasi->sertifikat)) {
                Storage::disk('public')->delete($prestasi->sertifikat);
            }

            $sertifikat = $request->file('sertifikat')->store('sertifikat', 'public');
        }

        $prestasi->update([
            'konsultan_id' => $request->konsultan_id,
            'triwulan' => $request->triwulan,
            'tahun' => $request->tahun,
            'nilai' => $request->nilai,
            'sertifikat' => $sertifikat,
        ]);

        return redirect()
            ->route('petugas-berprestasi.index')
            ->with('success', 'Data petugas berprestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prestasi = PetugasBerprestasi::findOrFail($id);

        if ($prestasi->sertifikat && Storage::disk('public')->exists($prestasi->sertifikat)) {
            Storage::disk('public')->delete($prestasi->sertifikat);
        }

        $prestasi->delete();

        return redirect()
            ->route('petugas-berprestasi.index')
            ->with('success', 'Data petugas berprestasi berhasil dihapus.');
    }
}