<?php

Route::redirect('/student-corner', '/#literasi-statistik')->name('student-corner.index');

use Illuminate\Mail\PendingMail;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\Route;
use App\Models\SubjekMateri;
use Spatie\Permission\Contracts\Role;
use App\Http\Controllers\OtpController;

use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KontenEdukasiController;
use App\Http\Controllers\LogHarianMagangController;
use App\Http\Controllers\VisualisasiDataController;
use App\Http\Controllers\KuisDanTantanganController;
use App\Http\Controllers\Admin\InformasiRisetController;
use App\Http\Controllers\Admin\InformasiMagangController;
use App\Http\Controllers\Admin\PendaftaranRisetController;
use App\Http\Controllers\Admin\PendaftaranMagangController;
use App\Http\Controllers\VisualisasiData\BoxPlotController;
use App\Http\Controllers\VisualisasiData\ScatterController;
use App\Http\Controllers\VisualisasiData\PieChartController;
use App\Http\Controllers\VisualisasiData\HistogramController;
use App\Http\Controllers\VisualisasiData\LineChartController;
use App\Http\Controllers\PresensiMagangController;
use App\Http\Controllers\SimulasiStatistik\SimulasiSlovinController;
use App\Http\Controllers\SimulasiStatistik\DistribusiNormalController;
use App\Http\Controllers\SimulasiStatistik\SamplingSimulationController;

// Route Konten Edukasi
Route::get('/konten-edukasi', function () {
    $subjek_materi = SubjekMateri::orderBy('judul')->get();
    return view('konten-edukasi.index', compact('subjek_materi'));
})->name('konten-edukasi.index');

Route::get('/konten-edukasi/{slug}', [KontenEdukasiController::class, 'show'])->name('konten-edukasi.show');
Route::get('/konten-edukasi/{subjek_slug}/artikel/{slug}', [KontenEdukasiController::class, 'showArtikel'])->name('konten-edukasi.showArtikel');
Route::get('/konten-edukasi/{subjek_slug}/video/{slug}', [KontenEdukasiController::class, 'showVideo'])->name('konten-edukasi.showVideo');
Route::get('/infografis/{id}', [KontenEdukasiController::class, 'lihatInfografis'])
    ->name('infografis.lihat');

// Route Alat Statistik terpadu
Route::get('/alat-statistik', fn() => view('alat-statistik.index'))->name('alat-statistik.index');

// Route Kalkulator
Route::prefix('kalkulator-statistik')->group(function () {
    Route::get('/', fn() => view('kalkulator-statistik.index'))->name('kalkulator-statistik.index');
    Route::get('/kalkulator-mean-median-modus', fn() => view('kalkulator-statistik.mean'))->name('kalkulator-statistik.mean');
    Route::get('/kalkulator-kombinasi', fn() => view('kalkulator-statistik.kombinasi'))->name('kalkulator-statistik.kombinasi');
    Route::get('/kalkulator-permutasi', fn() => view('kalkulator-statistik.permutasi'))->name('kalkulator-statistik.permutasi');
    Route::get('/kalkulator-standar-deviasi', fn() => view('kalkulator-statistik.standar-deviasi'))->name('kalkulator-statistik.standar-deviasi');
    Route::get('/kalkulator-kuartil', fn() => view('kalkulator-statistik.kuartil'))->name('kalkulator-statistik.kuartil');
    Route::get('/kalkulator-odds-probabilitas', fn() => view('kalkulator-statistik.odds-probabilitas'))->name('kalkulator-statistik.odds-probabilitas');
    Route::get('/kalkulator-probabilitas', fn() => view('kalkulator-statistik.probabilitas'))->name('kalkulator-statistik.probabilitas');
    Route::get('/kalkulator-persentil', fn() => view('kalkulator-statistik.persentil'))->name('kalkulator-statistik.persentil');
    Route::get('/kalkulator-ukuran-sampel', fn() => view('kalkulator-statistik.ukuran-sampel'))->name('kalkulator-statistik.ukuran-sampel');
});

