<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\DetailResep;
use App\Models\Pembayaran;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApotekerController extends Controller
{
    public function index(Request $request)
    {
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

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pasien.NamaPasien', 'like', "%$search%")
                    ->orWhere('pasien.Nrm', 'like', "%$search%")
                    ->orWhere('resep.IdResep', 'like', "%$search%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('resep.Status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('resep.TanggalResep', $request->tanggal);
        }

        $reseps = $query->orderBy('resep.TanggalResep', 'desc')->get();

        // Hitung total keseluruhan
        $grandTotal = $reseps->sum('TotalBayar');

        return view('apoteker.index', compact('reseps', 'grandTotal'));
    }

    public function detailResep($id)
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

        return view('apoteker.detail-resep', compact('resep', 'totalHarga'));
    }

    public function simpanPembayaran(Request $request, $id)
    {
        $request->validate([
            'total_bayar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $resep = Resep::findOrFail($id);

            // Simpan data pembayaran
            $pembayaran = new Pembayaran();
            $pembayaran->IdResep = $id;
            $pembayaran->TanggalPembayaran = now();
            $pembayaran->TotalBayar = $request->total_bayar;
            $pembayaran->IdApoteker = Auth::id();
            $pembayaran->Keterangan = $request->keterangan;
            $pembayaran->save();

            // Update status resep
            $resep->Status = 'Sudah Diambil';
            $resep->save();

            DB::commit();

            return redirect()->route('apoteker.cetakBukti', $pembayaran->IdPembayaran)->with('success', 'Pembayaran berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cetakBukti($id)
    {
        $pembayaran = Pembayaran::with([
            'resep.pemeriksaan.kunjungan.pasien',
            'resep.detailResep.obat',
            'apoteker'
        ])->where('IdPembayaran', $id)->first();

        if (!$pembayaran) {
            return redirect()->route('apoteker.index')->with('error', 'Data pembayaran tidak ditemukan');
        }

        return view('apoteker.cetak-bukti', compact('pembayaran'));
    }

    public function riwayatPembayaran(Request $request)
    {
        $query = Pembayaran::join('resep', 'pembayaran.IdResep', '=', 'resep.IdResep')
            ->join('pemeriksaan', 'resep.IdPemeriksaan', '=', 'pemeriksaan.IdPemeriksaan')
            ->join('kunjungan', 'pemeriksaan.IdKunjungan', '=', 'kunjungan.IdKunjungan')
            ->join('pasien', 'kunjungan.Nrm', '=', 'pasien.Nrm')
            ->join('users', 'pembayaran.IdApoteker', '=', 'users.id')
            ->select('pembayaran.*', 'pasien.NamaPasien', 'pasien.Nrm', 'users.Nama as NamaApoteker', 'resep.IdResep');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pasien.NamaPasien', 'like', "%$search%")
                    ->orWhere('pasien.Nrm', 'like', "%$search%")
                    ->orWhere('resep.IdResep', 'like', "%$search%");
            });
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('pembayaran.TanggalPembayaran', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_akhir') && $request->tanggal_akhir != '') {
            $query->whereDate('pembayaran.TanggalPembayaran', '<=', $request->tanggal_akhir);
        }

        $pembayarans = $query->orderBy('pembayaran.TanggalPembayaran', 'desc')->get();

        return view('apoteker.riwayat-pembayaran', compact('pembayarans'));
    }
}
