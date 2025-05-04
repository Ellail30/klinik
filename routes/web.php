<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatKeluarController;
use App\Http\Controllers\ObatMasukController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ConfigUsersController;




Route::get('/', [HomeController::class, 'index'])->name('landingpage');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('processLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
Route::get('/config_user', [ConfigUsersController::class, 'index'])->name('config_user.index');
Route::post('/config_user/store', [ConfigUsersController::class, 'store'])->name('config_user.store');
Route::delete('/config_user/{username}', [ConfigUsersController::class, 'destroy'])->name('config_user.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Route::get('/dokter/dashboard', function () {
    //     return view('dokter.dashboard');
    // })->name('dokter.dashboard');

    // Route::get('/apoteker/dashboard', function () {
    //     return view('apoteker.dashboard');
    // })->name('apoteker.dashboard');

    // Route::get('/pimpinan/dashboard', function () {
    //     return view('pimpinan.dashboard');
    // })->name('pimpinan.dashboard');
});

Route::resource('obat', ObatController::class);
Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');
Route::post('/obat/store', [ObatController::class, 'store'])->name('obat.store');;
Route::get('/obat/edit/{id}', [ObatController::class, 'edit'])->name('obat.edit');
Route::put('/obat/update/{id}', [ObatController::class, 'update'])->name('obat.update');

Route::get('/obat/details-by-barcode', [ObatController::class, 'getMedicineDetailsByBarcode']);

Route::resource('supplier', SupplierController::class);
Route::get('supplier', [SupplierController::class, 'index']);
Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');;
Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');

Route::get('/config_user', [ConfigUsersController::class, 'index'])->name('config_user.index');
Route::post('/config_user/store', [ConfigUsersController::class, 'store'])->name('config_user.store');
Route::delete('/config_user/{username}', [ConfigUsersController::class, 'destroy'])->name('config_user.destroy');

Route::resource('pasien', PasienController::class);
Route::get('pasien', [PasienController::class, 'index']);Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');
Route::post('/pasien/store', [PasienController::class, 'store'])->name('pasien.store');;
Route::get('/pasien/edit/{id}', [PasienController::class, 'edit'])->name('pasien.edit');
Route::put('/pasien/update/{id}', [PasienController::class, 'update'])->name('pasien.update');


Route::resource('obatkeluar', ObatKeluarController::class);
Route::get('obatkeluar', [ObatKeluarController::class, 'index']);

// Route::resource('det_transaksi_pembelian', ObatMasukController::class)->parameters(['det_transaksi_pembelian' => 'NoDetBeli']);
// Route::get('obatmasuk', [ObatMasukController::class, 'index']);
// Route::delete('/obatmasuk/{id}', [ObatMasukController::class, 'destroy'])->name('obatmasuk.destroy');
// Route::post('/obatmasuk', [ObatMasukController::class, 'store'])->name('obatmasuk.store');
// Route::get('/obatmasuk/edit/{id}', [ObatMasukController::class, 'edit'])->name('obatmasuk.edit');
// Route::put('/obatmasuk/update/{id}', [ObatMasukController::class, 'update'])->name('obatmasuk.update');


Route::prefix('obat-masuk')->group(function () {
    Route::get('/', [ObatMasukController::class, 'index'])
        ->name('obat-masuk.index');

    Route::get('/create', [ObatMasukController::class, 'create'])
        ->name('obat-masuk.create');

    Route::post('/store', [ObatMasukController::class, 'store'])
        ->name('obat-masuk.store');

    Route::get('/{NoFaktur}', [ObatMasukController::class, 'show'])->where('NoFaktur', '.*')
        ->name('obat-masuk.show');

    Route::get('/{NoFaktur}/edit', [ObatMasukController::class, 'edit'])
        ->name('obat-masuk.edit');

    Route::put('/{NoFaktur}', [ObatMasukController::class, 'update'])
        ->name('obat-masuk.update');

    Route::delete('/{NoFaktur}', [ObatMasukController::class, 'destroy'])
        ->name('obat-masuk.destroy');

    Route::get('/search-barcode', [ObatMasukController::class, 'searchByBarcode']);
    Route::get('/get-obat-details', [ObatMasukController::class, 'getObatDetails']);

});
Route::get('/cari-barcode', [ObatMasukController::class, 'cariBarcode']);

Route::get('/obat_kadaluwarsa', function () {
    return view('obat_kadaluwarsa'); // Mengarahkan ke halaman obat kadaluwarsa
});


Route::get('/laporan_keluar', function () {
    return view('laporan_keluar'); // Mengarahkan ke halaman laporan obat keluar
});

Route::get('/laporan_persediaan', function () {
    return view('laporan_persediaan'); // Mengarahkan ke halaman laporan persediaan
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


