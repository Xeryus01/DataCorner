<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\InfografisController;
use App\Http\Controllers\Admin\SubjekMateriController;
use App\Http\Controllers\Admin\InformasiRisetController;
use App\Http\Controllers\Admin\InformasiMagangController;
use App\Http\Controllers\Admin\SubJudulArtikelController;
use App\Http\Controllers\Admin\PendaftaranRisetController;
use App\Http\Controllers\Admin\PendaftaranMagangController;
use App\Http\Controllers\Admin\VideoPembelajaranController;
use App\Http\Controllers\Admin\DetailSubJudulArtikelController;
use App\Http\Controllers\Admin\KuisTantangan\PeriodeController;
use App\Http\Controllers\Admin\KuisReguler\KuisRegulerController;
use App\Http\Controllers\Admin\KuisReguler\SoalKuisRegulerController;
use App\Http\Controllers\Admin\KuisTantangan\TantanganBulananController;
use App\Http\Controllers\Admin\KuisTantangan\SoalTantanganBulananController;
use App\Http\Controllers\Admin\PengaturanPresensiController;
use App\Http\Controllers\Admin\WilayahBpsController;

/*
|--------------------------------------------------------------------------
| Modul Edukasi, Magang, Riset, Kuis, dan Presensi
|--------------------------------------------------------------------------
| Route ini sudah menjadi modul utama Datapedia, bukan sistem terpisah.
| Tidak ada login Student Corner. Semua akses admin memakai login Datapedia:
| /admin/loginAdmin
*/
Route::prefix('admin')->name('admin_')->middleware(['auth:admin'])->group(function () {
    // Alias agar view lama Student Corner tetap berjalan, tetapi diarahkan ke dashboard Datapedia.
    Route::redirect('/dashboard-edukasi', '/admin/dashboard')->name('dashboard');
    Route::redirect('/operator/dashboard', '/admin/konten-edukasi/subjek-materi')->name('operator.dashboard');
    Route::redirect('/operator-magang/dashboard', '/admin/program-magang/informasi-magang')->name('magang.dashboard');
    Route::redirect('/operator-kepegawaian/dashboard', '/admin/program-magang/informasi-magang')->name('kepegawaian.dashboard');
    Route::redirect('/logout-edukasi', '/admin/logoutAdmin')->name('logout');

    // Data admin/operator Student Corner sekarang menyatu sebagai manajemen admin Datapedia.
    Route::resource('data-admin', AdminController::class);

    /*
    |--------------------------------------------------------------------------
    | Konten Edukasi
    |--------------------------------------------------------------------------
    */
    Route::prefix('konten-edukasi')->group(function () {
        Route::resource('subjek-materi', SubjekMateriController::class);
        Route::resource('artikel', ArtikelController::class);

        Route::get('/subjudul-artikel/{id_artikel}', [SubJudulArtikelController::class, 'index'])
            ->name('subjudul-artikel.index');
        Route::get('/subjudul-artikel/create/{id_artikel}', [SubJudulArtikelController::class, 'create'])
            ->name('subjudul-artikel.create');
        Route::resource('subjudul-artikel', SubJudulArtikelController::class)->except('index', 'create');

        Route::get('/detail-subjudul-artikel/{id_subjudul}', [DetailSubJudulArtikelController::class, 'index'])
            ->name('detail-subjudul-artikel.index');
        Route::get('/detail-subjudul-artikel/create/{id_subjudul}', [DetailSubJudulArtikelController::class, 'create'])
            ->name('detail-subjudul-artikel.create');
        Route::resource('detail-subjudul-artikel', DetailSubJudulArtikelController::class)->except('index', 'create');

        Route::resource('video-pembelajaran', VideoPembelajaranController::class);
        Route::resource('infografis', InfografisController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Program Magang
    |--------------------------------------------------------------------------
    */
    Route::prefix('program-magang')->group(function () {
        Route::post('/informasi-magang/status-aktif/{id}', [InformasiMagangController::class, 'statusAktif'])
            ->name('informasi-magang.statusAktif');
        Route::post('/informasi-magang/status-nonaktif/{id}', [InformasiMagangController::class, 'statusNonaktif'])
            ->name('informasi-magang.statusNonaktif');
        Route::resource('informasi-magang', InformasiMagangController::class);

        Route::get('/pendaftaran-magang', [PendaftaranMagangController::class, 'index_admin'])
            ->name('daftar-magang.index-admin');
        Route::get('/pendaftaran-magang-diterima', [PendaftaranMagangController::class, 'magangDiterima'])
            ->name('daftar-magang.magangDiterima');
        Route::get('/pendaftaran-magang-ditolak', [PendaftaranMagangController::class, 'magangDitolak'])
            ->name('daftar-magang.magangDitolak');
        Route::get('/riwayat-pendaftaran-magang', [PendaftaranMagangController::class, 'riwayatMagang'])
            ->name('daftar-magang.riwayatMagang');

        Route::get('/pendaftaran-magang/{pendaftaran_id}', [PendaftaranMagangController::class, 'presensiMagang'])
            ->name('daftar-magang.presensi-magang');
        Route::get('/log-harian/{pendaftaran_id}', [PendaftaranMagangController::class, 'logHarian'])
            ->name('daftar-magang.logHarian');
        Route::get('/log-harian/detail/{id}', [PendaftaranMagangController::class, 'detailLog'])
            ->name('daftar-magang.detailLog');
        Route::post('/log-harian/verifikasi-setuju/{id}', [PendaftaranMagangController::class, 'verifikasiSetuju'])
            ->name('daftar-magang.verifikasiSetuju');
        Route::post('/log-harian/verifikasi-revisi/{id}', [PendaftaranMagangController::class, 'verifikasiRevisi'])
            ->name('daftar-magang.verifikasiRevisi');
        Route::post('/log-harian/verifikasi-tolak/{id}', [PendaftaranMagangController::class, 'verifikasiTolak'])
            ->name('daftar-magang.verifikasiTolak');

        Route::get('/pendaftaran-magang/{pendaftaran_magang}/edit', [PendaftaranMagangController::class, 'edit'])
            ->name('daftar-magang.edit');
        Route::get('/pendaftaran-magang/{pendaftaran_magang}/edit-diterima', [PendaftaranMagangController::class, 'editDiterima'])
            ->name('daftar-magang.edit-diterima');
        Route::get('/pendaftaran-magang/{pendaftaran_magang}/upload-sertifikat', [PendaftaranMagangController::class, 'editSertifikat'])
            ->name('daftar-magang.editSertifikat');
        Route::put('/pendaftaran-magang/{pendaftaran_magang}/upload-sertifikat', [PendaftaranMagangController::class, 'uploadSertifikat'])
            ->name('daftar-magang.upload-sertifikat');
        Route::put('/pendaftaran-magang/{pendaftaran_magang}', [PendaftaranMagangController::class, 'update'])
            ->name('daftar-magang.update');
        Route::delete('/pendaftaran-magang/{pendaftaran_magang}', [PendaftaranMagangController::class, 'destroy'])
            ->name('daftar-magang.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Presensi dan Wilayah BPS
    |--------------------------------------------------------------------------
    */
    Route::resource('pengaturan-presensi', PengaturanPresensiController::class);
    Route::resource('wilayah-bps', WilayahBpsController::class);

    /*
    |--------------------------------------------------------------------------
    | Program Riset
    |--------------------------------------------------------------------------
    */
    Route::prefix('program-riset')->group(function () {
        Route::resource('informasi-riset', InformasiRisetController::class);

        Route::get('/pendaftaran-riset', [PendaftaranRisetController::class, 'index_admin'])
            ->name('daftar-riset.index-admin');
        Route::get('/pendaftaran-riset-diterima', [PendaftaranRisetController::class, 'risetDiterima'])
            ->name('daftar-riset.risetDiterima');
        Route::get('/pendaftaran-riset-ditolak', [PendaftaranRisetController::class, 'risetDitolak'])
            ->name('daftar-riset.risetDitolak');
        Route::get('/riwayat-pendaftaran-riset', [PendaftaranRisetController::class, 'riwayatRiset'])
            ->name('daftar-riset.riwayatRiset');

        Route::get('/pendaftaran-riset/{pendaftaran_riset}/edit', [PendaftaranRisetController::class, 'edit'])
            ->name('daftar-riset.edit');
        Route::get('/pendaftaran-riset/{pendaftaran_riset}/edit-diterima', [PendaftaranRisetController::class, 'editDiterima'])
            ->name('daftar-riset.edit-diterima');
        Route::get('/pendaftaran-riset/{pendaftaran_riset}/upload-sertifikat', [PendaftaranRisetController::class, 'editSertifikat'])
            ->name('daftar-riset.editSertifikat');
        Route::put('/pendaftaran-riset/{pendaftaran_riset}/upload-sertifikat', [PendaftaranRisetController::class, 'uploadSertifikat'])
            ->name('daftar-riset.upload-sertifikat');
        Route::put('/pendaftaran-riset/{pendaftaran_riset}', [PendaftaranRisetController::class, 'update'])
            ->name('daftar-riset.update');
        Route::delete('/pendaftaran-riset/{pendaftaran_riset}', [PendaftaranRisetController::class, 'destroy'])
            ->name('daftar-riset.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Kuis dan Tantangan
    |--------------------------------------------------------------------------
    */
    Route::prefix('kuis-dan-tantangan')->group(function () {
        Route::resource('kuis-reguler', KuisRegulerController::class);

        Route::get('/soal-kuis-reguler/{id_kuis}', [SoalKuisRegulerController::class, 'index'])
            ->name('soal-kuis-reguler.index');
        Route::get('/soal-kuis-reguler/create/{id_kuis}', [SoalKuisRegulerController::class, 'create'])
            ->name('soal-kuis-reguler.create');
        Route::resource('soal-kuis-reguler', SoalKuisRegulerController::class)->except('index', 'create');

        Route::resource('periode', PeriodeController::class);
        Route::post('/periode/set-leaderboard/{id}', [PeriodeController::class, 'setLeaderboard'])
            ->name('periode.setLeaderboard');
        Route::post('/periode/nonaktifkan-leaderboard', [PeriodeController::class, 'nonaktifkanLeaderboard'])
            ->name('periode.nonaktifkanLeaderboard');

        Route::resource('kuis-tantangan-bulanan', TantanganBulananController::class);

        Route::get('/soal-kuis-tantangan-bulanan/{id_kuis}', [SoalTantanganBulananController::class, 'index'])
            ->name('soal-kuis-tantangan-bulanan.index');
        Route::get('/soal-kuis-tantangan-bulanan/create/{id_kuis}', [SoalTantanganBulananController::class, 'create'])
            ->name('soal-kuis-tantangan-bulanan.create');
        Route::resource('soal-kuis-tantangan-bulanan', SoalTantanganBulananController::class)->except('index', 'create');
    });
});
