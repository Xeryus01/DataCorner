<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WilayahBps;

class WilayahBpsController extends Controller
{
    public function index(Request $request)
    {
        $query = WilayahBps::query();

        if ($search = $request->input('search')) {
            $query->where('nama_wilayah', 'like', "%{$search}%")
                  ->orWhere('kode_wilayah', 'like', "%{$search}%");
        }

        $wilayahBps = $query->orderBy('nama_wilayah')->get();

        return view('admin.wilayah-bps.index', compact('wilayahBps'));
    }

    public function create()
    {
        return view('admin.wilayah-bps.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'kode_wilayah' => 'required|string|max:50|unique:wilayah_bps,kode_wilayah',
            'tingkat_wilayah' => 'required|string|max:100',
        ]);

        WilayahBps::create($data);

        return redirect()->route('admin_wilayah-bps.index')
                         ->with('success', 'Wilayah BPS berhasil dibuat.');
    }

    public function edit(WilayahBps $wilayahBps)
    {
        return view('admin.wilayah-bps.edit', compact('wilayahBps'));
    }

    public function update(Request $request, WilayahBps $wilayahBps)
    {
        $data = $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'kode_wilayah' => "required|string|max:50|unique:wilayah_bps,kode_wilayah,{$wilayahBps->id}",
            'tingkat_wilayah' => 'required|string|max:100',
        ]);

        $wilayahBps->update($data);

        return redirect()->route('admin_wilayah-bps.index')
                         ->with('success', 'Wilayah BPS berhasil diperbarui.');
    }

    public function destroy(WilayahBps $wilayahBps)
    {
        $wilayahBps->delete();

        return redirect()->route('admin_wilayah-bps.index')
                         ->with('success', 'Wilayah BPS berhasil dihapus.');
    }
}
