<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/obat', function () {
    return view('obat'); // Mengarahkan ke halaman obat
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


