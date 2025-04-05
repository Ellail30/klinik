<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // Ambil keyword pencarian jika ada
        $search = $request->input('search');

        // Query data supplier dengan pencarian dan pagination
        $suppliers = Supplier::when($search, function ($query, $search) {
            return $query->where('NamaSupplier', 'like', '%' . $search . '%')
                         ->orWhere('Alamat', 'like', '%' . $search . '%');
        })->paginate(5); // 5 data per halaman

        // Kirim data ke view
        return view('supplier', compact('suppliers'));
    }


    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect('/supplier')->with('success', 'Supplier berhasil dihapus');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_supplier' => 'required|unique:supplier|max:255',
            'NamaSupplier' => 'required|max:255',
            'NPWP' => 'required|max:20',
            'NoIjinPBF' => 'required|max:20',
            'Alamat' => 'required|max:255',
        ]);

        Supplier::create($validatedData);
        return redirect('/supplier')->with('success', 'Supplier berhasil ditambahkan');
    }

    // Method to fetch supplier details for editing
public function edit($id)
{
    $supplier = Supplier::findOrFail($id); // Find supplier by ID
    return response()->json($supplier); // Return supplier data as JSON
}

// Method to update supplier details
public function update(Request $request, $id)
{
    // Validate the data
    $validatedData = $request->validate([
        'NamaSupplier' => 'required|max:255',
        'NPWP' => 'required|max:20',
        'NoIjinPBF' => 'required|max:20',
        'Alamat' => 'required|max:255',
    ]);

    // Find the supplier by ID and update
    $supplier = Supplier::findOrFail($id);
    $supplier->update($validatedData);

    // Return success response
    return response()->json(['success' => true, 'NamaSupplier' => $supplier->NamaSupplier]);
}


}
