<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d'); // Mendapatkan tanggal hari ini
        $kunjunganHariIni = Kunjungan::whereDate('TanggalKunjungan', $today)->get();
        return view('pendaftaran.index', compact( 'kunjunganHariIni'));
    }

    public function cariPasien(Request $request)
    {
        $query = $request->input('query');

        $kunjunganHariIni = Kunjungan::with('pasien')
            ->whereHas('pasien', function ($queryBuilder) use ($query) {
                $queryBuilder->where('Nik', 'like', "%$query%")
                    ->orWhere('NamaPasien', 'like', "%$query%")
                    ->orWhere('Nrm', 'like', "%$query%");
            })
            ->get();

        return view('pendaftaran.index', compact( 'query', 'kunjunganHariIni'));
    }

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        // Validasi data pasien
        $validatedPasienData = $request->validate([
            'Nik' => 'required|unique:pasien|max:16',
            'NamaPasien' => 'required|max:25',
            'TempatLahir' => 'nullable|max:30',
            'TanggalLahir' => 'nullable|date',
            'JenisKelamin' => 'required|in:Laki-laki,Perempuan',
            'Alamat' => 'nullable|max:100',
            'NoTelp' => 'nullable|max:15',
            'Email' => 'nullable|email|max:100',
            'GolonganDarah' => 'nullable|in:A,B,AB,O',
            'StatusPernikahan' => 'nullable|in:Belum Menikah,Menikah,Cerai',
            'Agama' => 'nullable|in:Islam,Kristen,Katholik,Budha,Hindu,Konghuchu'
        ]);


        // Generate NRM
        $nrm = Pasien::generateNrm();

        // Simpan data pasien
        $pasien = Pasien::create(array_merge($validatedPasienData, [
            'Nrm' => $nrm,
        ]));

        // Validasi data kunjungan
        $validatedKunjunganData = $request->validate([
            'Keluhan' => 'required',
            'Poli' => 'required|in:Kandungan,Gigi,Umum'
        ]);

        // Generate Nomor Antrian
        $nomorAntrian = Kunjungan::generateNomorAntrian($validatedKunjunganData['Poli']);

        // Simpan data kunjungan
        $kunjungan = Kunjungan::create([
            'Nrm' => $nrm,
            'TanggalKunjungan' => now(),
            'Keluhan' => $validatedKunjunganData['Keluhan'],
            'Poli' => $validatedKunjunganData['Poli'],
            'NomorAntrian' => $nomorAntrian,
            'Status' => 'Antri'
        ]);

        return redirect()->route('pendaftaran.index')
            ->with('success', "Pasien berhasil didaftarkan. Nomor Rekam Medis: $nrm, Nomor Antrian: $nomorAntrian");
    }

    public function daftarUlang(Pasien $pasien)
    {
        return view('pendaftaran.daftar-ulang', compact('pasien'));
    }

    public function simpanDaftarUlang(Request $request, Pasien $pasien)
    {
        $validatedData = $request->validate([
            'Keluhan' => 'required',
            'Poli' => 'required|in:Kandungan,Gigi,Umum'
        ]);

        // Generate Nomor Antrian
        $nomorAntrian = Kunjungan::generateNomorAntrian($validatedData['Poli']);

        // Simpan data kunjungan
        $kunjungan = Kunjungan::create([
            'Nrm' => $pasien->Nrm,
            'TanggalKunjungan' => now(),
            'Keluhan' => $validatedData['Keluhan'],
            'Poli' => $validatedData['Poli'],
            'NomorAntrian' => $nomorAntrian,
            'Status' => 'Antri'
        ]);

        return redirect()->route('pendaftaran.index')
            ->with('success', "Pasien berhasil didaftarkan. Nomor Antrian: $nomorAntrian");
    }
}
