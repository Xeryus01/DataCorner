<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InformasiMagang;
use App\Models\PendaftaranMagang;
use Illuminate\Validation\Rules\In;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Console\View\Components\Info;

class InformasiMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $info = InformasiMagang::all();
        return view('admin.informasi-magang.index', compact('info'));
    }

    public function indexUser()
    {
        $user = Auth::user();
        $info = InformasiMagang::sole();

        $sertifikat = null;
        if (Auth::check()) {
            $sertifikat = PendaftaranMagang::where('user_id', $user->id)
                ->latest()
                ->value('sertifikat_magang');
        }

        return view('program-magang.index', compact('info', 'sertifikat'));
    }

    public function arsipKarya(Request $request)
    {

        $arsip = PendaftaranMagang::where('sertifikat_magang', '!=', null)
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(20);
        return view('program-magang.arsip-karya', compact('arsip'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.informasi-magang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required',
            'persyaratan' => 'required',
            'benefit' => 'nullable',
            'info_kontak' => 'nullable',
        ]);

        InformasiMagang::create([
            'deskripsi' => $request->deskripsi,
            'persyaratan' => $request->persyaratan,
            'benefit' => $request->benefit,
            'info_kontak' => $request->info_kontak,
            'status' => $request->status ?? 'aktif',
        ]);

        return redirect()->route('admin_informasi-magang.index')->with('success', 'Informasi magang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show() {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformasiMagang $informasi_magang)
    {
        return view('admin.informasi-magang.edit', compact('informasi_magang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformasiMagang $informasi_magang)
    {
        $request->validate([
            'deskripsi' => 'required',
            'persyaratan' => 'required',
            'benefit' => 'required',
            'info_kontak' => 'required',
        ]);

        $informasi_magang->update([
            'deskripsi' => $request->deskripsi,
            'persyaratan' => $request->persyaratan,
            'benefit' => $request->benefit,
            'info_kontak' => $request->info_kontak,
        ]);
        return redirect()->route('admin_informasi-magang.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformasiMagang $informasi_magang)
    {
        $informasi_magang->delete();
        return redirect()->route('admin_informasi-magang.index')->with('success', 'Informasi magang berhasil dihapus.');
    }

    public function statusAktif($id)
    {
        $info = InformasiMagang::findOrFail($id);
        $info->update(['status' => 'aktif']);
        return redirect()->route('admin_informasi-magang.index')->with('success', 'Status berhasil diaktifkan.');
    }

    public function statusNonaktif($id)
    {
        $info = InformasiMagang::findOrFail($id);
        $info->update(['status' => 'nonaktif']);
        return redirect()->route('admin_informasi-magang.index')->with('success', 'Status berhasil dinonaktifkan.');
    }
}
