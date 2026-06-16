<?php

namespace App\Http\Controllers\SimulasiStatistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SamplingSimulationController extends Controller
{
    public function index()
    {
        return view('simulasi-statistik.sampling');
    }

    public function simulate(Request $request)
    {
        $request->validate([
            'populasi' => 'required|string',
            'ukuran_sample' => 'required|integer|min:1',
            'jumlah_pengulangan' => 'required|integer|min:1|max:100',
        ]);

        // Pecah input populasi dari string menjadi array angka
        $populasiInput = $request->input('populasi');
        $populasiArray = array_map('trim', explode(',', $populasiInput));
        $populasi = array_filter($populasiArray, fn($v) => is_numeric($v));
        $populasi = array_map('floatval', $populasi);

        if (count($populasi) < $request->ukuran_sample) {
            return back()->withErrors(['Ukuran sampel melebihi jumlah populasi.'])->withInput();
        }

        $ukuranSample = $request->ukuran_sample;
        $jumlahPengulangan = $request->jumlah_pengulangan;

        $hasilSimulasi = [];

        for ($i = 0; $i < $jumlahPengulangan; $i++) {
            $sampel = collect($populasi)->random($ukuranSample);
            $mean = round($sampel->avg(), 2);
            $hasilSimulasi[] = [
                'ke' => $i + 1,
                'sample' => $sampel->toArray(),
                'mean' => $mean,
            ];
        }

        return view('simulasi-statistik.sampling', compact('hasilSimulasi', 'populasiInput', 'ukuranSample', 'jumlahPengulangan'));
    }
}
