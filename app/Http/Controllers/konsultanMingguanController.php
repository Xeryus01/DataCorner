<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\konsultan;
use App\Models\petugas;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class konsultanMingguanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(konsultan $konsultan)
    {
        if (!Session::has('konsultanLogin')) {
            return redirect()->route('loginKonsultan')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Mendapatkan ID konsultan dari sesi
        $konsultan = Session::get('konsultanLogin');
        $konsultanId = $konsultan->id;

        // Ambil data konsultan dari database untuk memastikan data relasinya lengkap
        $konsultanData = konsultan::find($konsultanId);

        if (!$konsultanData) {
            return redirect()->back()->with('error', 'Data konsultan tidak ditemukan.');
        }

        // Ambil data petugas mingguan yang terkait dengan konsultan ini
        $petugasMingguan = $konsultanData->petugas()
            ->whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('jadwal.mingguan', compact('konsultanData', 'petugasMingguan'));

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
