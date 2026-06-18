<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminKonsultasiController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\layananController;
use App\Http\Controllers\maklumatController;
use App\Http\Controllers\faqController;
use App\Http\Controllers\grafikPosisiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\janjitemuController;
use App\Http\Controllers\jadwalController;
use App\Http\Controllers\JamOperasionalController;
use App\Http\Controllers\konsultanController;
use App\Http\Controllers\konsultanJadwalController;
use App\Http\Controllers\konsultanMingguanController;
use App\Http\Controllers\konsultanStatusController;
use App\Http\Controllers\konsultasiController;
use App\Http\Controllers\standarController;
use App\Http\Controllers\PetugasBerprestasiController;
use App\Http\Controllers\Login\AdminLogin;
use App\Http\Middleware\LoginCheckAdmin;
use App\Http\Middleware\LoggedInAdmin;
use App\Http\Controllers\Login\KonsultanLogin;
use App\Http\Middleware\LoginCheckKonsultan;
use App\Http\Middleware\LoggedInKonsultan;
use App\Http\Middleware\LoggedInUser;
use App\Http\Controllers\Login\UserLogin;
use App\Http\Controllers\petugasController;
use App\Http\Controllers\profileController;
use App\Http\Middleware\LoginCheckUser;
use App\Http\Middleware\SessionTimeout;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\Statistik\PerpustakaanController;
use App\Http\Controllers\Statistik\ProdukStatistikController;
use App\Http\Controllers\Statistik\KonsultasiStatistikController;
use App\Http\Controllers\Statistik\PojokStatistikController;
use App\Http\Controllers\Statistik\RekomendasiController;
use App\Http\Controllers\Statistik\WebsiteController;
use App\Http\Controllers\BidangKeahlianController;
use App\Http\Controllers\Admin\FooterItemController;
use App\Http\Controllers\Admin\SurveiLayananController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Models\janjitemu;

Route::middleware(LoggedInKonsultan::class)->group(function () {
    Route::get('/logoutKonsultan', [KonsultanLogin::class, 'logoutKonsultan'])->name('logoutKonsultan');
    Route::resource('status', konsultanStatusController::class)->except(['show']);
    Route::resource('mingguan', konsultanMingguanController::class)->except(['show']);
    Route::get('/konsultan/jadwal', [konsultanJadwalController::class, 'index'])->name('konsultan.jadwal.index');
    Route::get('/konsultan/berprestasi', [konsultanMingguanController::class, 'berprestasi'])->name('konsultan.berprestasi');
});

Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');

Route::middleware(LoggedInUser::class)->group(function () {
    Route::post('/klik-konsultasi', [konsultasiController::class, 'store'])->name('konsultasi.klik');
    Route::get('/user/jumlah', [konsultasiController::class, 'jumlah'])->name('konsultasi.jumlah');
    Route::get('/user/konsultasi', [konsultasiController::class, 'index'])->name('konsultasi.index');
    Route::resource('profile', profileController::class)->except(['show']);    
    // Route::get('/janjitemu/online', [janjitemuController::class, 'indexOnline'])->name('janjitemu.online');
    Route::get('/janjitemu/jadwal', [janjitemuController::class, 'indexJadwal'])->name('janjitemu.jadwal');
    Route::put('/janjitemu/{id}/batal', [janjitemuController::class, 'batal'])->name('janjitemu.batal');
    Route::resource('janjitemu', janjitemuController::class)->except(['show']);

});

