@extends('layouts.app')

@section('title', 'Daftar Transaksi Pembelian')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-table">
            <!-- Tombol Tambah -->
            <div class="btn-tambah mb-3">
                <a href="{{ route('obat-masuk.create') }}"
                    class="btn btn-primary py-3 px-6 text-lg font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class='bx bx-plus'></i> Tambah Transaksi Pembelian
                </a>
            </div>

            <!-- Search dan Sorting -->
            <div class="row mb-3">
                <!-- Search di sebelah kiri -->
                <div class="col-md-6">
                    <form action="{{ route('obat-masuk.index') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control me-2" type="search" name="search"
                                placeholder="Cari berdasarkan No Faktur, Sales, atau Apoteker" aria-label="Search"
                                value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>

                <!-- Sorting di sebelah kanan -->
                <div class="col-md-6 text-end">
                    <form action="{{ route('obat-masuk.index') }}" method="GET">
                        <!-- Sorting Dropdown -->
                        <div class="relative inline-block text-left">
                            <button type="button" id="dropdownSortButton"
                                class="inline-flex justify-center items-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 hover:bg-blue-700 focus:ring-offset-2 focus:ring-offset-blue-200">
                                <i class="bx bx-sort mr-2"></i> Sorting
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="dropdownMenu"
                                class="absolute right-0 z-10 mt-2 origin-top-right bg-white rounded-md shadow-lg w-48 ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                                <div class="py-1">
                                    <!-- Sorting Options -->
                                    <button type="submit" name="sort_by" value="NoFaktur_asc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none">
                                        <i class="bx bx-sort-a-z mr-2"></i> No Faktur A-Z
                                    </button>
                                    <button type="submit" name="sort_by" value="TglFaktur_asc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none">
                                        <i class="bx bx-calendar mr-2"></i> Tanggal Faktur Ascending
                                    </button>
                                    <button type="submit" name="sort_by" value="TglFaktur_desc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none">
                                        <i class="bx bx-calendar-alt mr-2"></i> Tanggal Faktur Descending
                                    </button>
                                    <button type="submit" name="sort_by" value="TglJatuhTempo_asc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none">
                                        <i class="bx bx-time mr-2"></i> Tanggal Jatuh Tempo Ascending
                                    </button>
                                    <button type="submit" name="sort_by" value="TglJatuhTempo_desc"
                                        class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none">
                                        <i class="bx bx-time-five mr-2"></i> Tanggal Jatuh Tempo Descending
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Transaksi Pembelian -->
            <div class="overflow-x-auto">
                <table class="table table-striped min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-base font-semibold">No</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">No Faktur</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Tanggal Faktur</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Waktu</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Tanggal Jatuh Tempo</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Sales</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Apoteker</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Total Item</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Total Harga</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2 text-base">{{ $transaksi->firstItem() + $loop->index }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->NoFaktur }}</td>
                                <td class="px-4 py-2 text-base">
                                    {{ \Carbon\Carbon::parse($item->TglFaktur)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->Waktu }}</td>
                                <td class="px-4 py-2 text-base">
                                    {{ \Carbon\Carbon::parse($item->TglJatuhTempo)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->NamaSales }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->NamaApoteker }}</td>
                                <td class="px-4 py-2 text-base">{{ $item->total_item }}</td>
                                <td class="px-4 py-2 text-base">Rp. {{ number_format($item->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-base">
                                    <a href="{{ route('obat-masuk.show', $item->NoFaktur) }}"
                                        class="action-btn view-btn text-green-500 hover:text-green-700 mr-2">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <a href="{{ route('obat-masuk.edit', $item->NoFaktur) }}"
                                        class="action-btn edit-btn text-blue-500 hover:text-blue-700 mr-2">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <button class="action-btn delete-btn text-red-500 hover:text-red-700"
                                        data-route="{{ route('obat-masuk.destroy', $item->NoFaktur) }}"
                                        data-name="{{ $item->NoFaktur }}" data-type="transaksi pembelian">
                                        <i class='bx bx-trash'></i>
                                    </button>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container mt-4 mb-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-start">
                        <!-- Previous Button -->
                        <li class="page-item {{ $transaksi->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $transaksi->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <!-- Pagination Links -->
                        @foreach ($transaksi->getUrlRange(1, $transaksi->lastPage()) as $page => $url)
                            <li class="page-item {{ $transaksi->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach

                        <!-- Next Button -->
                        <li class="page-item {{ !$transaksi->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $transaksi->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Delete modal handler
                const deleteModal = document.getElementById('deleteTransaksiModal');
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const noFaktur = button.getAttribute('data-no-faktur');
                    const deleteForm = document.getElementById('deleteTransaksiForm');
                    deleteForm.action = `/obat-masuk/${noFaktur}`;
                });

                // Dropdown toggle for sorting
                const dropdownButton = document.getElementById('dropdownSortButton');
                const dropdownMenu = document.getElementById('dropdownMenu');

                dropdownButton.addEventListener('click', function() {
                    dropdownMenu.classList.toggle('hidden');
                });

                // Close dropdown if clicked outside
                document.addEventListener('click', function(event) {
                    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
@endsection