// Route Visualisasi Data
Route::prefix('visualisasi-data')->name('visualisasi.')->group(function () {
    Route::get('/', fn() => view('visualisasi-data.index'))->name('index');
    Route::get('/histogram', [HistogramController::class, 'histogram'])->name('histogram');
    Route::post('/histogram/upload', [HistogramController::class, 'uploadData'])->name('histogram.upload');
    Route::post('/histogram/generate', [HistogramController::class, 'generateHistogram'])->name('histogram.generate');
    Route::get('/scatter', [ScatterController::class, 'scatter'])->name('scatter');
    Route::post('/scatter/upload', [ScatterController::class, 'uploadData'])->name('scatter.upload');
    Route::post('/scatter/generate', [ScatterController::class, 'generate'])->name('scatter.generate');
    Route::get('/piechart', [PieChartController::class, 'index'])->name('piechart');
    Route::post('/piechart/upload', [PieChartController::class, 'uploadData'])->name('piechart.upload');
    Route::post('/piechart/generate', [PieChartController::class, 'generatePieChart'])->name('piechart.generate');
    Route::get('/linechart', [LineChartController::class, 'linechart'])->name('linechart');
    Route::post('/linechart/upload', [LineChartController::class, 'uploadData'])->name('linechart.upload');
    Route::post('/linechart/generate', [LineChartController::class, 'generate'])->name('linechart.generate');
    Route::get('/boxplot', [BoxPlotController::class, 'boxplot'])->name('boxplot');
    Route::post('/boxplot/upload', [BoxPlotController::class, 'uploadData'])->name('boxplot.upload');
    Route::post('/boxplot/generate', [BoxPlotController::class, 'generate'])->name('boxplot.generate');
});

// Route Halaman Utama Kuis dan Tantangan Bulanan
Route::get('/kuis-dan-tantangan-bulanan', [KuisDanTantanganController::class, 'index'])->name('kuis-tantangan.index');


// Route informasi dan arsip karya program magang dan riset
Route::get('/program-magang/informasi-magang', [InformasiMagangController::class, 'indexUser'])->name('program-magang.index');
Route::get('/program-riset/informasi-riset', [InformasiRisetController::class, 'indexUser'])->name('program-riset.index');
Route::get('/program-riset/arsip-karya-kolaborasi-riset', [InformasiRisetController::class, 'arsipKarya'])->name('program-riset.arsipKarya');
Route::get('/program-magang/arsip-karya-magang', [InformasiMagangController::class, 'arsipKarya'])->name('program-magang.arsipKarya');

