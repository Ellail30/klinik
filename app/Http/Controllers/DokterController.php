<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resep;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $poli = '';

        if ($user->jabatan == 'Dokter Poli Umum') {
            $poli = 'Umum';
        } elseif ($user->jabatan == 'Dokter Kandungan') {
            $poli = 'Kandungan';
        } elseif ($user->jabatan == 'Dokter Poli Gigi') {
            $poli = 'Gigi';
        }

        $query = Kunjungan::join('pasien', 'kunjungan.Nrm', '=', 'pasien.Nrm')
            ->where('kunjungan.Poli', $poli)
            ->where(function ($q) {
                $q->where('kunjungan.Status', 'Antri')
                    ->orWhere('kunjungan.Status', 'Dipanggil');
            })
            ->select('kunjungan.*', 'pasien.NamaPasien', 'pasien.JenisKelamin', 'pasien.TanggalLahir');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pasien.NamaPasien', 'like', "%$search%")
                    ->orWhere('kunjungan.Nrm', 'like', "%$search%")
                    ->orWhere('kunjungan.NomorAntrian', 'like', "%$search%");
            });
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('kunjungan.TanggalKunjungan', $request->tanggal);
        } else {
            $query->whereDate('kunjungan.TanggalKunjungan', date('Y-m-d'));
        }

        $antrians = $query->orderBy('kunjungan.NomorAntrian', 'asc')->get();

        return view('dokter.index', compact('antrians', 'poli'));
    }

    public function panggilPasien($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->Status = 'Dipanggil';
        $kunjungan->save();

        return redirect()->route('dokter.index')->with('success', 'Pasien berhasil dipanggil');
    }

    public function formPemeriksaan($id)
    {
        $kunjungan = Kunjungan::join('pasien', 'kunjungan.Nrm', '=', 'pasien.Nrm')
            ->where('kunjungan.IdKunjungan', $id)
            ->select('kunjungan.*', 'pasien.NamaPasien', 'pasien.JenisKelamin', 'pasien.TanggalLahir', 'pasien.Alamat')
            ->first();

        if (!$kunjungan) {
            return redirect()->route('dokter.index')->with('error', 'Data kunjungan tidak ditemukan');
        }

        // Update status menjadi diperiksa
        $kunjungan->Status = 'Diperiksa';
        $kunjungan->save();

        return view('dokter.pemeriksaan', compact('kunjungan'));
    }

    public function simpanPemeriksaan(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required',
            'tindakan' => 'nullable',
        ]);

        DB::beginTransaction();

        try {
            $kunjungan = Kunjungan::findOrFail($id);

            // Simpan data pemeriksaan
            $pemeriksaan = new Pemeriksaan();
            $pemeriksaan->IdKunjungan = $id;
            $pemeriksaan->IdDokter = Auth::id();
            $pemeriksaan->TanggalPemeriksaan = now();
            $pemeriksaan->Diagnosa = $request->diagnosa;
            $pemeriksaan->Tindakan = $request->tindakan;
            $pemeriksaan->Status = 'Belum Selesai';
            $pemeriksaan->save();

            // Update status kunjungan
            $kunjungan->Status = 'Selesai';
            $kunjungan->save();

            DB::commit();

            return redirect()->route('dokter.resep', $pemeriksaan->IdPemeriksaan)->with('success', 'Data pemeriksaan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Tambahkan method berikut ke DokterController

    public function formResep($id)
    {
        $pemeriksaan = Pemeriksaan::with(['kunjungan.pasien'])
            ->where('IdPemeriksaan', $id)
            ->first();

        if (!$pemeriksaan) {
            return redirect()->route('dokter.index')->with('error', 'Data pemeriksaan tidak ditemukan');
        }

        // Ambil data obat untuk dropdown
        $obats = DB::table('obat')
            ->where('stok', '>', 0)
            ->orderBy('NamaObat')
            ->get();

        return view('dokter.resep', compact('pemeriksaan', 'obats'));
    }

    public function simpanResep(Request $request, $id)
    {
        $request->validate([
            'obat' => 'required|array|min:1',
            'obat.*' => 'required|exists:obat,id_obat',
            'dosis' => 'required|array|min:1',
            'dosis.*' => 'required|string',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'catatan' => 'nullable|array',
            'catatan.*' => 'nullable|string',
            'waktu_konsumsi' => 'nullable|array',
            'waktu_konsumsi.*' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $pemeriksaan = Pemeriksaan::findOrFail($id);

            // Generate ID Resep (format: RSP-tanggal-increment)
            $tanggal = date('Ymd');
            $lastResep = DB::table('resep')
                ->where('IdResep', 'like', "RSP-$tanggal%")
                ->orderBy('IdResep', 'desc')
                ->first();

            if ($lastResep) {
                $lastIncrement = (int) substr($lastResep->IdResep, -3);
                $newIncrement = $lastIncrement + 1;
            } else {
                $newIncrement = 1;
            }

            $idResep = "RSP-$tanggal-" . str_pad($newIncrement, 3, '0', STR_PAD_LEFT);

            // Simpan header resep
            $resep = new Resep();
            $resep->IdResep = $idResep;
            $resep->IdPemeriksaan = $id;
            $resep->TanggalResep = now();
            $resep->Status = 'Belum Diambil';
            $resep->save();

            // Simpan detail resep
            $totalItems = count($request->obat);
            for ($i = 0; $i < $totalItems; $i++) {
                $obat = \App\Models\Obat::where('id_obat', $request->obat[$i])->first();

                $detail = new \App\Models\DetailResep();
                $detail->IdResep = $idResep;
                $detail->IdObat = $request->obat[$i];
                $detail->Dosis = $request->dosis[$i];
                $detail->Jumlah = $request->jumlah[$i];
                $detail->WaktuKonsumsi = $request->waktu_konsumsi[$i];
                $detail->Catatan = $request->catatan[$i] ?? null;
                $detail->HargaSatuan = $obat ? $obat->HargaJual : 0; // Ambil HargaJual dari tabel obat
                $detail->save();

                // Kurangi stok obat jika ditemukan
                if ($obat) {
                    $obat->stok -= $request->jumlah[$i];
                    $obat->save();
                }
            }

            // Update status pemeriksaan menjadi selesai
            $pemeriksaan->Status = 'Selesai';
            $pemeriksaan->save();

            DB::commit();

            return redirect()->route('dokter.cetakResep', $idResep)->with('success', 'Resep berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cetakResep($id)
    {
        $resep = Resep::with([
            'pemeriksaan.kunjungan.pasien',
            'pemeriksaan.dokter',
            'detailResep.obat'
        ])->where('IdResep', $id)->first();

        if (!$resep) {
            return redirect()->route('dokter.index')->with('error', 'Data resep tidak ditemukan');
        }

        return view('dokter.cetak-resep', compact('resep'));
    }
}
