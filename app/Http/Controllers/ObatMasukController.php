<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Sales;
use App\Models\ObatMasuk;
use Illuminate\Http\Request;
use App\Models\TransaksiPembelian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DetTransaksiPembelian;

// class ObatMasukController extends Controller
// {
//     public function index(Request $request)
//     {
//         // Generate the new NoDetBeli automatically
//         $newNoDetBeli = $this->generateNoDetBeli();

//         $search = $request->input('search'); // Menggunakan method input()
//         $obatmasuk = ObatMasuk::when($search, function ($query, $search) {
//             return $query->where('Satuan', 'like', '%' . $search . '%');
//         })->paginate(5);

//         // Kirim data ObatMasuk ke view termasuk newNoDetBeli
//         return view('obatmasuk', compact('obatmasuk', 'newNoDetBeli'));
//     }

//     private function generateNoDetBeli()
//     {
//         // Get current date in format YYYYMMDD
//         $today = Carbon::now()->format('Ymd');
//         $prefix = 'PB-' . $today . '-';

//         // Find the last record with today's date prefix
//         $lastRecord = ObatMasuk::where('NoDetBeli', 'like', $prefix . '%')
//                               ->orderBy('NoDetBeli', 'desc')
//                               ->first();

//         if (!$lastRecord) {
//             // If no records exist for today, start with 001
//             return $prefix . '001';
//         }

//         // Extract the numeric part (last 3 digits)
//         $lastNumber = (int) substr($lastRecord->NoDetBeli, -3);

//         // Increment and pad with zeros
//         $newNumber = $lastNumber + 1;
//         $newNoDetBeli = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

//         return $newNoDetBeli;
//     }

//     public function destroy($id)
//     {
//         // Temukan ObatMasuk berdasarkan ID
//         $obatmasuk = ObatMasuk::findOrFail($id);

//         // Hapus ObatMasuk dari database
//         $obatmasuk->delete();

//         // Redirect kembali dengan pesan sukses
//         return redirect('/obatmasuk')->with('success', 'Data berhasil dihapus');
//     }

//     // Method untuk menambah data ObatMasuk
//     public function store(Request $request)
//     {
//         // Validasi data input
//         $validatedData = $request->validate([
//             'NoDetBeli' => 'required|unique:det_transaksi_pembelian|max:255',
//             'NoFaktur' => 'required|max:255',
//             'qty' => 'required|max:255',
//             'BesarPotongan' => 'required|max:255',
//             'PotCash' => 'required|max:255',
//             'HargaBeli' => 'required|max:255',
//             'id_obat' => 'required|max:255',
//         ]);

//         // Simpan data ObatMasuk ke dalam database
//         ObatMasuk::create($validatedData);

//         // Redirect kembali dengan pesan sukses
//         return redirect('/obatmasuk')->with('success', 'Data berhasil ditambahkan');
//     }

//     public function edit($id)
//     {
//         // Ambil data ObatMasuk berdasarkan ID
//         $obatmasuk = ObatMasuk::findOrFail($id);

//         // Kirim data ke view modal
//         return view('obatmasuk.edit', compact('obatmasuk'));
//     }

//     public function update(Request $request, $id)
//     {
//         // Validasi data
//         $validatedData = $request->validate([
//             'NoDetBeli' => 'required|unique:det_transaksi_pembelian,NoDetBeli,'.$id.',NoDetBeli|max:255',
//             'NoFaktur' => 'required|max:255',
//             'qty' => 'required|max:255',
//             'BesarPotongan' => 'required|max:255',
//             'PotCash' => 'required|max:255',
//             'HargaBeli' => 'required|max:255',
//             'id_obat' => 'required|max:255',
//         ]);

//         // Cari data ObatMasuk berdasarkan ID
//         $obatmasuk = ObatMasuk::findOrFail($id);

//         // Update data ObatMasuk
//         $obatmasuk->update($validatedData);

//         // Redirect atau tampilkan pesan sukses
//         return redirect('/obatmasuk')->with('success', 'Data ObatMasuk berhasil diperbarui.');
//     }
// }


class ObatMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Base query for transaksi pembelian using subquery to calculate totals
        $query = DB::table(function ($subquery) {
            $subquery->from('transaksi_pembelian')
                ->leftJoin('det_transaksi_pembelian', 'transaksi_pembelian.NoFaktur', '=', 'det_transaksi_pembelian.NoFaktur')
                ->leftJoin('sales', 'transaksi_pembelian.id_sales', '=', 'sales.id_sales')
                ->leftJoin('users', 'transaksi_pembelian.id_Apoteker', '=', 'users.id')
                ->select(
                    'transaksi_pembelian.NoFaktur',
                    'transaksi_pembelian.TglFaktur',
                    'transaksi_pembelian.Waktu',
                    'transaksi_pembelian.TglJatuhTempo',
                    'sales.NamaSales',
                    'users.NamaApoteker',
                    DB::raw('COUNT(det_transaksi_pembelian.NoDetBeli) as total_item'),
                    DB::raw('SUM(det_transaksi_pembelian.qty * det_transaksi_pembelian.HargaBeli) as total_harga')
                )
                ->groupBy(
                    'transaksi_pembelian.NoFaktur',
                    'transaksi_pembelian.TglFaktur',
                    'transaksi_pembelian.Waktu',
                    'transaksi_pembelian.TglJatuhTempo',
                    'sales.NamaSales',
                    'users.NamaApoteker'
                );
        }, 'transaksi_pembelian_with_totals');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('NoFaktur', 'LIKE', "%{$search}%")
                    ->orWhere('NamaSales', 'LIKE', "%{$search}%")
                    ->orWhere('NamaApoteker', 'LIKE', "%{$search}%");
            });
        }

        // Sorting functionality
        $sortOptions = [
            'NoFaktur_asc' => ['NoFaktur', 'asc'],
            'NoFaktur_desc' => ['NoFaktur', 'desc'],
            'TglFaktur_asc' => ['TglFaktur', 'asc'],
            'TglFaktur_desc' => ['TglFaktur', 'desc'],
            'TglJatuhTempo_asc' => ['TglJatuhTempo', 'asc'],
            'TglJatuhTempo_desc' => ['TglJatuhTempo', 'desc']
        ];

        if ($request->has('sort_by') && isset($sortOptions[$request->input('sort_by')])) {
            $sortOption = $sortOptions[$request->input('sort_by')];
            $query->orderBy($sortOption[0], $sortOption[1]);
        } else {
            // Default sorting
            $query->orderBy('TglFaktur', 'desc');
        }

        // Paginate results
        $transaksi = $query->paginate(10);

        return view('obat-masuk.index', compact('transaksi'));
    }


    /**
     * Display the specified resource.
     */
    public function show($NoFaktur)
    {
        // Get main transaction details
        $transaksi = DB::table('transaksi_pembelian')
            ->leftJoin('sales', 'transaksi_pembelian.id_sales', '=', 'sales.id_sales')
            ->leftJoin('users', 'transaksi_pembelian.id_Apoteker', '=', 'users.id')
            ->where('transaksi_pembelian.NoFaktur', $NoFaktur)
            ->select(
                'transaksi_pembelian.*',
                'sales.NamaSales',
                'users.NamaApoteker'
            )
            ->first();

        // Get transaction details with obat information
        $details = DB::table('det_transaksi_pembelian')
            ->join('obat', 'det_transaksi_pembelian.id_obat', '=', 'obat.id_obat')
            ->where('det_transaksi_pembelian.NoFaktur', $NoFaktur)
            ->select(
                'det_transaksi_pembelian.*',
                'obat.NamaObat',
                DB::raw('(det_transaksi_pembelian.qty * det_transaksi_pembelian.HargaBeli) as subtotal')
            )
            ->get();

        // Calculate total
        $total = $details->sum(function ($item) {
            return $item->qty * $item->HargaBeli;
        });

        $NoFaktur = str_replace('-', '/', $NoFaktur);

        return view('obat-masuk.show', compact('transaksi', 'details', 'total'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($NoFaktur)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            // First, delete related details
            DB::table('det_transaksi_pembelian')
                ->where('NoFaktur', $NoFaktur)
                ->delete();

            // Then delete the main transaction
            DB::table('transaksi_pembelian')
                ->where('NoFaktur', $NoFaktur)
                ->delete();

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('transaksi-pembelian.index')
                ->with('success', "Transaksi Pembelian dengan No Faktur {$NoFaktur} berhasil dihapus.");
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('transaksi-pembelian.index')
                ->with('error', "Gagal menghapus Transaksi Pembelian: " . $e->getMessage());
        }
    }

    public function create()
    {
        // Get all sales
        $sales = Sales::select('id_sales', 'NamaSales')->get();

        // Get all obat
        $obat = Obat::all();

        // Generate NoFaktur
        $noFaktur = $this->generateNoFaktur();

        return view('obat-masuk.create', compact('sales', 'obat', 'noFaktur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        // $request->validate([
        //     'NoFaktur' => 'required|string|max:11|unique:transaksi_pembelian',
        //     'TglFaktur' => 'required|date',
        //     'TglJatuhTempo' => 'required|date|after_or_equal:TglFaktur',
        //     'id_sales' => 'required|exists:sales,id_sales',
        //     'items' => 'required|array|min:1',
        //     'items.*.id_obat' => 'required|exists:obat,id_obat',
        //     'items.*.qty' => 'required|integer|min:1',
        //     'items.*.BesarPotongan' => 'required|numeric|min:0',
        //     'items.*.PotCash' => 'required|numeric|min:0',
        //     'items.*.HargaBeli' => 'required|integer|min:1',
        // ]);

        // Check if items exists and is a string
        if ($request->has('items') && is_string($request->items)) {
            $request->items = json_decode($request->items, true);
        }

        try {
            DB::beginTransaction();

            // Create transaksi_pembelian
            $transaksi = new TransaksiPembelian();
            $transaksi->NoFaktur = $request->NoFaktur;
            $transaksi->TglFaktur = $request->TglFaktur;
            $transaksi->Waktu = Carbon::now()->format('H:i:s');
            $transaksi->TglJatuhTempo = $request->TglJatuhTempo;
            $transaksi->id_sales = $request->id_sales;
            $transaksi->id_Apoteker = Auth::id(); // Assuming the user is an apoteker
            $transaksi->save();

            // Create detail transaksi
            foreach ($request->items as $item) {
                $detail = new DetTransaksiPembelian();
                $detail->NoFaktur = $request->NoFaktur;
                $detail->qty = $item['qty'];
                $detail->BesarPotongan = $item['BesarPotongan'];
                $detail->PotCash = $item['PotCash'];
                $detail->HargaBeli = $item['HargaBeli'];
                $detail->id_obat = $item['id_obat'];
                $detail->save();

                // Update stock in obat table
                $obat = Obat::find($item['id_obat']);
                $obat->stok += $item['qty'];
                $obat->save();
            }

            DB::commit();

            return redirect()->route('obat-masuk.create')
                ->with('success', 'Transaksi pembelian berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('obat-masuk.create')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique NoFaktur based on the format: year/roman_month/sequential_number
     */
    private function generateNoFaktur()
    {
        $year = date('Y');
        $month = date('n');
        $romanMonth = $this->numberToRoman($month);

        // Get the latest sequential number for this month and year
        $latestTransaction = TransaksiPembelian::where('NoFaktur', 'like', "$year/$romanMonth/%")
            ->orderBy('NoFaktur', 'desc')
            ->first();

        $sequentialNumber = 1;
        if ($latestTransaction) {
            $parts = explode('/', $latestTransaction->NoFaktur);
            $sequentialNumber = (int)$parts[2] + 1;
        }

        return "$year/$romanMonth/$sequentialNumber";
    }

    /**
     * Convert number to Roman numeral
     */
    private function numberToRoman($number)
    {
        $map = [
            'I',
            'II',
            'III',
            'IV',
            'V',
            'VI',
            'VII',
            'VIII',
            'IX',
            'X',
            'XI',
            'XII'
        ];
        return $map[$number - 1];
    }

    /**
     * Get obat details via AJAX
     */
    public function getObatDetails(Request $request)
    {
        $obat = Obat::find($request->id_obat);

        if ($obat) {
            return response()->json([
                'success' => true,
                'data' => $obat
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Obat tidak ditemukan'
        ]);
    }

    /**
     * Search obat via barcode
     */
    public function searchByBarcode(Request $request)
    {
        $barcode = $request->barcode;
        $obat = Obat::where('id_obat', $barcode)->first();

        if ($obat) {
            return response()->json([
                'success' => true,
                'data' => $obat
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Obat dengan kode tersebut tidak ditemukan'
        ]);
    }

    // In ObatController.php
    public function cariBarcode(Request $request)
    {
        $barcode = $request->input('barcode');

        // Assuming you have a Barcode column in your obat table
        // If not, you might need to add a separate barcode table or column
        $obat = Obat::where('id_obat', $barcode)->first();

        if ($obat) {
            return response()->json([
                'success' => true,
                'data' => $obat
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Obat tidak ditemukan'
        ]);
    }
}
