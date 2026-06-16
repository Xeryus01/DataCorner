<?php

namespace App\Http\Controllers\SimulasiStatistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SimulasiSlovinController extends Controller
{
    public function index()
    {
        return view('simulasi-statistik.slovin');
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'populasi' => 'required|numeric|min:1',
            'error' => 'required|numeric|between:0.001,1',
        ]);

        $N = $request->populasi;
        $e = $request->error;

        $n = $N / (1 + $N * pow($e, 2));
        $n_rounded = ceil($n);

        return view('simulasi-statistik.slovin', compact('N', 'e', 'n', 'n_rounded'));
    }
}