Route::prefix('admin')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', fn() => redirect()->route('loginAdmin'))->name('admin_login');
        Route::get('/loginAdmin', [AdminLogin::class, 'loginAdmin'])->name('loginAdmin');
        Route::post('/prosesloginAdmin', [AdminLogin::class, 'prosesloginAdmin'])->name('prosesloginAdmin');
    });

    Route::middleware('auth:admin')->group(function () {

        // akses /admin
        Route::get('/', function () {
            return redirect()->route('dashboard.index');
        });

        Route::get('/user', [UserLogin::class, 'dataUser'])->name('dataUser');
        Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard.index');

        Route::resource('jam-operasional', JamOperasionalController::class);
        Route::resource('bidang-keahlian', BidangKeahlianController::class)->except(['show']);
        Route::resource('jadwal', jadwalController::class)->except(['show', 'create', 'store', 'edit', 'update']);

        Route::post('/jadwal/{id}/tolak', [JadwalController::class, 'tolak'])->name('jadwal.tolak');
        Route::delete('/jadwal/{jadwal_id}/batal', [JadwalController::class, 'batalJadwal'])->name('jadwal.batal');
        Route::get('/jadwal/{id}/zoom', [JadwalController::class, 'formZoom'])->name('jadwal.zoom');
        Route::post('/jadwal/{id}/zoom', [JadwalController::class, 'kirimZoom'])->name('jadwal.kirimZoom');
        Route::post('/jadwal/{id}/schedule', [JadwalController::class, 'scheduleAndApprove'])->name('jadwal.schedule');

        Route::resource('faq', faqController::class)->except(['show']);
        Route::get('/faq/pesan', [faqController::class, 'pesan'])->name('faq.pesan');
        Route::delete('/faq/hapusPesan/{id}', [faqController::class, 'hapusPesan'])->name('faq.hapusPesan');

        Route::resource('konsultan', konsultanController::class)->except(['show']);
        Route::resource('admin', AdminController::class)->except(['show']);
        Route::resource('adminKonsultasi', AdminKonsultasiController::class)->except('show');

        Route::resource('maklumat', maklumatController::class)->except(['show']);
        Route::resource('layanan', layananController::class)->except(['show']);
        Route::resource('petugas', petugasController::class)->except(['show']);
        Route::resource('footer-item', FooterItemController::class)->except(['show']);
        Route::resource('survei-layanan', SurveiLayananController::class)->except(['show']);
        Route::resource('petugas-berprestasi', PetugasBerprestasiController::class)->except(['show']);
        
        Route::prefix('statistik')->name('statistik.')->group(function () {
            Route::resource('perpustakaan',PerpustakaanController::class);
            Route::resource('produk-statistik',ProdukStatistikController::class);
            Route::resource('konsultasi-statistik',KonsultasiStatistikController::class);
            Route::resource('rekomendasi',RekomendasiController::class);
            Route::resource('pojok-statistik',PojokStatistikController::class);
            Route::resource('website',WebsiteController::class);

        });

        Route::get('/petugas/export-pdf', [petugasController::class, 'exportPdf'])
            ->name('petugas.export-pdf');

        Route::resource('standar', standarController::class)->except(['show']);
        Route::delete('/jadwal/hapus/{id}', [jadwalController::class, 'hapus'])->name('jadwal.hapus');

        Route::get('/logoutAdmin', [AdminLogin::class, 'logoutAdmin'])->name('logoutAdmin');
    });

});

Route::prefix('statistik')->group(function () {

    Route::resource('perpustakaan',PerpustakaanController::class);

});


// Route::middleware(LoginCheckAdmin::class)->group(function () {
// });

Route::middleware(LoginCheckKonsultan::class)->group(function () {
    Route::get('/loginKonsultan', [KonsultanLogin::class, 'loginKonsultan'])->name('loginKonsultan');
    Route::post('/prosesloginKonsultan', [KonsultanLogin::class, 'prosesloginKonsultan'])->name('prosesloginKonsultan');
});

    Route::post('/logoutUser', [UserLogin::class, 'logoutUser'])->name('logoutUser');
    Route::post('/logout', [UserLogin::class, 'logoutUser'])->name('logout');
    Route::get('/login', fn() => redirect()->route('loginUser'))->name('login');
    Route::get('/register', fn() => redirect()->route('registerUser'))->name('register');
    Route::get('/loginUser', [UserLogin::class, 'loginUser'])->name('loginUser');
    Route::post('/prosesloginUser', [UserLogin::class, 'prosesloginUser'])->name('prosesloginUser');
    Route::get('/registerUser', [UserLogin::class, 'registerUser'])->name('registerUser');
    Route::post('/prosesregisterUser', [UserLogin::class, 'daftar'])->name('prosesregisterUser');

    Route::middleware('guest')->group(function () {
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');
    });

Route::get('/', [HomeController::class, 'index'])->name('home');










/*
|--------------------------------------------------------------------------
| Student Corner Module Routes
|--------------------------------------------------------------------------
| Fitur Student Corner digabungkan menjadi fitur utama Datapedia.
| Route publik memakai menu Datapedia. Route admin masuk langsung ke /admin/...
*/
require __DIR__ . '/student_corner.php';
require __DIR__ . '/student_corner_admin.php';
// Login bawaan Student Corner/Breeze dinonaktifkan agar login hanya satu pintu lewat Datapedia.
// require __DIR__ . '/auth.php';
