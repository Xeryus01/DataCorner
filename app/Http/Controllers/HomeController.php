<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\konsultasiKlik;
use Carbon\Carbon;
use App\Models\faq;
use App\Models\layanan;
use App\Models\JamOperasional;
use App\Models\janjitemu;
use App\Models\konsultan;
use App\Models\standar;
use App\Models\maklumat;
use App\Models\petugas;
use App\Models\LayananPerpustakaan;
use App\Models\LayananKonsultasi;
use App\Models\LayananProdukStatistik;
use App\Models\LayananRekomendasi;
use App\Models\LayananPojokStatistik;
use App\Models\LayananWebsite;
use App\Models\PetugasBerprestasi;
use App\Models\BidangKeahlian;
use App\Models\SurveiLayanan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\DatabaseHelper;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        
        $faq = faq::all();
        $maklumat = maklumat::all();
        $standar = standar::all();
        $layanan = layanan::all();        
        $jamOperasional = JamOperasional::all();
        $userId = session()->get('user_id'); // Gunakan session() helper
        $konsultan = konsultan::with('bidangKeahlian')
            ->where('status', 'tersedia')
            ->get();
        $bidangKeahlian = BidangKeahlian::where('status', 'aktif')
            ->orderBy('nama_bidang', 'asc')
            ->get();
        $janjiTemu = Janjitemu::where('users_id', $userId)
            ->whereIn('jenis', ['online', 'offline'])
            ->latest()
            ->first();
        $surveiLayananAktif = SurveiLayanan::where('is_active', true)
            ->orderBy('tahun', 'desc')
            ->first();
        $today = Carbon::today()->toDateString();
        // Gunakan get() untuk mendapatkan koleksi
        $petugas = Petugas::with('konsultan')->where('tanggal', $today)->get();
        // Ambil tahun yang dipilih dari request, default tahun sekarang
        $selectedYear = $request->get('tahun', date('Y'));

        // Ambil semua tahun yang tersedia di database
        $availableYears = $this->getAvailableYears();

        // Ambil data konsultasi bulanan berdasarkan kode asli Anda
        $dataBulanan = $this->getDataBulanan($selectedYear);

        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun', date('Y'));
        
        $models = [
            [ 'label' => 'Perpustakaan','model' => LayananPerpustakaan::class,'column' => 'jumlah', ],
            [ 'label' => 'Konsultasi','model' => LayananKonsultasi::class,'column' => 'jumlah', ],
            [ 'label' => 'Produk Statistik','model' => LayananProdukStatistik::class,'column' => 'jumlah', ],
            [ 'label' => 'Rekomendasi','model' => LayananRekomendasi::class,'column' => 'jumlah', ],
            [ 'label' => 'Pojok Statistik','model' => LayananPojokStatistik::class,'column' => 'jumlah', ],
            [ 'label' => 'Website BPS Prov Babel','model' => LayananWebsite::class,'column' => 'total_users', ],
        ];

        

        foreach ($models as $item) {
            $stats[] = [

                'label' => $item['label'],

                'jumlah' => $this->getStatistik(
                    $item['model'],
                    $item['column'],
                    $tahun,
                    $bulan
                ),

            ];
        }     

        $bulanSekarang = date('n');
        $triwulanSekarang = ceil($bulanSekarang / 3);
        $tahunSekarang = date('Y');

        if ($triwulanSekarang == 1) {
            $triwulanTampil = 4;
            $tahunTampil = $tahunSekarang - 1;
        } else {
            $triwulanTampil = $triwulanSekarang - 1;
            $tahunTampil = $tahunSekarang;
        }

        $petugasBerprestasiTriwulan = PetugasBerprestasi::with('konsultan')
            ->where('triwulan', $triwulanTampil)
            ->where('tahun', $tahunTampil)
            ->orderBy('nilai', 'desc')
            ->get();

        $labelTriwulan = [
            1 => 'Triwulan I',
            2 => 'Triwulan II',
            3 => 'Triwulan III',
            4 => 'Triwulan IV',
        ];

        $labelTriwulanBerprestasi = $labelTriwulan[$triwulanTampil] ?? 'Triwulan';
        $tahunPetugasBerprestasi = $tahunTampil;

        return view('user.user', compact(
            'faq', 'janjiTemu', 'maklumat', 'standar', 'layanan', 'petugas', 'konsultan', 'jamOperasional',
            'petugasBerprestasiTriwulan',
            'surveiLayananAktif',
            'bidangKeahlian',
            'labelTriwulanBerprestasi',
            'tahunPetugasBerprestasi',
            'dataBulanan',
            'selectedYear',
            'availableYears',

            'stats',

            'bulan',
            'tahun'
        ));
    }

    private function getStatistik($model, $column, $tahun, $bulan = null)
    {
        return $model::when($bulan, function ($query) use ($tahun, $bulan) {

                $query->where('periode', $tahun . '-' . $bulan);

            }, function ($query) use ($tahun) {

                $query->where('periode', 'like', $tahun . '%');

            })
            ->sum($column) ?? 0;
    }

    /**
     * Method untuk mengambil data bulanan sesuai dengan struktur kode asli
     * Disesuaikan dengan variabel $dataBulanan yang Anda gunakan
     */
    private function getDataBulanan($year)
    {
        // Inisialisasi array untuk 12 bulan dengan nilai 0
        $dataBulanan = array_fill(0, 12, 0);

        // Query sesuai dengan tabel dan struktur database Anda
        $monthExpr = DatabaseHelper::monthExpression('clicked_at');
        
        $konsultasiData = DB::table('konsultasi_klik')
            ->select(
                DB::raw("{$monthExpr} as bulan"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereYear('clicked_at', $year)
            ->groupBy(DB::raw($monthExpr))
            ->orderBy('bulan')
            ->get();

        // Isi data ke array $dataBulanan berdasarkan bulan
        foreach ($konsultasiData as $data) {
            $indexBulan = $data->bulan - 1; // Index array dimulai dari 0 (Januari = index 0)
            $dataBulanan[$indexBulan] = (int) $data->jumlah;
        }

        return $dataBulanan;
    }

    /**
     * Method untuk mengambil tahun-tahun yang tersedia
     * Sesuai dengan variabel $availableYears yang Anda gunakan
     */
    private function getAvailableYears()
    {
        return DatabaseHelper::getAvailableYears('konsultasi_klik', 'created_at');
    }

    /**
     * Alternative method jika Anda menggunakan tabel lain
     * Contoh: jika data konsultasi ada di tabel 'appointments' atau 'medical_records'
     */
    private function getDataBulananAlternative($year, $tableName = 'appointments')
    {
        $dataBulanan = array_fill(0, 12, 0);

        $monthExpr = DatabaseHelper::monthExpression('tanggal_konsultasi');
        
        $query = DB::table($tableName)
            ->select(
                DB::raw("{$monthExpr} as bulan"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereYear('tanggal_konsultasi', $year)
            ->groupBy(DB::raw($monthExpr))
            ->orderBy('bulan')
            ->get();

        foreach ($query as $item) {
            $dataBulanan[$item->bulan - 1] = (int) $item->jumlah;
        }

        return $dataBulanan;
    }

    
    /**
     * Method jika menggunakan kondisi tambahan (misalnya status tertentu)
     */
    // private function getDataBulananWithConditions($year)
    // {
    //     $dataBulanan = array_fill(0, 12, 0);

    //     $data = DB::table('konsultasiKlik')
    //         ->select(
    //             DB::raw('MONTH(created_at) as bulan'),
    //             DB::raw('COUNT(*) as jumlah')
    //         )
    //         ->whereYear('created_at', $year)
    //         ->where('status', 'completed') // Contoh kondisi tambahan
    //         // ->where('type', 'konsultasi') // Contoh kondisi lain
    //         ->groupBy(DB::raw('MONTH(created_at)'))
    //         ->orderBy('bulan')
    //         ->get();

    //     foreach ($data as $item) {
    //         $dataBulanan[$item->bulan - 1] = (int) $item->jumlah;
    //     }

    //     return $dataBulanan;
    // }
}
