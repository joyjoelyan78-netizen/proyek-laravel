<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPermintaanPenawaranController;
use App\Http\Controllers\Admin\AdminKonsultasiTeknisController;
use App\Http\Controllers\Frontend\PermintaanPenawaranController;
use App\Http\Controllers\Frontend\KonsultasiTeknisController;
use App\Support\KatalogVesca;
use App\Http\Controllers\Frontend\KontakController;
use App\Models\Produk;
use App\Http\Controllers\KategoriProdukController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return view('frontend.beranda.home', [
        'products' => KatalogVesca::unggulan(2),
    ]);
});

Route::get('/tentang-kami', function () {
    return view('frontend.tentang kami.index');
})->name('tentang');

Route::get('/hubungi-kami', function () {
    return view('frontend.kontak.index');
})->name('hubungi');

Route::post('/hubungi-kami', [KontakController::class, 'store'])
    ->middleware('throttle:10,10')
    ->name('hubungi.store');

Route::view('/galeri', 'frontend.galeri.index')
    ->name('galeri');   

/*
|--------------------------------------------------------------------------
| PRODUK (data dari kode: config/katalog_vesca.php)
|--------------------------------------------------------------------------
*/

Route::get('/produk', [ProdukController::class, 'semuaProduk'])
    ->name('produk');

Route::get('/produk/kategori/{slug}', [ProdukController::class, 'kategori'])
    ->name('produk.kategori');

Route::get('/produk/{slug}', [ProdukController::class, 'detail'])
    ->name('produk.detail');

Route::get('/search-produk', [ProdukController::class, 'searchAjax']);


/*
|--------------------------------------------------------------------------
| CHATBOT
|--------------------------------------------------------------------------
*/

Route::post('/chatbot', [GeminiController::class, 'chat']);


/*
|--------------------------------------------------------------------------
| MINTA PENAWARAN RESMI
|--------------------------------------------------------------------------
*/

Route::get('/minta-penawaran', [PermintaanPenawaranController::class, 'index'])
    ->name('penawaran.index');

Route::post('/minta-penawaran', [PermintaanPenawaranController::class, 'store'])
    ->middleware('throttle:10,10')
    ->name('penawaran.store');

Route::get('/minta-penawaran/terkirim', [PermintaanPenawaranController::class, 'sukses'])
    ->name('penawaran.sukses');



/*
|--------------------------------------------------------------------------
| PRODUK
|--------------------------------------------------------------------------
*/

Route::get('/produk', [ProdukController::class, 'semuaProduk'])
    ->name('produk');

Route::get('/produk/kategori/{slug}', [ProdukController::class, 'kategori'])
    ->name('produk.kategori');

Route::get('/produk/{slug}', [ProdukController::class, 'detail'])
    ->name('produk.detail');

Route::get('/search-produk', [ProdukController::class, 'searchAjax']);

/*
|--------------------------------------------------------------------------
| KONSULTASI & SPESIFIKASI TEKNIS
|--------------------------------------------------------------------------
*/

Route::get('/konsultasi-teknis', [KonsultasiTeknisController::class, 'index'])
    ->name('konsultasi.index');

Route::post('/konsultasi-teknis', [KonsultasiTeknisController::class, 'store'])
    ->middleware('throttle:10,10')
    ->name('konsultasi.store');

Route::get('/konsultasi-teknis/terkirim', [KonsultasiTeknisController::class, 'sukses'])
    ->name('konsultasi.sukses');


/*
|--------------------------------------------------------------------------
| LINK LAMA -> HALAMAN PENGGANTI
|--------------------------------------------------------------------------
| Fitur Lacak Pesanan dan Klaim Garansi sudah dihapus. Link lama
| (bookmark / hasil pencarian Google) diarahkan ke halaman penggantinya.
*/

Route::redirect('/lacak-pesanan', '/minta-penawaran', 301);
Route::redirect('/status-pesanan', '/minta-penawaran', 301);
Route::redirect('/klaim-garansi', '/konsultasi-teknis', 301);


/*
|--------------------------------------------------------------------------
| ADMIN (harus login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // ----- Permintaan Penawaran -----
        Route::get('/permintaan-penawaran', [AdminPermintaanPenawaranController::class, 'index'])
            ->name('admin.penawaran.index');

        Route::get('/permintaan-penawaran/{id}', [AdminPermintaanPenawaranController::class, 'show'])
            ->name('admin.penawaran.show');

        Route::patch('/permintaan-penawaran/{id}', [AdminPermintaanPenawaranController::class, 'update'])
            ->name('admin.penawaran.update');

        Route::delete('/permintaan-penawaran/{id}', [AdminPermintaanPenawaranController::class, 'destroy'])
            ->name('admin.penawaran.destroy');

        // ----- Konsultasi Teknis -----
        Route::get('/konsultasi-teknis', [AdminKonsultasiTeknisController::class, 'index'])
            ->name('admin.konsultasi.index');

        Route::get('/konsultasi-teknis/{id}', [AdminKonsultasiTeknisController::class, 'show'])
            ->name('admin.konsultasi.show');

        Route::patch('/konsultasi-teknis/{id}', [AdminKonsultasiTeknisController::class, 'update'])
            ->name('admin.konsultasi.update');

        Route::delete('/konsultasi-teknis/{id}', [AdminKonsultasiTeknisController::class, 'destroy'])
            ->name('admin.konsultasi.destroy');

                // CRUD KATEGORI PRODUK
        Route::resource('kategori-produk', KategoriProdukController::class);

        // CRUD PRODUK
        Route::resource('produk', ProdukController::class);

        // ----- Akun saya (ganti password) -----
        Route::view('/akun', 'backend.akun.index')
            ->name('admin.akun');

        // ----- Akun admin lain (khusus Super Admin) -----
        Route::middleware('superadmin')->group(function () {

            Route::get('/users', [UserAdminController::class, 'index'])->name('admin.users.index');
            Route::get('/users/create', [UserAdminController::class, 'create'])->name('admin.users.create');
            Route::post('/users', [UserAdminController::class, 'store'])->name('admin.users.store');
            Route::get('/users/{id}/edit', [UserAdminController::class, 'edit'])->name('admin.users.edit');
            Route::put('/users/{id}', [UserAdminController::class, 'update'])->name('admin.users.update');
            Route::delete('/users/{id}', [UserAdminController::class, 'destroy'])->name('admin.users.destroy');
        });
    });


/*
|--------------------------------------------------------------------------
| LOGIN / LOGOUT
|--------------------------------------------------------------------------
| Pendaftaran akun publik (register) SENGAJA dihapus: akun admin dibuat
| oleh Super Admin lewat menu Akun Admin.
*/

require __DIR__ . '/auth.php';
