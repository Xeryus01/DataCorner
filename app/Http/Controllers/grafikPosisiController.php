<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\DatabaseHelper;

class grafikPosisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $selectedYear = $request->get('tahun', date('Y'));
    $availableYears = $this->getAvailableYears();

    // Mengubah nama variabel menjadi dataKonsultasiBulanan (sesuai kebutuhan baru)
    $dataKonsultasiBulanan = $this->getDataBulananByPosisi($selectedYear);

    return view('admin.grafik.index', compact(
        'dataKonsultasiBulanan', // Mengganti 'dataBulanan' atau 'dataPosisi'
        'selectedYear',
        'availableYears'
    ));
}

/**
 * Method baru untuk mengambil data per bulan DAN per posisi.
 */
private function getDataBulananByPosisi($year)
{
    $posisiLabels = ['masyarakat', 'mahasiswa', 'pegawai_pemerintah'];

    // Inisialisasi struktur data untuk Chart.js:
    // data[posisi][bulanIndex] = jumlah
    $datasets = [];
    foreach ($posisiLabels as $posisi) {
        $datasets[$posisi] = array_fill(0, 12, 0);
    }

    // Query untuk mengambil jumlah per bulan dan per posisi
    $monthExpr = DatabaseHelper::monthExpression('created_at');
    
    $konsultasiData = DB::table('konsultasi_klik')
        ->select(
            DB::raw("{$monthExpr} as bulan"),
            'posisi',
            DB::raw('COUNT(*) as jumlah')
        )
        ->whereYear('created_at', $year)
        ->groupBy(DB::raw($monthExpr), 'posisi')
        ->orderBy('bulan')
        ->get();

    // Isi data ke struktur datasets
    foreach ($konsultasiData as $data) {
        $posisiKey = $data->posisi;
        $indexBulan = $data->bulan - 1; // Index 0-11

        if (in_array($posisiKey, $posisiLabels)) {
            $datasets[$posisiKey][$indexBulan] = (int) $data->jumlah;
        }
    }

    $chartData = [
        'labels' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        'datasets' => [],
        'totalBulanan' => array_fill(0, 12, 0)
    ];

    $colors = [
        'masyarakat' => '#667eea',       // Biru Keunguan
        'mahasiswa' => '#4facfe',         // Biru Muda
        'pegawai_pemerintah' => '#a8edea', // Hijau Pucat
    ];

    // Format data untuk Chart.js dan hitung total bulanan
    foreach ($posisiLabels as $posisi) {
        $data = $datasets[$posisi];
        $totalBulanan = $chartData['totalBulanan'];

        // Hitung total bulanan
        for ($i = 0; $i < 12; $i++) {
            $totalBulanan[$i] += $data[$i];
        }
        $chartData['totalBulanan'] = $totalBulanan;

        $chartData['datasets'][] = [
            'label' => ucfirst(str_replace('_', ' ', $posisi)),
            'data' => $data,
            'backgroundColor' => $colors[$posisi],
            'borderColor' => '#ffffff',
            'borderWidth' => 1,
            'stack' => 'stack1', // Penting untuk Stacked Bar
        ];
    }

    return $chartData;
}

/**
 * Method untuk mengambil tahun-tahun yang tersedia
 */
private function getAvailableYears()
{
    return DatabaseHelper::getAvailableYears('konsultasi_klik', 'created_at');
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
