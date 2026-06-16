<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlian;
use Illuminate\Http\Request;


class BidangKeahlianController extends Controller
{
    public function index()
    {
        $bidangKeahlian = BidangKeahlian::orderBy('nama_bidang', 'asc')->get();

        return view('admin.bidang-keahlian.index', compact('bidangKeahlian'));
    }

    public function create()
    {
        return view('admin.bidang-keahlian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:bidang_keahlians,nama_bidang',
            'status' => 'required|in:aktif,tidak aktif',
        ], [
            'nama_bidang.required' => 'Nama bidang keahlian wajib diisi.',
            'nama_bidang.unique' => 'Nama bidang keahlian sudah tersedia.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        BidangKeahlian::create([
            'nama_bidang' => $request->nama_bidang,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('bidang-keahlian.index')
            ->with('success', 'Bidang keahlian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bidang = BidangKeahlian::findOrFail($id);

        return view('admin.bidang-keahlian.edit', compact('bidang'));
    }

    public function update(Request $request, $id)
    {
        $bidang = BidangKeahlian::findOrFail($id);

        $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:bidang_keahlians,nama_bidang,' . $id,
            'status' => 'required|in:aktif,tidak aktif',
        ], [
            'nama_bidang.required' => 'Nama bidang keahlian wajib diisi.',
            'nama_bidang.unique' => 'Nama bidang keahlian sudah tersedia.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $bidang->update([
            'nama_bidang' => $request->nama_bidang,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('bidang-keahlian.index')
            ->with('success', 'Bidang keahlian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bidang = BidangKeahlian::findOrFail($id);
        $bidang->delete();

        return redirect()
            ->route('bidang-keahlian.index')
            ->with('success', 'Bidang keahlian berhasil dihapus.');
    }
}