@extends('layouts.app')

@section('title', 'Daftar Obat Masuk')

@section('styles')
<style>
    #scannerContainer {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
    }
    #preview {
        width: 100%;
        height: 300px; /* Fixed height for better camera display */
        border: 1px solid #ddd;
        background-color: #f8f9fa; /* Visual feedback when camera is loading */
    }
    .hidden {
        display: none !important;
    }
</style>
@endsection

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-table">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Entry Data</h2>
                <form action="{{ url('/obatmasuk') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="NoDetBeli" class="block text-sm font-medium text-gray-700">No Pembelian</label>
                            <input type="text" id="NoDetBeli" name="NoDetBeli" value="{{ $newNoDetBeli ?? '' }}" readonly
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-black">
                        </div>

                        <div>
                            <label for="NoFaktur" class="block text-sm font-medium text-gray-700">No Faktur</label>
                            <input type="text" id="NoFaktur" name="NoFaktur" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-black">
                        </div>

                        <div>
                            <label for="qty" class="block text-sm font-medium text-gray-700">Qty</label>
                            <input type="number" id="qty" name="qty" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-black">
                        </div>

                        <div>
                            <label for="BesarPotongan" class="block text-sm font-medium text-gray-700">Besar Potongan</label>
                            <input type="text" id="BesarPotongan" name="BesarPotongan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-black">
                        </div>

                        <div>
                            <label for="PotCash" class="block text-sm font-medium text-gray-700">Potongan Cash</label>
                            <input type="text" id="PotCash" name="PotCash" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-black">
                        </div>

                        <div>
                            <label for="HargaBeli" class="block text-sm font-medium text-gray-700">Harga Beli</label>
                            <input type="number" id="HargaBeli" name="HargaBeli" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-black">
                        </div>

                        <div>
                            <label for="id_obat" class="block text-sm font-medium text-gray-700">Kode Obat</label>
                            <div class="flex space-x-2">
                                <input type="text" id="id_obat" name="id_obat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-black"
                                    placeholder="Masukkan kode atau scan barcode">
                                    <button id="startScan" type="button" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Scan</button>
                            </div>
                        </div>
                            <!-- Scanner container -->
                            <div id="scannerContainer" class="mt-4 hidden">
                                <div id="reader" class="w-full" style="max-width: 500px; height: 300px;"></div>
                                <button type="button" id="closeScan" class="mt-2 bg-red-500 text-white px-4 py-2 rounded-md">Tutup Kamera</button>
                            </div>
                        </div>
                        <div class="mt-6">
                        <button class="btn btn-outline-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>

            <!-- Bagian tabel tetap sama -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Pembelian</th>
                        <th>No Faktur</th>
                        <th>Qty</th>
                        <th>Besar Potongan</th>
                        <th>Potongan Cash</th>
                        <th>Harga Beli</th>
                        <th>Kode Obat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obatmasuk as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->NoDetBeli }}</td>
                            <td>{{ $item->NoFaktur }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->BesarPotongan }}</td>

                     <td>{{ $item->PotCash }}</td>
                            <td>{{ $item->HargaBeli }}</td>
                            <td>{{ $item->id_obat }}</td>
                            <td>
                                <button class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editObatMasukModal"
                                    data-id="{{ $item->NoDetBeli }}">
                                    <i class='bx bx-edit'></i>
                                </button>

                                <form action="{{ url('/det_transaksi_pembelian/'.$item->NoDetBeli) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal" data-id="{{ $item->NoDetBeli }}">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="pagination-container">
                {{ $obatmasuk->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1"
        aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus obat ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Tidak</button>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-success" type="submit">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<!-- Library HTML5 QR Code -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startScanButton = document.getElementById('startScan');
        const closeScanButton = document.getElementById('closeScan');
        const scannerContainer = document.getElementById('scannerContainer');
        const idObatInput = document.getElementById('id_obat');
        let html5QrCode = new Html5Qrcode("reader");

        startScanButton.addEventListener('click', function () {
            console.log("Tombol Scan diklik");
            scannerContainer.style.display = 'block';
            closeScanButton.style.display = 'inline-block';
            startScanner();
        });

        function startScanner() {
            const config = { fps: 10, qrbox: { width: 250, height: 150 }, aspectRatio: 1.0 };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText) => {
                    console.log("Kode terdeteksi:", decodedText);
                    idObatInput.value = decodedText;
                    stopScanner();
                },
                (errorMessage) => {
                    console.log("Pemindaian gagal:", errorMessage);
                }
            ).catch(err => {
                console.error("Gagal memulai scanner:", err);
                alert("Gagal mengakses kamera: " + err.message);
                scannerContainer.style.display = 'none';
                closeScanButton.style.display = 'none';
            });
        }

        function stopScanner() {
            html5QrCode.stop().then(() => {
                console.log("Scanner dihentikan");
                scannerContainer.style.display = 'none';
                closeScanButton.style.display = 'none';
            }).catch(err => {
                console.error("Error menghentikan scanner:", err);
            });
        }

        closeScanButton.addEventListener('click', stopScanner);
    });
    </script>
    @endsection
