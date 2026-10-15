<?php

use Illuminate\Support\Facades\Route;

use App\Models\Produk;

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ChatAIController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\GeminiController;

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\KapalController;
use App\Http\Controllers\Admin\TeknisiController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\TrackingPesananController;
use App\Http\Controllers\Admin\SerialProdukController;
use App\Http\Controllers\Admin\AdminKlaimGaransiController;
use App\Http\Controllers\Admin\TiketTeknisiController;
use App\Http\Controllers\Admin\VerifikasiGaransiController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DetailPesananController;

use App\Http\Controllers\Frontend\KlaimGaransiController as FrontendKlaimGaransiController;
use App\Http\Controllers\Frontend\LacakPesananController;


/*
|--------------------------------------------------------------------------
| BERANDA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $products = Produk::latest()->take(6)->get();

    return view('frontend.beranda.home', compact('products'));

});


/*
|--------------------------------------------------------------------------
| ADMIN LOGIN REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/admin', function () {
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', function () {

            return view('backend.dashboard.dashboard');

        })->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | PRODUK
        |--------------------------------------------------------------------------
        */

        Route::resource('produk', ProdukController::class);

        Route::resource('kategori-produk', KategoriProdukController::class);


        /*
        |--------------------------------------------------------------------------
        | ROLE & USER
        |--------------------------------------------------------------------------
        */

        Route::middleware(['superadmin'])->group(function () {

            Route::resource('users', UserAdminController::class);

            Route::resource('roles', RoleController::class);

        });


        /*
        |--------------------------------------------------------------------------
        | PERMISSION
        |--------------------------------------------------------------------------
        */

        Route::get('/permissions', [PermissionController::class, 'index'])
            ->name('permissions.index');

        Route::post('/permission-toggle', [PermissionController::class, 'toggle'])
            ->name('permissions.toggle');


        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        */

        Route::resource('customer', CustomerController::class);

        Route::resource('kapal', KapalController::class);

        Route::resource('teknisi', TeknisiController::class);


        /*
        |--------------------------------------------------------------------------
        | PESANAN
        |--------------------------------------------------------------------------
        */

        Route::resource('pesanan', PesananController::class);

        Route::resource('pembayaran', PembayaranController::class);

        Route::resource('tracking-pesanan', TrackingPesananController::class);

        Route::resource('detail-pesanan', DetailPesananController::class);


        /*
        |--------------------------------------------------------------------------
        | SERIAL PRODUK
        |--------------------------------------------------------------------------
        */

        Route::get('serial-produk', [SerialProdukController::class, 'index'])
            ->name('serial-produk.index');

        Route::get('serial-produk/{id}', [SerialProdukController::class, 'show'])
            ->name('serial-produk.show');

        Route::delete('serial-produk/{id}', [SerialProdukController::class, 'destroy'])
            ->name('serial-produk.destroy');


        /*
        |--------------------------------------------------------------------------
        | KLAIM GARANSI ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/klaim-garansi', [AdminKlaimGaransiController::class, 'index'])
            ->name('klaim-garansi.index');

        Route::get('/klaim-garansi/{id}/detail', [AdminKlaimGaransiController::class, 'detail'])
            ->name('klaim-garansi.detail');

        Route::patch('/klaim-garansi/{id}/terima', [AdminKlaimGaransiController::class, 'terima'])
            ->name('klaim-garansi.terima');

        Route::patch('/klaim-garansi/{id}/tolak', [AdminKlaimGaransiController::class, 'tolak'])
            ->name('klaim-garansi.tolak');

        Route::delete('/klaim-garansi/{id}', [AdminKlaimGaransiController::class, 'destroy'])
            ->name('klaim-garansi.destroy');

        /*
        |--------------------------------------------------------------------------
        | TIKET TEKNISI
        |--------------------------------------------------------------------------
        */

        Route::resource('tiket-teknisi', TiketTeknisiController::class);


        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI GARANSI
        |--------------------------------------------------------------------------
        */

        Route::resource('verifikasi-garansi', VerifikasiGaransiController::class);


        /*
        |--------------------------------------------------------------------------
        | ACTIVITY LOG
        |--------------------------------------------------------------------------
        */

        Route::resource('activity-log', ActivityLogController::class);

    });


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| FRONTEND PRODUK
|--------------------------------------------------------------------------
*/

Route::get('/produk', [ProdukController::class, 'semuaProduk'])
    ->name('produk');

Route::get('/produk/kategori/{slug}', [ProdukController::class, 'kategori'])
    ->name('produk.kategori');

Route::get('/produk/{slug}', [ProdukController::class, 'detail'])
    ->name('produk.detail');

Route::get('/produk/{slug}', [ProdukController::class, 'detail'])
    ->name('produk.detail');

Route::get('/search-produk', [ProdukController::class, 'searchAjax']);


/*
|--------------------------------------------------------------------------
| FRONTEND HALAMAN
|--------------------------------------------------------------------------
*/

Route::view('/tentang-kami', 'frontend.tentang kami.index')
    ->name('tentang');

Route::get('/hubungi-kami', function () {

    return view('frontend.kontak.index');

})->name('hubungi');

Route::get('/status-pesanan', function () {

    return view('frontend.pesanan.index');

})->name('status.pesanan');

Route::post('/chatbot', [GeminiController::class, 'chat']);
/*
|--------------------------------------------------------------------------
| FRONTEND KLAIM GARANSI
|--------------------------------------------------------------------------
*/

Route::get('/klaim-garansi', [FrontendKlaimGaransiController::class, 'index'])
    ->name('klaim.garansi');

Route::post('/klaim-garansi/cek', [FrontendKlaimGaransiController::class, 'cekKode'])
    ->name('klaim.garansi.cek');

Route::get('/klaim-garansi/form/{kode}', [FrontendKlaimGaransiController::class, 'form'])
    ->name('klaim.garansi.form');

Route::post('/klaim-garansi/store', [FrontendKlaimGaransiController::class, 'store'])
    ->name('klaim.garansi.store');

Route::get('/klaim-garansi/tiket/{id}', [FrontendKlaimGaransiController::class, 'tiket'])
    ->name('klaim.garansi.tiket');

Route::get('/klaim-garansi/hasil/{id}', [FrontendKlaimGaransiController::class, 'hasil'])
    ->name('klaim.garansi.hasil');


/*
|--------------------------------------------------------------------------
| FRONTEND LACAK PESANAN
|--------------------------------------------------------------------------
*/

Route::get('/lacak-pesanan', [LacakPesananController::class, 'index'])
    ->name('lacak-pesanan.index');

Route::post('/lacak-pesanan/cari', [LacakPesananController::class, 'cari'])
    ->name('lacak-pesanan.cari');

Route::get('/lacak-pesanan/{invoice}', [LacakPesananController::class, 'show'])
    ->name('lacak-pesanan.show');