@extends('layouts.app')

@section('title', 'Daftar Obat')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-table">
            <!-- Tombol Tambah -->
            <div class="btn-tambah mb-3">
                <button
                    class="btn btn-primary py-3 px-6 text-lg font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    data-bs-toggle="modal" data-bs-target="#tambahObatModal">
                    <i class='bx bx-plus'></i> Tambah Obat
                </button>
            </div>

            <div class="row mb-3">
                <!-- Search di sebelah kiri -->
                <div class="col-md-6">
                    <form action="{{ url('/obat') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control me-2" type="search" name="search"
                                placeholder="Cari berdasarkan kode obat atau nama" aria-label="Search"
                                value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6 text-end">
                    <form action="{{ url('/obat') }}" method="GET">
                        <!-- Sorting Dropdown -->
                        <div class="relative inline-block text-left">
                            <!-- Button to Toggle Dropdown -->
                            <button type="button" id="dropdownSortButton"
                                class="inline-flex justify-center items-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 hover:bg-blue-700 focus:ring-offset-2 focus:ring-offset-blue-200">
                                <i class="bx bx-sort mr-2"></i> Sorting
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="dropdownMenu"
                                class="absolute right-0 z-10 mt-2 origin-top-right bg-white rounded-md shadow-lg w-48 ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                                <div class="py-1">
                                    <!-- Sorting Options -->
                                    <button type="submit" name="sort_by" value="NamaObat_asc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none"
                                        title="Urutkan A-Z">
                                        <i class="bx bx-sort-a-z mr-2"></i> Urutkan A-Z
                                    </button>
                                    <button type="submit" name="sort_by" value="NamaObat_desc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none"
                                        title="Urutkan Z-A">
                                        <i class="bx bx-sort-z-a mr-2"></i> Urutkan Z-A
                                    </button>
                                    <button type="submit" name="sort_by" value="TglExp_asc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none"
                                        title="Tanggal Expired Ascending">
                                        <i class="bx bx-calendar mr-2"></i> Tanggal Expired Ascending
                                    </button>
                                    <button type="submit" name="sort_by" value="HargaBeli_asc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none"
                                        title="Harga Beli Terendah">
                                        <i class="bx bx-chevron-up mr-2"></i> Harga Beli Terendah
                                    </button>
                                    <button type="submit" name="sort_by" value="HargaBeli_desc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none"
                                        title="Harga Beli Tertinggi">
                                        <i class="bx bx-chevron-down mr-2"></i> Harga Beli Tertinggi
                                    </button>
                                    <button type="submit" name="sort_by" value="HargaJual_asc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none"
                                        title="Harga Beli Terendah">
                                        <i class="bx bx-chevron-up mr-2"></i> Harga Jual Terendah
                                    </button>
                                    <button type="submit" name="sort_by" value="HargaJual_desc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none"
                                        title="Harga Beli Tertinggi">
                                        <i class="bx bx-chevron-down mr-2"></i> Harga Jual Tertinggi
                                    </button>
                                    <button type="submit" name="sort_by" value="Satuan"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none"
                                        title="Urutkan Berdasarkan Satuan">
                                        <i class="bx bx-capsule mr-2"></i> Urutkan Berdasarkan Satuan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Obat -->
            <div class="overflow-x-auto">
                <table class="table table-striped min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-base font-semibold">No</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Kode Obat</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Nama Obat</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Satuan</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Stok</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">TglExp</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">NoBatch</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Harga Beli</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Harga Jual</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obat as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2 text-base">{{ $obat->firstItem() + $loop->index }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->id_obat }}</td>
                                <td class="px-4 py-2 text-base">
                                    {!! (new \Picqer\Barcode\BarcodeGeneratorHTML())->getBarcode($item->id_obat, 'C128', 1, 33) !!}
                                    <span class="block text-center text-xs">{{ $item->id_obat }}</span>
                                </td>
                                <td class="px-4 py-2 text-base">{{ $item->NamaObat }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->Satuan }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->stok }}</td>
                                <td class="px-4 py-2 text-base">{{ \Carbon\Carbon::parse($item->TglExp)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-2 text-base">{{ $item->NoBatch }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->HargaBeli }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->HargaJual }}</td>
                                <td class="px-4 py-2 text-base">
                                    <!-- Tombol Edit -->
                                    <button class="action-btn edit-btn text-blue-500 hover:text-blue-700"
                                        data-bs-toggle="modal" data-bs-target="#editObatModal"
                                        data-id="{{ $item->id_obat }}">
                                        <i class='bx bx-edit'></i>
                                    </button>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editObatModal" tabindex="-1"
                                        aria-labelledby="editObatModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-white shadow-lg rounded-lg max-w-lg mx-auto">
                                                <div class="modal-header border-b border-gray-200">
                                                    <h5 class="modal-title text-xl font-semibold text-blue-600"
                                                        id="editObatModalLabel">Edit Obat</h5>
                                                    <button type="button"
                                                        class="btn-close text-blue-600 hover:text-blue-800"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <form id="editObatForm" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" id="editObatId" name="id_obat">

                                                        <div class="mb-4">
                                                            <label for="NamaObat"
                                                                class="block text-sm font-medium text-gray-700">Nama
                                                                Obat</label>
                                                            <input type="text" id="editNamaObat" name="NamaObat"
                                                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="Satuan"
                                                                class="block text-sm font-medium text-gray-700">Satuan</label>
                                                            <select id="editSatuan" name="Satuan"
                                                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                                <option value="BOTOL">BOTOL</option>
                                                                <option value="TUBE">TUBE</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="stok"
                                                                class="block text-sm font-medium text-gray-700">Stok</label>
                                                            <input type="number" id="editStok" name="stok"
                                                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="TglEXP"
                                                                class="block text-sm font-medium text-gray-700">Tanggal
                                                                Expired</label>
                                                            <input type="date" id="editTglEXP" name="TglEXP"
                                                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="NoBatch"
                                                                class="block text-sm font-medium text-gray-700">NoBatch</label>
                                                            <input type="text" id="editNoBatch" name="NoBatch"
                                                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="HargaBeli"
                                                                class="block text-sm font-medium text-gray-700">Harga
                                                                Beli</label>
                                                            <input type="number" id="editHargaBeli" name="HargaBeli"
                                                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="HargaJual"
                                                                class="block text-sm font-medium text-gray-700">Harga
                                                                Jual</label>
                                                            <input type="number" id="editHargaJual" name="HargaJual"
                                                                readonly
                                                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                        </div>
                                                        <div class="flex justify-end space-x-2">
                                                            <button type="button"
                                                                class="btn btn-secondary bg-transparent border-2 border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm hover:bg-blue-600 hover:text-white"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="action-btn delete-btn text-red-500 hover:text-red-700"
                                        data-bs-toggle="modal" data-id="{{ $item->id_obat }}"
                                        data-name="{{ $item->NamaObat }}">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container mt-4 mb-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        <!-- Previous Button -->
                        <li class="page-item {{ $obat->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $obat->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <!-- Pagination Links -->
                        @foreach ($obat->getUrlRange(1, $obat->lastPage()) as $page => $url)
                            <li class="page-item {{ $obat->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach

                        <!-- Next Button -->
                        <li class="page-item {{ !$obat->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $obat->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="tambahObatModal" tabindex="-1" aria-labelledby="tambahObatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white shadow-lg rounded-lg max-w-lg mx-auto">
                <div class="modal-header border-b border-gray-200">
                    <h5 class="modal-title text-xl font-semibold text-blue-600" id="tambahObatModalLabel">Tambah Obat Baru
                    </h5>
                    <button type="button" class="btn-close text-blue-600 hover:text-blue-800" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <form action="{{ url('/obat') }}" method="POST" id="tambahObatForm">
                        @csrf
                        <div class="mb-4">
                            <label for="id_obat" class="block text-sm font-medium text-gray-700">Kode Obat</label>
                            <div class="flex items-center">
                                <input type="text"
                                    class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    id="id_obat" name="id_obat" required>
                                <button type="button" id="scanBarcodeBtn"
                                    class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg">
                                    <i class="fas fa-barcode"></i> Scan
                                </button>
                            </div>
                        </div>
                        <!-- Rest of the form remains the same as previous version -->
                        <div class="mb-4">
                            <label for="NamaObat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="NamaObat" name="NamaObat" required>
                        </div>
                        <div class="mb-4">
                            <label for="Satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                            <select
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="Satuan" name="Satuan" required>
                                <option value="TABLET">TABLET</option>
                                <option value="KAPSUL">KAPSUL</option>
                                <option value="KAPLET">KAPLET</option>
                                <option value="PIL">PIL</option>
                                <option value="BUTIR">BUTIR</option>
                                <option value="STRIP">STRIP</option>
                                <option value="BOTOL">BOTOL</option>
                                <option value="TUBE">TUBE</option>
                                <option value="SACHET">SACHET</option>
                                <option value="AMPUL">AMPUL</option>
                                <option value="VIAL">VIAL</option>
                                <option value="ML">ML</option>
                                <option value="LITER">LITER</option>
                                <option value="TETES">TETES</option>
                                <option value="GRAM">GRAM</option>
                                <option value="DOSIS">DOSIS</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="stok" name="stok" required>
                        </div>
                        <div class="mb-4">
                            <label for="TglEXP" class="block text-sm font-medium text-gray-700">Tanggal Expired</label>
                            <input type="date"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="TglEXP" name="TglEXP" required>
                        </div>
                        <div class="mb-4">
                            <label for="NoBatch" class="block text-sm font-medium text-gray-700">NoBatch</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="NoBatch" name="NoBatch" required>
                        </div>
                        <div class="mb-4">
                            <label for="HargaBeli" class="block text-sm font-medium text-gray-700">Harga Beli</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="HargaBeli" name="HargaBeli" required>
                        </div>

                        <div class="mb-4">
                            <label for="HargaJual" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="HargaJual" name="HargaJual" readonly>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                class="btn btn-secondary bg-transparent border-2 border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm hover:bg-blue-600 hover:text-white focus:ring-4 focus:ring-blue-500"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit"
                                class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Scanner Modal -->
    <div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barcodeModalLabel">Scan Barcode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="barcode-scanner" class="w-full h-64">
                        <!-- Placeholder for barcode scanner -->
                        <video id="scanner-video" class="w-full h-full"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanBarcodeBtn = document.getElementById('scanBarcodeBtn');
            const idObatInput = document.getElementById('id_obat');
            const barcodeModal = new bootstrap.Modal(document.getElementById('barcodeModal'));
            let html5QrCode = null;

            scanBarcodeBtn.addEventListener('click', function() {
                // Open barcode scanner modal
                barcodeModal.show();

                // Initialize barcode scanner
                html5QrCode = new Html5Qrcode("barcode-scanner");
                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length) {
                        const cameraId = devices[0].id;
                        html5QrCode.start(
                            cameraId, {
                                fps: 10, // frames per second
                                qrbox: 250 // size of scanning box
                            },
                            onScanSuccess
                        );
                    }
                }).catch(err => {
                    console.error("Error accessing camera:", err);
                    alert("Tidak dapat mengakses kamera. Pastikan izin kamera diaktifkan.");
                });
            });

            function onScanSuccess(decodedText, decodedResult) {
                // Stop scanning
                html5QrCode.stop().then(() => {
                    // Close the modal
                    barcodeModal.hide();

                    // Set the scanned barcode to the input field
                    idObatInput.value = decodedText;

                    // Optional: Fetch medicine details based on barcode
                    fetchMedicineDetails(decodedText);
                }).catch(err => {
                    console.error("Error stopping scanner:", err);
                });
            }

            function fetchMedicineDetails(barcode) {
                // AJAX call to Laravel backend to fetch medicine details
                fetch(`/obat/details-by-barcode?barcode=${encodeURIComponent(barcode)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.medicine) {
                            // Autofill other fields if medicine exists
                            document.getElementById('NamaObat').value = data.medicine.nama_obat;
                            document.getElementById('Satuan').value = data.medicine.satuan;
                            document.getElementById('stok').value = data.medicine.stok;
                            document.getElementById('TglEXP').value = data.medicine.tgl_exp;
                            document.getElementById('NoBatch').value = data.medicine.no_batch;
                            document.getElementById('HargaBeli').value = data.medicine.harga_beli;

                            // Trigger harga jual calculation
                            const hargaBeliInput = document.getElementById('HargaBeli');
                            const event = new Event('input');
                            hargaBeliInput.dispatchEvent(event);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching medicine details:', error);
                        // Optionally show a toast or alert that no details were found
                    });
            }

            // Existing price calculation logic
            document.getElementById('HargaBeli').addEventListener('input', function() {
                let hargaBeli = parseFloat(this.value);
                if (!isNaN(hargaBeli)) {
                    let hargaJual = hargaBeli * 1.51;
                    document.getElementById('HargaJual').value = hargaJual.toFixed(0);
                } else {
                    document.getElementById('HargaJual').value = '';
                }
            });
        });
    </script>

    <!-- Modal Edit Obat -->
    {{-- <div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white shadow-lg rounded-lg max-w-lg mx-auto">
                <div class="modal-header border-b border-gray-200">
                    <h5 class="modal-title text-xl font-semibold text-blue-600" id="editObatModalLabel">Edit Obat</h5>
                    <button type="button" class="btn-close text-blue-600 hover:text-blue-800" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <form id="editObatForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editObatId" name="id_obat">
                        <div class="mb-4">
                            <label for="NamaObat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editNamaObat" name="NamaObat" required>
                        </div>
                        <div class="mb-4">
                            <label for="Satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                            <select
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editSatuan" name="Satuan" required>
                                <option value="BOTOL">BOTOL</option>
                                <option value="TUBE">TUBE</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editStok" name="stok" required>
                        </div>
                        <div class="mb-4">
                            <label for="TglEXP" class="block text-sm font-medium text-gray-700">Tanggal Expired</label>
                            <input type="date"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editTglEXP" name="TglEXP" required>
                        </div>
                        <div class="mb-4">
                            <label for="NoBatch" class="block text-sm font-medium text-gray-700">NoBatch</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editNoBatch" name="NoBatch" required>
                        </div>
                        <div class="mb-4">
                            <label for="HargaBeli" class="block text-sm font-medium text-gray-700">Harga Beli</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editHargaBeli" name="HargaBeli" required>
                        </div>
                        <div class="mb-4">
                            <label for="HargaJual" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editHargaJual" name="HargaJual" required readonly>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                class="btn btn-secondary bg-transparent border-2 border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm hover:bg-blue-600 hover:text-white focus:ring-4 focus:ring-blue-500"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit"
                                class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const form = document.getElementById('editObatForm');
                form.action = `/obat/${id}`;
                // Anda juga bisa load data via AJAX di sini jika perlu isi form otomatis
            });
        });
        document.getElementById("editHargaBeli").addEventListener("input", function() {
            let HargaBeli = parseFloat(this.value);
            if (!isNaN(HargaBeli)) {
                let HargaJual = HargaBeli * 1.51; // Misalnya, markup 20%
                document.getElementById("editHargaJual").value = Math.round(HargaJual);
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Dropdown Toggle
            const dropdownButton = document.getElementById('dropdownSortButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            dropdownButton.addEventListener('click', (e) => {
                // Prevent click from propagating to window
                e.stopPropagation();
                // Toggle visibility with scale transition
                dropdownMenu.classList.toggle('hidden');
                dropdownMenu.classList.toggle('scale-95');
            });

            // Close the dropdown if clicked outside
            window.addEventListener('click', (e) => {
                if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                    dropdownMenu.classList.add('scale-95');
                }
            });

            // Check if there's a session success message to show a notification
            @if (session('success'))
                Swal.fire({
                    title: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#007bff', // Blue color for 'Ok' button
                });
            @endif

            // Check if there's a validation error message for duplicate data
            @if ($errors->has('id_obat'))
                Swal.fire({
                    title: 'Gagal! Kode Obat sudah ada.',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#007bff', // Blue color for 'Ok' button
                });
            @endif

            // Handle Delete Button
            const deleteBtns = document.querySelectorAll('.delete-btn');
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const obatId = btn.getAttribute('data-id');
                    const obatName = btn.getAttribute('data-name');
                    Swal.fire({
                        title: `Apakah Anda yakin ingin menghapus obat "${obatName}"?`,
                        text: "Tindakan ini tidak dapat dibatalkan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#007bff',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/obat/${obatId}`;
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            form.appendChild(csrfToken);
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Handle Edit Button
            const editBtns = document.querySelectorAll('.edit-btn');
            editBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const obatId = btn.getAttribute('data-id');

                    fetch(`/obat/${obatId}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                // Isi form dengan data dari backend
                                document.getElementById('editObatId').value = data.id_obat;
                                document.getElementById('editNamaObat').value = data.NamaObat;
                                document.getElementById('editSatuan').value = data.Satuan;
                                document.getElementById('editStok').value = data.stok;
                                document.getElementById('editTglEXP').value = data.TglEXP;
                                document.getElementById('editNoBatch').value = data.NoBatch;
                                document.getElementById('editHargaBeli').value = data.HargaBeli;
                                document.getElementById('editHargaJual').value = data.HargaJual;

                                // Set form action ke endpoint PUT
                                const form = document.getElementById('editObatForm');
                                form.action = `/obat/${obatId}`;
                            } else {
                                Swal.fire({
                                    title: 'Data tidak ditemukan.',
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#007bff',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Gagal mengambil data:', error);
                            Swal.fire({
                                title: 'Terjadi kesalahan.',
                                text: 'Gagal mengambil data obat.',
                                icon: 'error',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#007bff',
                            });
                        });
                });
            });

            // Handle form submission for updating drug
            document.getElementById('editObatForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const jsonData = {};
                formData.forEach((value, key) => {
                    jsonData[key] = value;
                });
                fetch(this.action, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(jsonData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Obat ' + data.NamaObat + ' berhasil diperbarui!',
                                icon: 'success',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#007bff',
                            }).then(() => {
                                location.reload();
                            });
                        } else if (data.error) {
                            Swal.fire({
                                title: data.error,
                                icon: 'error',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#007bff',
                            });
                        }
                    })
                    .catch(error => console.error('Error updating drug:', error));
            });
        });
    </script>

    <!-- Sertakan JS untuk modal dan interaksi lainnya -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
