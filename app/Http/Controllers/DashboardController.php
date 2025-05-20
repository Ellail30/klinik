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
        $lowStockMeds = Obat::whereRaw('stok < StokMinumum')
            ->orderBy('stok', 'asc')
            ->get(['id_obat', 'NamaObat', 'stok', 'StokMinumum', 'Satuan']);

        return view('dashboard', compact(
            'totalPembelian',
            'totalPenjualan',
            'totalRevenue',
            'totalBarangKeluar',
            'totalKadaluarsa',
            'expiringMeds',
            'lowStockMeds'
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
