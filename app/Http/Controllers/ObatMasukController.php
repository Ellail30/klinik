<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ObatMasukController extends Controller
{
    public function index(Request $request)
    {
        // Generate the new NoDetBeli automatically
        $newNoDetBeli = $this->generateNoDetBeli();

        $search = $request->input('search'); // Menggunakan method input()
        $obatmasuk = ObatMasuk::when($search, function ($query, $search) {
            return $query->where('Satuan', 'like', '%' . $search . '%');
        })->paginate(5);

        // Kirim data ObatMasuk ke view termasuk newNoDetBeli
        return view('obatmasuk', compact('obatmasuk', 'newNoDetBeli'));
    }

    private function generateNoDetBeli()
    {
        // Get current date in format YYYYMMDD
        $today = Carbon::now()->format('Ymd');
        $prefix = 'PB-' . $today . '-';

        // Find the last record with today's date prefix
        $lastRecord = ObatMasuk::where('NoDetBeli', 'like', $prefix . '%')
                              ->orderBy('NoDetBeli', 'desc')
                              ->first();

        if (!$lastRecord) {
            // If no records exist for today, start with 001
            return $prefix . '001';
        }

        // Extract the numeric part (last 3 digits)
        $lastNumber = (int) substr($lastRecord->NoDetBeli, -3);

        // Increment and pad with zeros
        $newNumber = $lastNumber + 1;
        $newNoDetBeli = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        return $newNoDetBeli;
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
            'NoDetBeli' => 'required|unique:det_transaksi_pembelian,NoDetBeli,'.$id.',NoDetBeli|max:255',
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
