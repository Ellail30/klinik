<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', function () {
    return view('dashboard'); // Mengarahkan ke halaman dashboard
})->name('dashboard');
Route::resource('obat', ObatController::class);

Route::get('/obat', [ObatController::class, 'index']);
Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');
Route::post('/obat/store', [ObatController::class, 'store'])->name('obat.store');;
Route::get('/obat/edit/{id}', [ObatController::class, 'edit'])->name('obat.edit');
Route::put('/obat/update/{id}', [ObatController::class, 'update'])->name('obat.update');

Route::get('/supplier', function () {
    return view('supplier'); // Mengarahkan ke halaman supplier
});

Route::get('/pasien', function () {
    return view('pasien'); // Mengarahkan ke halaman pasien
});

Route::get('/obat_keluar', function () {
    return view('obat_keluar'); // Mengarahkan ke halaman obat keluar
});

Route::get('/obat_kadaluwarsa', function () {
    return view('obat_kadaluwarsa'); // Mengarahkan ke halaman obat kadaluwarsa
});

Route::get('/laporan_masuk', function () {
    return view('laporan_masuk'); // Mengarahkan ke halaman laporan obat masuk
});

Route::get('/laporan_keluar', function () {
    return view('laporan_keluar'); // Mengarahkan ke halaman laporan obat keluar
});

Route::get('/laporan_persediaan', function () {
    return view('laporan_persediaan'); // Mengarahkan ke halaman laporan persediaan
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


