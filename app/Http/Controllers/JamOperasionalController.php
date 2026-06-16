<?php

namespace App\Http\Controllers;

use App\Models\JamOperasional;
use Illuminate\Http\Request;

class JamOperasionalController extends Controller
{
    /**
     * Menampilkan semua data jam operasional.
     */
    public function index()
    {
        $jamOperasionals = JamOperasional::orderBy('id')->get();
        return view('admin.jam-operasional.index', compact('jamOperasionals'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        return view('admin.jam-operasional.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'keterangan_hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        JamOperasional::create($request->all());

        return redirect()->route('jam-operasional.index')
                         ->with('success', 'Jam operasional berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(JamOperasional $jamOperasional)
    {
        return view('admin.jam-operasional.edit', compact('jamOperasional'));
    }

    /**
     * Mengupdate data di database.
     */
    public function update(Request $request, JamOperasional $jamOperasional)
    {
        $request->validate([
            'keterangan_hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jamOperasional->update($request->all());

        return redirect()->route('jam-operasional.index')
                         ->with('success', 'Jam operasional berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(JamOperasional $jamOperasional)
    {
        $jamOperasional->delete();

        return redirect()->route('jam-operasional.index')
                         ->with('success', 'Jam operasional berhasil dihapus.');
    }
}