Route::middleware('auth')->group(function () {
    // Route Profil
    Route::get('/profil/{slug}', [ProfilController::class, 'show'])->name('profil.show');
    Route::get('/profil/{slug}/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::get('/profil/{slug}/artikel-dibaca', [ProfilController::class, 'showArtikelDibaca'])->name('profil.artikel');
    Route::get('/profil/{slug}/video-dilihat', [ProfilController::class, 'showVideoDilihat'])->name('profil.video');
    Route::get('/profil/{slug}/kuis-diselesaikan/kuis-reguler', [ProfilController::class, 'showKuisRegulerDiselesaikan'])->name('profil.kuis-reguler');
    Route::get('/profil/{slug}/kuis-diselesaikan/kuis-tantangan-bulanan', [ProfilController::class, 'showKuisTantanganDiselesaikan'])->name('profil.kuis-tantangan');

    // Route Pendaftaran Magang
    Route::get('/program-magang/daftar-magang', [PendaftaranMagangController::class, 'index'])->name('daftar-magang.index');
    Route::post('/program-magang/daftar-magang', [PendaftaranMagangController::class, 'store'])
        ->name('daftar-magang.store');
    Route::post('/program-magang/upload-laporan/{pendaftaran_magang}', [PendaftaranMagangController::class, 'uploadLaporan'])->name('daftar-magang.upload-laporan');
    Route::delete('/program-magang/hapus-laporan/{pendaftaran_magang}', [PendaftaranMagangController::class, 'hapusLaporan'])->name('daftar-magang.hapus-laporan');

    // Route Log Harian Magang
    Route::get('/program-magang/log-harian-magang', [LogHarianMagangController::class, 'index'])->name('daftar-magang.log-harian');
    Route::get('/program-magang/log-harian-magang/tambah-log-harian-magang', [LogHarianMagangController::class, 'create'])->name('log-harian.create-log');
    Route::post('/program-magang/log-harian-magang/tambah-log-harian-magang', [LogHarianMagangController::class, 'store'])->name('log-harian.store');
    Route::get('/program-magang/log-harian-magang/detail-log-harian-magang/{id}', [LogHarianMagangController::class, 'show'])->name('log-harian.show');
    Route::get('/program-magang/log-harian-magang/edit-log-harian-magang/{id}', [LogHarianMagangController::class, 'edit'])->name('log-harian.edit');
    Route::put('/program-magang/log-harian-magang/edit-log-harian-magang/{id}', [LogHarianMagangController::class, 'update'])->name('log-harian.update');
    Route::delete('/program-magang/log-harian-magang/hapus-log-harian-magang/{id}', [LogHarianMagangController::class, 'destroy'])->name('log-harian.destroy');
    Route::get('/log-harian/export-pdf', [LogHarianMagangController::class, 'exportPdf'])->name('log-harian.exportPdf');

    // Route Pendaftaran Riset Mandiri
    Route::get('/program-riset/daftar-riset', [PendaftaranRisetController::class, 'index'])->name('daftar-riset.index');
    Route::post('/program-riset/daftar-riset', [PendaftaranRisetController::class, 'store'])
        ->name('daftar-riset.store');
    Route::post('/program-riset/upload-laporan/{pendaftaran_riset}', [PendaftaranRisetController::class, 'uploadLaporan'])->name('daftar-riset.upload-laporan');
    Route::delete('/program-riset/hapus-laporan/{pendaftaran_riset}', [PendaftaranRisetController::class, 'hapusLaporan'])->name('daftar-riset.hapus-laporan');

    // Route Kuis dan Tantangan Bulanan
    // Kuis Reguler
    Route::get('/kuis-dan-tantangan-bulanan/kuis-reguler/{slug}', [KuisDanTantanganController::class, 'showSoalKuisReguler'])->name('kuis-tantangan.soal');
    Route::post('/kuis-dan-tantangan-bulanan/kuis-reguler/{slug}', [KuisDanTantanganController::class, 'submit'])->name('kuis.submit');
    Route::get('/kuis-dan-tantangan-bulanan/kuis-reguler/{slug}/hasil/{hasil_id}', [KuisDanTantanganController::class, 'hasil'])->name('kuis.hasil');
    Route::get('/kuis-dan-tantangan-bulanan/kuis-reguler/{slug}/jawaban/{hasil_id}', [KuisDanTantanganController::class, 'lihatJawaban'])->name('kuis.lihat-jawaban');
    Route::get('/kuis-dan-tantangan-bulanan/kuis-reguler/{slug}/riwayat-pengerjaan', [KuisDanTantanganController::class, 'riwayatKuis'])->name('kuis.riwayat');

    // Tantangan Bulanan
    Route::get('/kuis-dan-tantangan-bulanan/kuis-tantangan-bulanan/{slug}', [KuisDanTantanganController::class, 'showSoalTantanganBulanan'])->name('tantangan-bulanan.soal');
    Route::post('/kuis-dan-tantangan-bulanan/kuis-tantangan-bulanan/{slug}', [KuisDanTantanganController::class, 'submitTantanganBulanan'])->name('tantangan-bulanan.submit');
    Route::get('/kuis-dan-tantangan-bulanan/kuis-tantangan-bulanan/{slug}/hasil/{hasil_id}', [KuisDanTantanganController::class, 'hasilTantanganBulanan'])->name('tantangan-bulanan.hasil');
    // Route Presensi Magang
    // Page to view/perform presensi (optional pendaftaran id accepted so blade can pass $pendaftaran->id)
    Route::get('/program-magang/presensi/{pendaftaran?}', [PresensiMagangController::class, 'index'])->name('daftar-magang.presensi');
    // Form pages for presensi masuk/pulang
    Route::get('/program-magang/presensi/masuk/{pendaftaran?}', [PresensiMagangController::class, 'formMasuk'])->name('presensi.form-masuk');
    Route::get('/program-magang/presensi/pulang/{pendaftaran?}', [PresensiMagangController::class, 'formPulang'])->name('presensi.form-pulang');
    Route::post('/presensi/masuk', [PresensiMagangController::class, 'presensiMasuk'])->name('presensi.masuk');
    Route::post('/presensi/pulang', [PresensiMagangController::class, 'presensiPulang'])->name('presensi.pulang');

    // User presensi history
    Route::get('/program-magang/presensi/riwayat', [PresensiMagangController::class, 'history'])->name('presensi.history');
    //Route::post('/presensi/store', [PresensiMagangController::class, 'store'])->name('presensi.store');

    
    
});

// Route Simulasi Statistik
Route::prefix('simulasi-statistik')->name('simulasi.')->group(function () {
    Route::get('/', fn() => view('simulasi-statistik.index'))->name('index');
    Route::get('/simulasi-random-sampling', [SamplingSimulationController::class, 'index'])->name('sampling');
    Route::post('/simulasi-random-sampling', [SamplingSimulationController::class, 'simulate'])->name('sampling.run');
    Route::get('/simulasi-ukuran-sampel-slovin', [SimulasiSlovinController::class, 'index'])->name('slovin');
    Route::post('/simulasi-ukuran-sampel-slovin', [SimulasiSlovinController::class, 'hitung'])->name('slovin.hitung');
    Route::get('/distribusi-normal', [DistribusiNormalController::class, 'index'])->name('normal.index');
    Route::post('/distribusi-normal', [DistribusiNormalController::class, 'calculate'])->name('normal.calculate');
});

// Route Verifikasi Email
Route::get('/verify-otp', [OtpController::class, 'showForm'])->name('verification.otp');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verification.otp.submit');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('verification.otp.resend');





