<?php

namespace App\Http\Controllers\SimulasiStatistik;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class DistribusiNormalController extends Controller
{
    public function index()
    {
        return view('simulasi-statistik.distribusi-normal');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'mean' => 'required|numeric',
            'stddev' => 'required|numeric|min:0.0001',
            'value' => 'required|numeric'
        ]);

        $mean = $request->mean;
        $stddev = $request->stddev;
        $x = $request->value;

        // Z-Score
        $z = ($x - $mean) / $stddev;

        // Fungsi CDF normal
        $cdf = 0.5 * (1 + erf(($x - $mean) / ($stddev * sqrt(2))));

        $pLess = $cdf * 100;
        $pGreater = (1 - $cdf) * 100;

        // Data PDF
        $values = [];
        $pdfCurve = [];
        for ($i = $mean - 4 * $stddev; $i <= $mean + 4 * $stddev; $i += 1) {
            $pdf = (1 / ($stddev * sqrt(2 * M_PI))) * exp(-0.5 * pow(($i - $mean) / $stddev, 2));
            $values[] = round($i, 2);
            $pdfCurve[] = $pdf;
        }

        return view('simulasi-statistik.distribusi-normal', compact(
            'mean',
            'stddev',
            'x',
            'z',
            'pLess',
            'pGreater',
            'values',
            'pdfCurve'
        ));
    }
}

if (!function_exists('erf')) {
    function erf($x)
    {
        $t = 1.0 / (1.0 + 0.5 * abs($x));
        $tau = $t * exp(-$x * $x - 1.26551223 +
            $t * (1.00002368 +
                $t * (0.37409196 +
                    $t * (0.09678418 +
                        $t * (-0.18628806 +
                            $t * (0.27886807 +
                                $t * (-1.13520398 +
                                    $t * (1.48851587 +
                                        $t * (-0.82215223 +
                                            $t * (0.17087277))))))))));
        return $x >= 0 ? 1 - $tau : $tau - 1;
    }
}
