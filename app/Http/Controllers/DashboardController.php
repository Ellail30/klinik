<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Resep;
use App\Models\Pasien;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use App\Models\TransaksiPembelian;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Current date and 3 months from now for expiry check
        $today = Carbon::now();
        $threeMonthsLater = Carbon::now()->addMonths(3);
        $startOfMonth = Carbon::now()->startOfMonth();

        // Get statistics
        $totalPembelian = TransaksiPembelian::count();
        $totalPenjualan = Resep::where('Status', 'Sudah Diambil')->count();

        // Total revenue from sales (resep yang sudah diambil)
        $totalRevenue = DB::table('pembayaran')
            ->join('resep', 'pembayaran.IdResep', '=', 'resep.IdResep')
            ->where('resep.Status', 'Sudah Diambil')
            ->sum('pembayaran.TotalBayar');

        // Total items sold
        $totalBarangKeluar = DB::table('detail_resep')
            ->join('resep', 'detail_resep.IdResep', '=', 'resep.IdResep')
            ->where('resep.Status', 'Sudah Diambil')
            ->sum('detail_resep.Jumlah');

        // Count of expired medications
        $totalKadaluarsa = Obat::where('TglExp', '<', $today)->count();

        // Get medications that will expire within 3 months
        $expiringMeds = Obat::where('TglExp', '<', $today)
            ->where('TglExp', '<=', $threeMonthsLater)
            ->orderBy('TglExp', 'asc')
            ->get(['id_obat', 'NamaObat', 'TglExp', 'stok', 'Satuan']);

        // Get medications that need restock (stock less than minimum required)
        $lowStockMeds = Obat::whereRaw('stok < StokMinimum')
            ->orderBy('stok', 'asc')
            ->get(['id_obat', 'NamaObat', 'stok', 'StokMinimum', 'Satuan']);

        // Tambahan statistik kunjungan
        // Total pasien
        $totalPasien = Pasien::count();

        // Pasien baru bulan ini
        $pasienBaruBulanIni = Pasien::where('created_at', '>=', $startOfMonth)->count();

        // Kunjungan hari ini per poli
        $kunjunganHarian = DB::table('kunjungan')
            ->select('Poli', DB::raw('COUNT(*) as total'))
            ->whereDate('TanggalKunjungan', $today->toDateString())
            ->groupBy('Poli')
            ->get();

        // Kunjungan bulan ini per poli
        $kunjunganBulanan = DB::table('kunjungan')
            ->select('Poli', DB::raw('COUNT(*) as total'))
            ->whereBetween('TanggalKunjungan', [$startOfMonth, $today])
            ->groupBy('Poli')
            ->get();

        // Status kunjungan hari ini
        $statusKunjungan = DB::table('kunjungan')
            ->select('Status', DB::raw('COUNT(*) as total'))
            ->whereDate('TanggalKunjungan', $today->toDateString())
            ->groupBy('Status')
            ->get();

        // Data untuk grafik kunjungan 7 hari terakhir
        $week = [];
        $kunjunganMingguanData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $week[] = $date->format('d M');

            $count = DB::table('kunjungan')
                ->whereDate('TanggalKunjungan', $date->toDateString())
                ->count();

            $kunjunganMingguanData[] = $count;
        }

        // Data grafik untuk JavaScript
        $kunjunganMingguan = [
            'labels' => $week,
            'data' => $kunjunganMingguanData
        ];

        return view('dashboard', compact(
            'totalPembelian',
            'totalPenjualan',
            'totalRevenue',
            'totalBarangKeluar',
            'totalKadaluarsa',
            'expiringMeds',
            'lowStockMeds',
            'totalPasien',
            'pasienBaruBulanIni',
            'kunjunganHarian',
            'kunjunganBulanan',
            'statusKunjungan',
            'kunjunganMingguan'
        ));
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
