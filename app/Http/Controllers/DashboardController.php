<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
{
    if (!session('user')) {
        return redirect()->route('login');
    }

    // Hitung total transaksi pembelian
    $totalTransaksi = DB::table('det_transaksi_pembelian')->count();

    return view('dashboard', [
        'user' => session('user'),
        'totalTransaksi' => $totalTransaksi
    ]);
}
}
