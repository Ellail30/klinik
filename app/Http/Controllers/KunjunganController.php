<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function show($idKunjungan)
    {
        $kunjungan = Kunjungan::with('pasien')->findOrFail($idKunjungan);

        return response()->json($kunjungan);
    }

    public function statistikKunjungan(Request $request)
    {
        // Statistik harian
        $harian = Kunjungan::whereDate('TanggalKunjungan', today())
            ->groupBy('Poli')
            ->selectRaw('Poli, COUNT(*) as total')
            ->get();

        // Statistik bulanan
        $bulanan = Kunjungan::whereYear('TanggalKunjungan', now()->year)
            ->whereMonth('TanggalKunjungan', now()->month)
            ->groupBy('Poli')
            ->selectRaw('Poli, COUNT(*) as total')
            ->get();

        // Status kunjungan
        $status = Kunjungan::whereDate('TanggalKunjungan', today())
            ->groupBy('Status')
            ->selectRaw('Status, COUNT(*) as total')
            ->get();

        return response()->json([
            'harian' => $harian,
            'bulanan' => $bulanan,
            'status' => $status
        ]);
    }
}
