<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InformasiRiset;
use App\Models\PendaftaranRiset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InformasiRisetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $info = InformasiRiset::all();
        return view('admin.informasi-riset.index', compact('info'));
    }

    public function indexUser()
    {
        $user = Auth::user();
        $info = InformasiRiset::sole();

        $sertifikat = null;
        if (Auth::check()) {
            $sertifikat = PendaftaranRiset::where('user_id', $user->id)
                ->latest()
                ->value('sertifikat_riset');
        }

        return view('program-riset.index', compact('info', 'sertifikat'));
    }

    public function arsipKarya(Request $request)
    {

        $arsip = PendaftaranRiset::where('sertifikat_riset', '!=', null)
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(20);
        return view('program-riset.arsip-karya', compact('arsip'));
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
        //
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
    public function edit(InformasiRiset $informasi_riset)
    {
        return view('admin.informasi-riset.edit', compact('informasi_riset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiRiset $informasi_riset)
    {
        $request->validate([
            'deskripsi' => 'required',
            'persyaratan' => 'required',
            'benefit' => 'required',
            'info_kontak' => 'required',
        ]);

        $informasi_riset->update([
            'deskripsi' => $request->deskripsi,
            'persyaratan' => $request->persyaratan,
            'benefit' => $request->benefit,
            'info_kontak' => $request->info_kontak,
        ]);
        return redirect()->route('admin_informasi-riset.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
