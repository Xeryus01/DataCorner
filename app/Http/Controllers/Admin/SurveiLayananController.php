<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveiLayanan;
use Illuminate\Http\Request;

class SurveiLayananController extends Controller
{
    public function index()
    {
        $surveiLayanan = SurveiLayanan::orderBy('tahun', 'desc')->get();

        return view('admin.survei-layanan.index', compact('surveiLayanan'));
    }

    public function create()
    {
        return view('admin.survei-layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|digits:4|integer|unique:survei_layanan,tahun',
            'link' => 'required|url',
        ], [
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.digits' => 'Tahun harus 4 digit.',
            'tahun.unique' => 'Tahun tersebut sudah memiliki link survei.',
            'link.required' => 'Link survei wajib diisi.',
            'link.url' => 'Format link harus berupa URL yang valid.',
        ]);

        SurveiLayanan::create([
            'tahun' => $request->tahun,
            'link' => $request->link,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('survei-layanan.index')
            ->with('success', 'Data survei layanan berhasil ditambahkan.');
    }

    public function edit(SurveiLayanan $surveiLayanan)
    {
        return view('admin.survei-layanan.edit', compact('surveiLayanan'));
    }

    public function update(Request $request, SurveiLayanan $surveiLayanan)
    {
        $request->validate([
            'tahun' => 'required|digits:4|integer|unique:survei_layanan,tahun,' . $surveiLayanan->id,
            'link' => 'required|url',
        ], [
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.digits' => 'Tahun harus 4 digit.',
            'tahun.unique' => 'Tahun tersebut sudah memiliki link survei.',
            'link.required' => 'Link survei wajib diisi.',
            'link.url' => 'Format link harus berupa URL yang valid.',
        ]);

        $surveiLayanan->update([
            'tahun' => $request->tahun,
            'link' => $request->link,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('survei-layanan.index')
            ->with('success', 'Data survei layanan berhasil diperbarui.');
    }

    public function destroy(SurveiLayanan $surveiLayanan)
    {
        $surveiLayanan->delete();

        return redirect()
            ->route('survei-layanan.index')
            ->with('success', 'Data survei layanan berhasil dihapus.');
    }
}