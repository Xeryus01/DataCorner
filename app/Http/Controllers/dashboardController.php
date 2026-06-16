<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\akunuser;
use App\Models\faq;
use Illuminate\Http\Request;
use App\Models\jadwal;
use App\Models\konsultan;
use App\Models\layanan;
use App\Models\maklumat;
use App\Models\petugas;
use App\Models\standar;
use App\Models\konsultasiKlik;
use Illuminate\Support\Facades\DB;
use App\Helpers\DatabaseHelper;
use App\Models\Artikel;
use App\Models\SubjekMateri;
use App\Models\VideoPembelajaran;
use App\Models\Infografis;
use App\Models\InformasiMagang;
use App\Models\PendaftaranMagang;
use App\Models\InformasiRiset;
use App\Models\PendaftaranRiset;
use App\Models\KuisReguler\KuisReguler;
use App\Models\TantanganBulanan\KuisTantanganBulanan;

class dashboardController extends Controller
{
    public function index(){
        $totalAdmin = Admin::count();
        $totalUser = akunuser::count();
        $totalKonsultan = konsultan::count();
        $totalJadwal = jadwal::count();
        $totalLayanan = layanan::count();
        $totalMaklumat = maklumat::count();
        $totalStandar = standar::count();
        $totalPetugas = petugas::count();
        $totalFaq = faq::count();

        $totalSubjekMateri = SubjekMateri::count();
        $totalArtikel = Artikel::count();
        $totalVideoPembelajaran = VideoPembelajaran::count();
        $totalInfografis = Infografis::count();
        $totalInformasiMagang = InformasiMagang::count();
        $totalPendaftaranMagang = PendaftaranMagang::count();
        $totalInformasiRiset = InformasiRiset::count();
        $totalPendaftaranRiset = PendaftaranRiset::count();
        $totalKuisReguler = KuisReguler::count();
        $totalTantanganBulanan = KuisTantanganBulanan::count();

        $selectedYear = request('tahun', date('Y'));

        $availableYears = DatabaseHelper::getAvailableYears('konsultasi_klik', 'clicked_at');

        $bulanLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        $labelPosisi = [
            'asn' => 'ASN',
            'karyawan_swasta' => 'Karyawan Swasta',
            'wiraswasta' => 'Wiraswasta',
            'peneliti' => 'Peneliti',
            'pelajar_mahasiswa' => 'Pelajar/Mahasiswa',
            'lainnya' => 'Lainnya',
        ];

        $warnaDataset = [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(139, 92, 246, 0.8)',
            'rgba(20, 184, 166, 0.8)',
        ];

        // Ambil posisi yang benar-benar ada di database pada tahun terpilih
        $posisiList = konsultasiKlik::whereYear('clicked_at', $selectedYear)
            ->whereNotNull('posisi')
            ->where('posisi', '!=', '')
            ->distinct()
            ->pluck('posisi')
            ->toArray();

        $datasets = [];
        $totalBulanan = array_fill(0, 12, 0);

        foreach ($posisiList as $index => $posisi) {
            $dataPerBulan = array_fill(0, 12, 0);

            $monthExpr = DatabaseHelper::monthExpression('clicked_at');
            
            $data = konsultasiKlik::selectRaw("{$monthExpr} as bulan, COUNT(*) as jumlah")
                ->whereYear('clicked_at', $selectedYear)
                ->where('posisi', $posisi)
                ->groupBy(DB::raw($monthExpr))
                ->orderBy(DB::raw($monthExpr))
                ->get();

            foreach ($data as $row) {
                $bulanIndex = $row->bulan - 1;

                $dataPerBulan[$bulanIndex] = (int) $row->jumlah;
                $totalBulanan[$bulanIndex] += (int) $row->jumlah;
            }

            $datasets[] = [
                'label' => $labelPosisi[$posisi] ?? ucwords(str_replace('_', ' ', $posisi)),
                'data' => $dataPerBulan,
                'backgroundColor' => $warnaDataset[$index % count($warnaDataset)],
                'borderRadius' => 8,
            ];
        }

        $dataKonsultasiBulanan = [
            'labels' => $bulanLabels,
            'datasets' => $datasets,
            'totalBulanan' => $totalBulanan,
        ];
        
        return view('admin.dashboard.index', compact('totalAdmin','totalJadwal','totalUser','totalKonsultan','totalLayanan','totalMaklumat','totalStandar','totalPetugas','totalFaq','totalSubjekMateri','totalArtikel','totalVideoPembelajaran','totalInfografis','totalInformasiMagang','totalPendaftaranMagang','totalInformasiRiset','totalPendaftaranRiset','totalKuisReguler','totalTantanganBulanan','selectedYear','availableYears','dataKonsultasiBulanan'));
    }

}
