<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatMasukController;
use App\Http\Controllers\ObatKeluarController;
use App\Http\Controllers\ConfigUsersController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\KunjunganController;




Route::get('/', [HomeController::class, 'index'])->name('landingpage');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('processLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/config_user', [ConfigUsersController::class, 'index'])->name('config_user.index');
Route::post('/config_user/store', [ConfigUsersController::class, 'store'])->name('config_user.store');
Route::delete('/config_user/{username}', [ConfigUsersController::class, 'destroy'])->name('config_user.destroy');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/grafik-kunjungan', [DashboardController::class, 'grafikKunjungan'])
    ->name('dashboard.grafik-kunjungan');

Route::resource('obat', ObatController::class);

Route::get('/obat/details-by-barcode', [ObatController::class, 'getMedicineDetailsByBarcode']);

Route::resource('supplier', SupplierController::class);

Route::get('/config_user', [ConfigUsersController::class, 'index'])->name('config_user.index');
Route::post('/config_user/store', [ConfigUsersController::class, 'store'])->name('config_user.store');
Route::delete('/config_user/{username}', [ConfigUsersController::class, 'destroy'])->name('config_user.destroy');

Route::resource('pasien', PasienController::class);
Route::get('/pasien/cari', [PasienController::class, 'cariPasien'])->name('pasien.cari');
Route::get('/pasien/riwayat-kunjungan/{id}', [PasienController::class, 'riwayatKunjungan'])->name('pasien.riwayat-kunjungan');


Route::prefix('pendaftaran')->group(function () {
    Route::get('/', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::get('/cari', [PendaftaranController::class, 'cariPasien'])->name('pendaftaran.cari');
    Route::post('/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/daftar-ulang/{pasien}', [PendaftaranController::class, 'daftarUlang'])->name('pendaftaran.daftar-ulang');
    Route::post('/daftar-ulang/{pasien}', [PendaftaranController::class, 'simpanDaftarUlang'])->name('pendaftaran.simpan-daftar-ulang');
});

Route::get('/kunjungan/{idKunjungan}', [KunjunganController::class, 'show'])->name('kunjungan.show');
Route::get('/kunjungan/statistik', [KunjunganController::class, 'statistikKunjungan'])->name('statisitk-kunjungan');

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


