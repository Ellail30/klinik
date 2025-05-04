@extends('layouts.app')

@section('title', 'Input Pembelian Obat')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-form">
            <!-- Alert Section -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Form Input Pembelian Obat</h2>

                <form id="pembelianForm" action="{{ route('obat-masuk.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Transaction Details -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="NoFaktur">No Faktur</label>
                            <input type="text" name="NoFaktur" id="NoFaktur" class="form-control"
                                value="{{ $noFaktur }}" >
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="TglFaktur">Tanggal Faktur</label>
                            <input type="date" name="TglFaktur" id="TglFaktur" class="form-control"
                                value="" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="TglJatuhTempo">Tanggal Jatuh
                                Tempo</label>
                            <input type="date" name="TglJatuhTempo" id="TglJatuhTempo" class="form-control"
                                value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_sales">Sales</label>
                            <select name="id_sales" id="id_sales" class="form-control" required>
                                <option value="">Pilih Sales</option>
                                @foreach ($sales as $s)
                                    <option value="{{ $s->id_sales }}">{{ $s->NamaSales }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Drug Input Section -->
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700">Input Obat</h3>

                        <!-- Barcode Scanning Section -->
                        <div class="mb-4">
                            <div class="flex items-center space-x-2">
                                <input type="text" id="barcodeInput" class="form-control flex-grow"
                                    placeholder="Scan barcode atau masukkan kode obat" autocomplete="off">
                                <button type="button" id="btnScanBarcode" class="btn btn-primary">
                                    <i class='bx bx-barcode-reader'></i> Scan
                                </button>
                            </div>
                        </div>

                        <!-- OR Divider -->
                        <div class="relative flex py-2 items-center">
                            <div class="flex-grow border-t border-gray-300"></div>
                            <span class="flex-shrink mx-4 text-gray-600">ATAU</span>
                            <div class="flex-grow border-t border-gray-300"></div>
                        </div>

                        <!-- Manual Input Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="manualObat">Pilih
                                    Obat</label>
                                <select id="manualObat" class="form-control">
                                    <option value="">Pilih Obat</option>
                                    @foreach ($obat as $o)
                                        <option value="{{ $o->id_obat }}" data-nama="{{ $o->NamaObat }}"
                                            data-satuan="{{ $o->Satuan }}" data-harga="{{ $o->HargaBeli }}"
                                            data-barcode="{{ $o->Barcode }}">
                                            {{ $o->id_obat }} - {{ $o->NamaObat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="btnAddManual" class="btn btn-success mt-2">
                                    <i class='bx bx-plus-circle'></i> Tambahkan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Temporary Purchase Details -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700">Detail Pembelian Sementara</h3>
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-striped w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2">Kode Obat</th>
                                        <th class="px-4 py-2">Nama Obat</th>
                                        <th class="px-4 py-2">Satuan</th>
                                        <th class="px-4 py-2">Qty</th>
                                        <th class="px-4 py-2">Harga Beli</th>
                                        <th class="px-4 py-2">Potongan (%)</th>
                                        <th class="px-4 py-2">Potongan Cash</th>
                                        <th class="px-4 py-2">Total</th>
                                        <th class="px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="detailItems">
                                    <tr id="emptyCart" class="text-center">
                                        <td colspan="9" class="py-4">Belum ada item yang ditambahkan</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-right font-bold">Grand Total:</td>
                                        <td id="grandTotal" class="font-bold">Rp 0</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Hidden input to store JSON data of items -->
                    <input type="hidden" name="items" id="itemsJson" value="[]">

                    <!-- Submit Button -->
                    <div class="mt-8 text-center">
                        <button type="submit"
                            class="btn btn-primary btn-lg py-3 px-8 text-lg font-bold rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                            <i class='bx bx-save mr-2'></i> Simpan Transaksi Pembelian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Item -->
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editItemIndex">

                    <div class="mb-3">
                        <label for="editQty" class="form-label">Qty</label>
                        <input type="number" class="form-control" id="editQty" min="1">
                    </div>

                    <div class="mb-3">
                        <label for="editHargaBeli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="editHargaBeli" min="0">
                    </div>

                    <div class="mb-3">
                        <label for="editBesarPotongan" class="form-label">Besar Potongan (%)</label>
                        <input type="number" class="form-control" id="editBesarPotongan" min="0" max="100"
                            step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="editPotCash" class="form-label">Potongan Cash (Rp)</label>
                        <input type="number" class="form-control" id="editPotCash" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnUpdateItem">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* Button styles to ensure text visibility */
        .btn {
            color: white;
            /* Default text color */
            border-color: transparent;
            /* Prevent outline from hiding text */
        }

        /* Primary button specific styles */
        .btn-primary {
            background-color: #007bff;
            /* Bootstrap primary blue */
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        /* Success button specific styles */
        .btn-success {
            background-color: #28a745;
            /* Bootstrap success green */
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        /* Secondary button specific styles */
        .btn-secondary {
            background-color: #6c757d;
            /* Bootstrap secondary gray */
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
            /* Darker gray on hover */
        }

        /* Info Button Styles */
.btn-info {
    background-color: #17a2b8; /* Bootstrap info blue */
    color: white;
    border-color: transparent;
}

.btn-info:hover {
    background-color: #138496; /* Darker blue on hover */
    color: white;
}

/* Danger Button Styles */
.btn-danger {
    background-color: #dc3545; /* Bootstrap danger red */
    color: white;
    border-color: transparent;
}

.btn-danger:hover {
    background-color: #bd2130; /* Darker red on hover */
    color: white;
}

/* Ensure small buttons have appropriate sizing */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

/* Smooth transition for hover effects */
.btn-info,
.btn-danger {
    transition: background-color 0.2s ease;
}

        /* Ensure border doesn't hide text */
        .btn {
            border: 1px solid transparent;
        }

        /* Optional: Add subtle transition for smooth hover effect */
        .btn {
            transition: background-color 0.2s ease;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize items array
            let items = [];

            // Format rupiah
            function formatRupiah(angka) {
                return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
            }

            // Calculate item total
            function calculateItemTotal(item) {
                const hargaSetelahDiskon = item.HargaBeli * (1 - (item.BesarPotongan / 100));
                return (hargaSetelahDiskon * item.qty) - item.PotCash;
            }

            // Update grand total
            function updateGrandTotal() {
                const total = items.reduce((sum, item) => sum + calculateItemTotal(item), 0);
                document.getElementById('grandTotal').textContent = formatRupiah(total);
                document.getElementById('itemsJson').value = JSON.stringify(items);
            }

            // Render cart items
            function renderItems() {
                const tbody = document.getElementById('detailItems');
                const emptyCart = document.getElementById('emptyCart');

                // If items exist, hide empty cart message
                if (items.length > 0) {
                    emptyCart.style.display = 'none';
                } else {
                    emptyCart.style.display = 'table-row';
                }

                // Clear existing rows (except empty cart message)
                Array.from(tbody.children).forEach(child => {
                    if (child.id !== 'emptyCart') {
                        tbody.removeChild(child);
                    }
                });

                // Add items
                items.forEach((item, index) => {
                    const total = calculateItemTotal(item);

                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td class="px-4 py-2">${item.id_obat}</td>
                    <td class="px-4 py-2">${item.NamaObat}</td>
                    <td class="px-4 py-2">${item.Satuan}</td>
                    <td class="px-4 py-2">${item.qty}</td>
                    <td class="px-4 py-2">${formatRupiah(item.HargaBeli)}</td>
                    <td class="px-4 py-2">${item.BesarPotongan}%</td>
                    <td class="px-4 py-2">${formatRupiah(item.PotCash)}</td>
                    <td class="px-4 py-2">${formatRupiah(total)}</td>
                    <td class="px-4 py-2">
                        <button type="button" class="btn btn-sm btn-info edit-item" data-index="${index}">
                            <i class='bx bx-edit'></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger remove-item" data-index="${index}">
                            <i class='bx bx-trash'></i>
                        </button>
                    </td>
                `;
                    tbody.appendChild(row);
                });

                // Update grand total
                updateGrandTotal();

                // Add event listeners for edit and remove buttons
                document.querySelectorAll('.edit-item').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        openEditModal(index);
                    });
                });

                document.querySelectorAll('.remove-item').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        removeItem(index);
                    });
                });
            }

            // Add item to cart
            function addItem(itemData) {
                // Check if item already exists in cart
                const existingItemIndex = items.findIndex(item => item.id_obat === itemData.id_obat);

                if (existingItemIndex !== -1) {
                    // If item exists, increase quantity
                    items[existingItemIndex].qty += 1;
                } else {
                    // Add new item with default values
                    items.push({
                        id_obat: itemData.id_obat,
                        NamaObat: itemData.NamaObat,
                        Satuan: itemData.Satuan,
                        qty: 1,
                        HargaBeli: itemData.HargaBeli,
                        BesarPotongan: 0,
                        PotCash: 0
                    });
                }

                // Render updated cart
                renderItems();

                // Clear inputs
                document.getElementById('barcodeInput').value = '';
                document.getElementById('manualObat').value = '';
                document.getElementById('barcodeInput').focus();
            }

            // Remove item from cart
            function removeItem(index) {
                if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                    items.splice(index, 1);
                    renderItems();
                }
            }

            // Open edit modal
            function openEditModal(index) {
                const item = items[index];

                document.getElementById('editItemIndex').value = index;
                document.getElementById('editQty').value = item.qty;
                document.getElementById('editHargaBeli').value = item.HargaBeli;
                document.getElementById('editBesarPotongan').value = item.BesarPotongan;
                document.getElementById('editPotCash').value = item.PotCash;

                const editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
                editModal.show();
            }

            // Update item in cart
            function updateItem() {
                const index = parseInt(document.getElementById('editItemIndex').value);

                items[index].qty = parseInt(document.getElementById('editQty').value);
                items[index].HargaBeli = parseInt(document.getElementById('editHargaBeli').value);
                items[index].BesarPotongan = parseFloat(document.getElementById('editBesarPotongan').value);
                items[index].PotCash = parseFloat(document.getElementById('editPotCash').value);

                renderItems();

                const editModal = bootstrap.Modal.getInstance(document.getElementById('editItemModal'));
                editModal.hide();
            }

            // Handle barcode scanning
            function handleBarcodeScan(barcode) {
                // First, check if barcode exists in manual select options
                const manualSelect = document.getElementById('manualObat');
                const matchingOption = Array.from(manualSelect.options).find(option =>
                    option.getAttribute('data-barcode') === barcode
                );

                if (matchingOption) {
                    const itemData = {
                        id_obat: matchingOption.value,
                        NamaObat: matchingOption.getAttribute('data-nama'),
                        Satuan: matchingOption.getAttribute('data-satuan'),
                        HargaBeli: parseInt(matchingOption.getAttribute('data-harga'))
                    };

                    addItem(itemData);
                } else {
                    // If not found, show error or prompt to add manually
                    alert('Obat dengan barcode tersebut tidak ditemukan. Silakan tambahkan secara manual.');
                    document.getElementById('barcodeInput').value = barcode;
                    document.getElementById('manualObat').focus();
                }
            }

            // Barcode input event listeners
            document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const barcode = this.value.trim();
                    if (barcode) {
                        handleBarcodeScan(barcode);
                    }
                }
            });

            // Barcode scanning logic modification
document.getElementById('btnScanBarcode').addEventListener('click', function() {
    // Create modal for camera input
    const scanModal = document.createElement('div');
    scanModal.innerHTML = `
    <div class="modal fade show" id="barcodeScanModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan Barcode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="scanner-container" class="w-100" style="max-height: 400px; overflow: hidden;"></div>
                    <div id="scanResult" class="p-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
`;
    document.body.appendChild(scanModal);

    const modal = new bootstrap.Modal(document.getElementById('barcodeScanModal'));
    const scanResult = document.getElementById('scanResult');
    modal.show();

    // Unique tracking for recently scanned barcodes to prevent duplicate scans
    const scannedBarcodes = new Set();

    // Initialize Quagga scanner
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#scanner-container'),
            constraints: {
                width: 640,
                height: 480,
                facingMode: "environment" // Prefer back camera
            },
        },
        locator: {
            patchSize: "medium",
            halfSample: true
        },
        numOfWorkers: navigator.hardwareConcurrency || 4,
        decoder: {
            readers: [
                "ean_reader", // For EAN barcodes
                "ean_8_reader",
                "code_128_reader", // For Code 128 barcodes
                "code_39_reader"
            ]
        },
        locate: true
    }, function(err) {
        if (err) {
            console.error('Error initializing Quagga:', err);
            scanResult.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memulai scanner. ${err.message}
                </div>
            `;
            return;
        }
        // Start scanning
        Quagga.start();
    });

    // Listen for successful scans
    Quagga.onDetected(function(result) {
        const barcode = result.codeResult.code;

        // Prevent duplicate scans
        if (scannedBarcodes.has(barcode)) return;
        scannedBarcodes.add(barcode);

        // Send barcode to server to find matching drug
        fetch(`/cari-barcode?barcode=${barcode}`)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Automatically add item to cart
                    const itemData = {
                        id_obat: result.data.id_obat,
                        NamaObat: result.data.NamaObat,
                        Satuan: result.data.Satuan,
                        HargaBeli: result.data.HargaBeli
                    };

                    // Add item to cart
                    addItem(itemData);

                    // Show success message
                    scanResult.innerHTML = `
                        <div class="alert alert-success">
                            Berhasil menambahkan: ${result.data.NamaObat}
                        </div>
                    `;

                    // Clear the scanned barcode after a short delay to allow multiple scans
                    setTimeout(() => {
                        scannedBarcodes.delete(barcode);
                    }, 2000);
                } else {
                    // Display error message
                    scanResult.innerHTML = `
                        <div class="alert alert-danger">
                            Obat dengan barcode ${barcode} tidak ditemukan.
                            Silakan tambahkan secara manual.
                        </div>
                    `;

                    // Clear the scanned barcode
                    scannedBarcodes.delete(barcode);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                scanResult.innerHTML = `
                    <div class="alert alert-danger">
                        Terjadi kesalahan saat mencari obat.
                    </div>
                `;

                // Clear the scanned barcode
                scannedBarcodes.delete(barcode);
            });
    });

    // Clean up when modal is closed
    document.getElementById('barcodeScanModal').addEventListener('hidden.bs.modal', () => {
        Quagga.stop();
        document.body.removeChild(scanModal);
    });
});

            // Manual add button
            document.getElementById('btnAddManual').addEventListener('click', function() {
                const select = document.getElementById('manualObat');
                const selectedOption = select.options[select.selectedIndex];

                if (select.value) {
                    const itemData = {
                        id_obat: select.value,
                        NamaObat: selectedOption.getAttribute('data-nama'),
                        Satuan: selectedOption.getAttribute('data-satuan'),
                        HargaBeli: parseInt(selectedOption.getAttribute('data-harga'))
                    };

                    addItem(itemData);
                } else {
                    alert('Silakan pilih obat terlebih dahulu.');
                }
            });

            // Update item button click
            document.getElementById('btnUpdateItem').addEventListener('click', updateItem);

            // Form submit validation
            document.getElementById('pembelianForm').addEventListener('submit', function(e) {
                if (items.length === 0) {
                    e.preventDefault();
                    alert('Tidak dapat menyimpan transaksi. Keranjang belanja masih kosong!');
                }
            });

            // Focus on barcode input on page load
            document.getElementById('barcodeInput').focus();
        });
    </script>
@endpush
