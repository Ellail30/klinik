<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Pasien;
use Illuminate\Http\Request;

// class PasienController extends Controller
// {
//     public function index(Request $request)
//     {
//         // Ambil keyword pencarian jika ada
//         $search = $request->input('search');

//         // Query data Pasien dengan pencarian dan pagination
//         $pasien = Pasien::when($search, function ($query, $search) {
//             return $query->where('NamaPasien', 'like', '%' . $search . '%')
//                          ->orWhere('Alamat', 'like', '%' . $search . '%');
//         })->paginate(5); // 5 data per halaman

//         // Kirim data ke view
//         return view('pasien', compact('pasien'));
//     }


//     public function destroy($id)
//     {
//         $pasien = Pasien::findOrFail($id);
//         $pasien->delete();
//         return redirect('/pasien')->with('success', 'Pasien berhasil dihapus');
//     }

//     public function store(Request $request)
//     {
//         $validatedData = $request->validate([
//             'Nik' => 'required|unique:pasien|max:255',
//             'Nrm' => 'required|max:255',
//             'NamaPasien' => 'required|max:20',
//             'Umur' => 'required|max:20',
//             'Alamat' => 'required|max:255',
//         ]);

//         Pasien::create($validatedData);
//         return redirect('/pasien')->with('success', 'Pasien berhasil ditambahkan');
//     }

//     public function edit($id)
//     {
//         $pasien = Pasien::findOrFail($id);
//         return view('pasien.edit', compact('pasien'));
//     }

//     public function update(Request $request, $id)
//     {
//         $validatedData = $request->validate([
//             'Nik' => 'required|unique:pasien|max:255',
//             'Nrm' => 'required|max:255',
//             'NamaPasien' => 'required|max:20',
//             'Umur' => 'required|max:20',
//             'Alamat' => 'required|max:255',
//         ]);

//         $pasien = Pasien::findOrFail($id);
//         $pasien->update($validatedData);

//         return redirect('/pasien')->with('success', 'Pasien berhasil diperbarui.');
//     }
// }


class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $pasiens = Pasien::where('Nik', 'like', "%$query%")
            ->orWhere('NamaPasien', 'like', "%$query%")
            ->orWhere('Nrm', 'like', "%$query%")
            ->get();

        return view('pasien.index', compact('pasiens', 'query'));
    }
    

    public function cariPasien(Request $request)
    {
        $query = $request->input('query');

        $pasiens = Pasien::where('Nik', 'like', "%$query%")
            ->orWhere('NamaPasien', 'like', "%$query%")
            ->orWhere('Nrm', 'like', "%$query%")
            ->get();

        return view('pasien.index', compact('pasiens', 'query'));
    }

    public function show($nrm)
    {
        // Ambil data pasien dengan relasi kunjungan
        $pasien = Pasien::with(['kunjungan' => function ($query) {
            $query->orderByDesc('TanggalKunjungan');
        }])->findOrFail($nrm);

        // Kelompokkan kunjungan berdasarkan tahun
        $kunjunganByYear = $pasien->kunjungan->groupBy(function ($item) {
            return Carbon::parse($item->TanggalKunjungan)->year;
        });

        // Statistik kunjungan
        $statistikKunjungan = [
            'total' => $pasien->kunjungan->count(),
            'perPoli' => $pasien->kunjungan->groupBy('Poli')->map->count(),
            'terakhirKunjungan' => $pasien->kunjungan->first()
        ];

        return view('pasien.show', [
            'pasien' => $pasien,
            'kunjunganByYear' => $kunjunganByYear,
            'statistikKunjungan' => $statistikKunjungan
        ]);
    }

    public function riwayatKunjungan($nrm)
    {
        $pasien = Pasien::findOrFail($nrm);
        $kunjungan = $pasien->kunjungan()->orderByDesc('TanggalKunjungan')->paginate(10);

        return view('pasien.riwayat-kunjungan', [
            'pasien' => $pasien,
            'kunjungan' => $kunjungan
        ]);
    }

    public function edit($nrm)
    {
        $pasien = Pasien::findOrFail($nrm);
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $nrm)
    {
        $pasien = Pasien::findOrFail($nrm);

        $validatedData = $request->validate([
            'Nik' => 'required|digits:16|unique:pasien,Nik,' . $nrm . ',Nrm',
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

        $pasien->update($validatedData);

        return redirect()->route('pasien.show', $nrm)
            ->with('success', 'Data pasien berhasil diperbarui');
    }
}