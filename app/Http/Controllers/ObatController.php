<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data obat dengan pagination 5 data per halaman
        $obat = Obat::paginate(5);

        // Kirim data obat ke view
        return view('obat', compact('obat'));
    }
    public function destroy($id)
{
    // Temukan obat berdasarkan ID
    $obat = Obat::findOrFail($id);

    // Hapus obat dari database
    $obat->delete();

    // Redirect kembali dengan pesan sukses
    return redirect('/obat')->with('success', 'Obat berhasil dihapus');
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

     // Kirim data ke view modal
     return view('obat.edit', compact('obat'));
 }
 public function update(Request $request, $id)
 {
     // Validasi data
     $request->validate([
         'id_obat' => 'required',
         'NamaObat' => 'required',
         'Satuan' => 'required',
         'stok' => 'required|integer',
         'TglEXP' => 'required|date',
         'NoBatch' => 'required',
         'HargaBeli' => 'required|numeric',
     ]);

     // Cari data obat berdasarkan ID
     $obat = Obat::findOrFail($id);

     // Update data obat
     $obat->update([
         'id_obat' => $request->id_obat,
         'NamaObat' => $request->NamaObat,
         'Satuan' => $request->Satuan,
         'stok' => $request->stok,
         'TglEXP' => $request->TglEXP,
         'NoBatch' => $request->NoBatch,
         'HargaBeli' => $request->HargaBeli,
     ]);

     // Redirect atau tampilkan pesan sukses
     return redirect('/obat')->with('success', 'Data obat berhasil diperbarui.');
 }

}
