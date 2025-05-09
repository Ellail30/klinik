<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Hitung total transaksi pembelian
        $totalTransaksi = DB::table('det_transaksi_pembelian')->count();

        // Statistik Harian
        $hariIni = Carbon::today();
        $kunjunganHarian = Kunjungan::whereDate('TanggalKunjungan', $hariIni)
            ->groupBy('Poli')
            ->selectRaw('Poli, COUNT(*) as total')
            ->get();

        // Statistik Bulanan
        $bulanIni = Carbon::now();
        $kunjunganBulanan = Kunjungan::whereYear('TanggalKunjungan', $bulanIni->year)
            ->whereMonth('TanggalKunjungan', $bulanIni->month)
            ->groupBy('Poli')
            ->selectRaw('Poli, COUNT(*) as total')
            ->get();

        // Statistik Status Kunjungan Hari Ini
        $statusKunjungan = Kunjungan::whereDate('TanggalKunjungan', $hariIni)
            ->groupBy('Status')
            ->selectRaw('Status, COUNT(*) as total')
            ->get();

        // Total Pasien
        $totalPasien = Pasien::count();

        // Pasien Baru Bulan Ini
        $pasienBaruBulanIni = Pasien::whereYear('created_at', $bulanIni->year)
            ->whereMonth('created_at', $bulanIni->month)
            ->count();

        return view('dashboard', [
            'user' => session('user'),
            'kunjunganHarian' => $kunjunganHarian,
            'kunjunganBulanan' => $kunjunganBulanan,
            'statusKunjungan' => $statusKunjungan,
            'totalPasien' => $totalPasien,
            'pasienBaruBulanIni' => $pasienBaruBulanIni,
            'totalTransaksi' => $totalTransaksi
        ]);
    }

    public function grafikKunjungan()
    {
        // Grafik Kunjungan 7 Hari Terakhir
        $tujuhHariTerakhir = Kunjungan::where('TanggalKunjungan', '>=', Carbon::now()->subDays(7))
            ->groupBy('Poli', DB::raw('DATE(TanggalKunjungan)'))
            ->selectRaw('Poli, DATE(TanggalKunjungan) as tanggal, COUNT(*) as total')
            ->get()
            ->groupBy('Poli');

        return response()->json($tujuhHariTerakhir);
    }
    
}
