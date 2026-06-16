<?php

namespace App\Http\Controllers;

use App\Models\konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class konsultanStatusController extends Controller
{
    public function index()
    {
        $konsultan = konsultan::findOrFail(session('konsultan_id'));
        $konsultanLogin = Session::get('konsultanLogin');
        return view('jadwal.status', compact('konsultan','konsultanLogin'));
    }

    public function store(Request $request)
{
    $konsultan = Konsultan::findOrFail(session('konsultan_id'));

    if ($request->status == 'tidak tersedia') {
        $request->validate([
            'status' => 'required|in:tersedia,tidak tersedia',
            'alasan' => 'required|string|max:255',
            'tanggal_mulai_tidak_tersedia' => 'required|date|after_or_equal:today',
            'tanggal_selesai_tidak_tersedia' => 'required|date|after_or_equal:tanggal_mulai_tidak_tersedia',
        ]);

        $konsultan->update([
            'status' => 'tidak tersedia',
            'alasan' => $request->alasan,
            'tanggal_mulai_tidak_tersedia' => $request->tanggal_mulai_tidak_tersedia,
            'tanggal_selesai_tidak_tersedia' => $request->tanggal_selesai_tidak_tersedia,
            'status_updated_at' => now(),
        ]);

    } else {
        $konsultan->update([
            'status' => 'tersedia',
            'alasan' => null,
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'status_updated_at' => now(),
        ]);
    }

    return redirect()->route('status.index')->with('success', 'Status berhasil diperbarui');
}



}
