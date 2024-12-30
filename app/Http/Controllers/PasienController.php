<?php

namespace App\Http\Controllers;

use App\Models\Pasien;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        // Ambil keyword pencarian jika ada
        $search = $request->input('search');

        // Query data Pasien dengan pencarian dan pagination
        $pasien = Pasien::when($search, function ($query, $search) {
            return $query->where('NamaPasien', 'like', '%' . $search . '%')
                         ->orWhere('Alamat', 'like', '%' . $search . '%');
        })->paginate(5); // 5 data per halaman

        // Kirim data ke view
        return view('pasien', compact('pasien'));
    }


    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();
        return redirect('/pasien')->with('success', 'Pasien berhasil dihapus');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Nik' => 'required|unique:pasien|max:255',
            'Nrm' => 'required|max:255',
            'NamaPasien' => 'required|max:20',
            'Umur' => 'required|max:20',
            'Alamat' => 'required|max:255',
        ]);

        Pasien::create($validatedData);
        return redirect('/pasien')->with('success', 'Pasien berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Nik' => 'required|unique:pasien|max:255',
            'Nrm' => 'required|max:255',
            'NamaPasien' => 'required|max:20',
            'Umur' => 'required|max:20',
            'Alamat' => 'required|max:255',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($validatedData);

        return redirect('/pasien')->with('success', 'Pasien berhasil diperbarui.');
    }
}
