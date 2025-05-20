<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Resep;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TransaksiPembelian;
use Illuminate\Support\Facades\DB;
use App\Models\DetTransaksiPembelian;

class LaporanController extends Controller
{
    public function exportPdfObatMasuk(Request $request)
    {
        $query = TransaksiPembelian::with(['sales', 'apoteker', 'detailTransaksi', 'detailTransaksi.obat']);

        // Apply the same filters as in index method
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('NoFaktur', 'like', "%{$search}%");
        }

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('TglFaktur', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('TglFaktur', '<=', $request->end_date);
        }

        if ($request->has('sales_id') && $request->sales_id != '') {
            $query->where('id_sales', $request->sales_id);
        }

        if ($request->has('apoteker_id') && $request->apoteker_id != '') {
            $query->where('id_Apoteker', $request->apoteker_id);
        }

        $transaksi = $query->get();

        // Calculate total price for displayed items
        $totalHarga = 0;
        foreach ($transaksi as $item) {
            foreach ($item->detailTransaksi as $detail) {
                $totalHarga += $detail->HargaBeli * $detail->qty;
            }
        }

        $pdf = PDF::loadView('obat-masuk.pdf.index', compact('transaksi', 'totalHarga'));
        return $pdf->stream('laporan-obat-masuk.pdf');
    }

    public function exportPdfDetailObatMasuk($noFaktur)
    {
        $noFaktur = urldecode($noFaktur);
        // Get transaction with relationships
        $transaksi = TransaksiPembelian::with(['sales', 'apoteker'])
            ->where('NoFaktur', $noFaktur)
            ->firstOrFail();

        // Get transaction details with obat relationship
        $details = DetTransaksiPembelian::join('obat', 'det_transaksi_pembelian.id_obat', '=', 'obat.id_obat')
            ->where('NoFaktur', $noFaktur)
            ->select(
                'det_transaksi_pembelian.*',
                'obat.NamaObat',
                DB::raw('(det_transaksi_pembelian.HargaBeli * det_transaksi_pembelian.qty) - det_transaksi_pembelian.BesarPotongan - det_transaksi_pembelian.PotCash as subtotal')
            )
            ->get();

        // Calculate total
        $total = $details->sum('subtotal');

        // Load the PDF view
        $pdf = PDF::loadView('obat-masuk.pdf.show', compact('transaksi', 'details', 'total'));

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Download the PDF
        $cleanFaktur = str_replace(['/', '\\'], '-', $noFaktur); // Ganti / dan \ dengan strip
        return $pdf->stream('detail-obat-masuk-' . $cleanFaktur . '.pdf');
    }

    public function exportPdfObatKeluar(Request $request)
    {
        // Reuse the same query logic from index method
        $query = Resep::join('pemeriksaan', 'resep.IdPemeriksaan', '=', 'pemeriksaan.IdPemeriksaan')
            ->join('kunjungan', 'pemeriksaan.IdKunjungan', '=', 'kunjungan.IdKunjungan')
            ->join('pasien', 'kunjungan.Nrm', '=', 'pasien.Nrm')
            ->leftJoin(
                DB::raw('(SELECT IdResep, SUM(HargaSatuan * Jumlah) as TotalBayar FROM detail_resep GROUP BY IdResep) as dr'),
                'resep.IdResep',
                '=',
                'dr.IdResep'
            )
            ->select('resep.*', 'pasien.NamaPasien', 'pasien.Nrm', DB::raw('COALESCE(dr.TotalBayar, 0) as TotalBayar'));

        // Apply the same filters
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pasien.NamaPasien', 'like', "%$search%")
                    ->orWhere('pasien.Nrm', 'like', "%$search%")
                    ->orWhere('resep.IdResep', 'like', "%$search%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('resep.Status', $request->status);
        }

        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('resep.TanggalResep', $request->tanggal);
        }

        $reseps = $query->orderBy('resep.TanggalResep', 'desc')->get();
        $grandTotal = $reseps->sum('TotalBayar');

        // Get current date for the report
        $currentDate = Carbon::now()->format('d M Y');

        // Generate filter description for the report
        $filterText = "Semua Resep";
        if ($request->has('search') && $request->search != '') {
            $filterText = "Pencarian: " . $request->search;
        }
        if ($request->has('status') && $request->status != '') {
            $filterText .= ($filterText != "Semua Resep" ? ", " : "") . "Status: " . $request->status;
        }
        if ($request->has('tanggal') && $request->tanggal != '') {
            $filterText .= ($filterText != "Semua Resep" ? ", " : "") . "Tanggal: " . Carbon::parse($request->tanggal)->format('d M Y');
        }

        $pdf = PDF::loadView('apoteker.pdf.index', compact('reseps', 'grandTotal', 'currentDate', 'filterText'));

        return $pdf->stream('laporan-resep-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    public function exportPdfDetailObatKeluar($id)
    {
        $resep = Resep::with([
            'pemeriksaan.kunjungan.pasien',
            'pemeriksaan.dokter',
            'detailResep.obat'
        ])->where('IdResep', $id)->first();

        if (!$resep) {
            return redirect()->route('apoteker.index')->with('error', 'Data resep tidak ditemukan');
        }

        // Hitung total harga berdasarkan HargaSatuan di tabel detail_resep
        $totalHarga = 0;
        foreach ($resep->detailResep as $detail) {
            $totalHarga += $detail->HargaSatuan * $detail->Jumlah;
        }

        $currentDate = Carbon::now()->format('d M Y');

        $pdf = PDF::loadView('apoteker.pdf.detail', compact('resep', 'totalHarga', 'currentDate'));

        return $pdf->stream('detail-resep-' . $resep->IdResep . '.pdf');
    }
}
