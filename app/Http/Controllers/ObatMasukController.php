<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;


use Illuminate\Http\Request;

class ObatMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Menggunakan method input()
        $obatmasuk = ObatMasuk::when($search, function ($query, $search) {
            return $query->where('Satuan', 'like', '%' . $search . '%');
        })->paginate(5);

        // Kirim data ObatMasuk ke view
        return view('obatmasuk', compact('obatmasuk'));
    }

    public function destroy($id)
    {
        // Temukan ObatMasuk berdasarkan ID
        $obatmasuk = ObatMasuk::findOrFail($id);

        // Hapus ObatMasuk dari database
        $obatmasuk->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/obatmasuk')->with('success', 'Data berhasil dihapus');
    }

    // Method untuk menambah data ObatMasuk
    public function store(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'NoDetBeli' => 'required|unique:det_transaksi_pembelian|max:255',
            'NoFaktur' => 'required|max:255',
            'qty' => 'required|max:255',
            'BesarPotongan' => 'required|max:255',
            'PotCash' => 'required|max:255',
            'HargaBeli' => 'required|max:255',
            'id_obat' => 'required|max:255',
        ]);
        ObatMasuk::create($validatedData);

        // Simpan data ObatMasuk ke dalam database
        ObatMasuk::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect('/obatmasuk')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Ambil data ObatMasuk berdasarkan ID
        $obatmasuk = ObatMasuk::findOrFail($id);

        // Kirim data ke view modal
        return view('obatmasuk.edit', compact('obatmasuk'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'NoDetBeli' => 'required|unique:det_transaksi_pembelian|max:255',
            'NoFaktur' => 'required|max:255',
            'qty' => 'required|max:255',
            'BesarPotongan' => 'required|max:255',
            'PotCash' => 'required|max:255',
            'HargaBeli' => 'required|max:255',
            'id_obat' => 'required|max:255',
        ]);

        // Cari data ObatMasuk berdasarkan ID
        $obatmasuk = ObatMasuk::findOrFail($id);

        // Update data ObatMasuk
        $obatmasuk->update($validatedData);

        // Redirect atau tampilkan pesan sukses
        return redirect('/obatmasuk')->with('success', 'Data ObatMasuk berhasil diperbarui.');
    }
}
