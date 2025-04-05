<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
public function index(Request $request)
{
    $search = $request->input('search'); // Ambil input 'search'
    $sortBy = $request->input('sort_by'); // Ambil input 'sort_by'

    $obat = Obat::query();

    // If search term is provided
    if ($search) {
        $searchTerms = explode(' ', $search); // Split the search input by space to handle multiple words

        foreach ($searchTerms as $term) {
            // Apply the search condition for each term (word)
            $obat = $obat->where(function ($query) use ($term) {
                $query->where('NamaObat', 'like', '%' . $term . '%')
                      ->orWhere('id_obat', 'like', '%' . $term . '%')
                      ->orWhere('NoBatch', 'like', '%' . $term . '%');
            });
        }
    }

    // Sorting berdasarkan kolom yang dipilih
    if ($sortBy) {
        switch ($sortBy) {
            case 'NamaObat_asc':
                $obat = $obat->orderBy('NamaObat', 'asc'); // Urutkan Nama Obat A-Z
                break;
            case 'NamaObat_desc':
                $obat = $obat->orderBy('NamaObat', 'desc'); // Urutkan Nama Obat Z-A
                break;
            case 'TglExp_asc':
                // Urutkan berdasarkan tanggal kedaluwarsa terdekat ke sekarang
                $obat = $obat->orderByRaw('ABS(DATEDIFF(TglExp, CURDATE())) asc');
                break;
            case 'HargaBeli_asc':
                $obat = $obat->orderBy('HargaBeli', 'asc'); // Urutkan berdasarkan Harga Termurah
                break;
            case 'HargaBeli_desc':
                $obat = $obat->orderBy('HargaBeli', 'desc'); // Urutkan berdasarkan Harga Termahal
                break;
            case 'HargaJual_asc':
                    $obat = $obat->orderBy('HargaJual', 'asc'); // Urutkan berdasarkan Harga Termurah
                    break;
            case 'HargaJual_desc':
                    $obat = $obat->orderBy('HargaJual', 'desc'); // Urutkan berdasarkan Harga Termahal
                    break;
            case 'Satuan':
                $obat = $obat->orderBy('Satuan', 'asc'); // Urutkan berdasarkan Satuan
                break;
        }
    }

    // Paginate hasil query
    $obat = $obat->paginate(5);

    return view('obat', compact('obat', 'search', 'sortBy'));
}


    public function destroy($id)
    {
        // Ambil data obat berdasarkan ID
        $obat = Obat::find($id);

        if ($obat) {
            $obatName = $obat->NamaObat;
            $obat->delete();  // Hapus obat

            // Kembalikan ke halaman daftar obat dengan pesan sukses
            return redirect()->route('obat.index')->with('success', "$obatName berhasil dihapus!");
        }

    }


    // Method untuk menambah data obat
    public function store(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'id_obat' => 'required|unique:obat|max:255',
            'NamaObat' => 'required|max:255',
            'Satuan' => 'required|in:BOTOL,TUBE',
            'stok' => 'required|integer|min:1',
            'TglEXP' => 'required|date',
            'NoBatch' => 'required|max:255',
            'HargaBeli' => 'required|numeric|min:0',
            'HargaJual' => 'required|numeric|min:0',

        ]);

        // Simpan data obat ke dalam database
        Obat::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect('/obat')->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Ambil data obat berdasarkan ID
        $obat = Obat::findOrFail($id);

        // Kembalikan data obat dalam format JSON
        return response()->json($obat);
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'NamaObat' => 'required|string',
            'Satuan' => 'required|string',
            'stok' => 'required|integer',
            'TglEXP' => 'required|date',
            'NoBatch' => 'required|string',
            'HargaBeli' => 'required|numeric',
            'HargaJual' => 'required|numeric',

        ]);

        // Cari obat berdasarkan ID
        $obat = Obat::find($id);
        $HargaJual = $request->HargaBeli * 1.51;

        $obat->update([
            'NamaObat' => $request->NamaObat,
            'Satuan' => $request->Satuan,
            'stok' => $request->stok,
            'TglEXP' => $request->TglEXP,
            'NoBatch' => $request->NoBatch,
            'HargaBeli' => $request->HargaBeli,
            'HargaJual' => round($HargaJual),
        ]);

        // Periksa jika obat ditemukan
        if (!$obat) {
            return response()->json(['message' => 'Obat tidak ditemukan'], 404);
        }

        // Perbarui data obat
        $obat->update($validatedData);

        // Kirim respons sukses
        return response()->json(['success' => true, 'NamaObat' => $obat->NamaObat]);
    }


}
