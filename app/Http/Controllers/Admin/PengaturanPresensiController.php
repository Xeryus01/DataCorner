<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengaturanPresensi;
use App\Models\WilayahBps;

class PengaturanPresensiController extends Controller
{
    public function index()
    {
        $setting = PengaturanPresensi::with('wilayahBps')
                ->orderBy('id', 'desc')
                ->get();
        $wilayahBps = WilayahBps::orderBy('nama_wilayah')->get();
        return view('admin.pengaturan-presensi.index', compact('setting', 'wilayahBps'));
    }

    public function edit(PengaturanPresensi $pengaturanPresensi)
    {
        $wilayahBps = WilayahBps::orderBy('nama_wilayah')->get();
        return view('admin.pengaturan-presensi.edit', ['setting' => $pengaturanPresensi, 'wilayahBps' => $wilayahBps]);
    }

    public function update(Request $request, PengaturanPresensi $pengaturanPresensi)
    {
        
        $data = $request->validate([
            'wilayah_bps_id' => 'required|exists:wilayah_bps,id',
            'lat_kantor' => 'nullable|numeric',
            'long_kantor' => 'nullable|numeric',
            'jam_masuk_mulai' => 'required',
            'jam_masuk_selesai' => 'required',
            'jam_pulang_mulai' => 'required',
            'radius_kantor' => 'required',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = (bool) ($request->input('is_active') ?? false);

        $pengaturanPresensi->update($data);

        return redirect()->route('admin_pengaturan-presensi.index')->with('success', 'Pengaturan presensi diperbarui.');
    }

    public function create()
    {
        $wilayahBps = WilayahBps::orderBy('nama_wilayah')->get();
        return view('admin.pengaturan-presensi.create', compact('wilayahBps'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wilayah_bps_id' => 'required|exists:wilayah_bps,id',
            'lat_kantor' => 'nullable|numeric',
            'long_kantor' => 'nullable|numeric',
            'jam_masuk_mulai' => 'required',
            'jam_masuk_selesai' => 'required',
            'jam_pulang_mulai' => 'required',
            'radius_kantor' => 'required',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = (bool) ($request->input('is_active') ?? false);
        PengaturanPresensi::create($data);

        return redirect()->route('admin_pengaturan-presensi.index')->with('success', 'Pengaturan presensi dibuat.');
    }

    public function destroy(PengaturanPresensi $pengaturanPresensi)
    {
        $pengaturanPresensi->delete();

        return redirect()->route('admin_pengaturan-presensi.index')
                         ->with('success', 'Pengaturan presensi berhasil dihapus.');
    }
}
