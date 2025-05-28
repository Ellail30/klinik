<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersediaanController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('obat');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_obat', 'LIKE', "%{$search}%")
                    ->orWhere('NamaObat', 'LIKE', "%{$search}%")
                    ->orWhere('NoBatch', 'LIKE', "%{$search}%");
            });
        }

        // Satuan filter
        if ($request->has('satuan') && !empty($request->satuan)) {
            $query->where('Satuan', $request->satuan);
        }

        // Kondisi stok filter
        if ($request->has('kondisi_stok') && !empty($request->kondisi_stok)) {
            if ($request->kondisi_stok == 'harus_restock') {
                $query->whereRaw('stok < StokMinimum');
            } elseif ($request->kondisi_stok == 'stok_aman') {
                $query->whereRaw('stok >= StokMinimum');
            }
        }

        // Kondisi expired filter
        if ($request->has('kondisi_expired') && !empty($request->kondisi_expired)) {
            $today = Carbon::today();
            $threeMonthsFromNow = $today->copy()->addMonths(3);

            if ($request->kondisi_expired == 'expired') {
                $query->where('TglExp', '<=', $today);
            } elseif ($request->kondisi_expired == 'akan_expired') {
                $query->whereBetween('TglExp', [$today, $threeMonthsFromNow]);
            } elseif ($request->kondisi_expired == 'aman') {
                $query->where('TglExp', '>', $threeMonthsFromNow);
            }
        }

        // Date range filter
        if ($request->has('tanggal_dari') && !empty($request->tanggal_dari)) {
            $query->where('TglExp', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && !empty($request->tanggal_sampai)) {
            $query->where('TglExp', '<=', $request->tanggal_sampai);
        }

        $obats = $query->orderBy('NamaObat', 'asc')->get();

        // Add kondisi attributes to each obat
        $obats = $obats->map(function ($obat) {
            $obat->kondisi_stok = $this->getKondisiStok($obat);
            $obat->kondisi_expired = $this->getKondisiExpired($obat);
            return $obat;
        });

        // Calculate totals
        $totalStok = $obats->sum('stok');
        $totalNilaiStok = $obats->sum(function ($obat) {
            return $obat->stok * $obat->HargaBeli;
        });

        return view('persediaan.index', compact('obats', 'totalStok', 'totalNilaiStok'));
    }

    public function exportPdf(Request $request)
    {
        $query = DB::table('obat');

        // Apply same filters as index
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_obat', 'LIKE', "%{$search}%")
                    ->orWhere('NamaObat', 'LIKE', "%{$search}%")
                    ->orWhere('NoBatch', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('satuan') && !empty($request->satuan)) {
            $query->where('Satuan', $request->satuan);
        }

        if ($request->has('kondisi_stok') && !empty($request->kondisi_stok)) {
            if ($request->kondisi_stok == 'harus_restock') {
                $query->whereRaw('stok < StokMinimum');
            } elseif ($request->kondisi_stok == 'stok_aman') {
                $query->whereRaw('stok >= StokMinimum');
            }
        }

        if ($request->has('kondisi_expired') && !empty($request->kondisi_expired)) {
            $today = Carbon::today();
            $threeMonthsFromNow = $today->copy()->addMonths(3);

            if ($request->kondisi_expired == 'expired') {
                $query->where('TglExp', '<=', $today);
            } elseif ($request->kondisi_expired == 'akan_expired') {
                $query->whereBetween('TglExp', [$today, $threeMonthsFromNow]);
            } elseif ($request->kondisi_expired == 'aman') {
                $query->where('TglExp', '>', $threeMonthsFromNow);
            }
        }

        if ($request->has('tanggal_dari') && !empty($request->tanggal_dari)) {
            $query->where('TglExp', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && !empty($request->tanggal_sampai)) {
            $query->where('TglExp', '<=', $request->tanggal_sampai);
        }

        $obats = $query->orderBy('NamaObat', 'asc')->get();

        // Add kondisi attributes
        $obats = $obats->map(function ($obat) {
            $obat->kondisi_stok = $this->getKondisiStok($obat);
            $obat->kondisi_expired = $this->getKondisiExpired($obat);
            return $obat;
        });

        $totalStok = $obats->sum('stok');
        $totalNilaiStok = $obats->sum(function ($obat) {
            return $obat->stok * $obat->HargaBeli;
        });

        $pdf = PDF::loadView('persediaan.pdf', compact('obats', 'totalStok', 'totalNilaiStok'));

        return $pdf->stream('daftar-obat-' . date('Y-m-d') . '.pdf');
    }

    private function getKondisiStok($obat)
    {
        if ($obat->stok < $obat->StokMinimum) {
            return 'Harus Restock';
        } else {
            return 'Stok Aman';
        }
    }

    private function getKondisiExpired($obat)
    {
        $today = Carbon::today();
        $expDate = Carbon::parse($obat->TglExp);
        $threeMonthsFromNow = $today->copy()->addMonths(3);

        if ($expDate <= $today) {
            return 'Expired';
        } elseif ($expDate <= $threeMonthsFromNow) {
            return 'Akan Expired';
        } else {
            return 'Aman';
        }
    }
}
