    @extends('layouts.app')

@section('title', 'Daftar Transaksi Pembelian')

@section('content')
    <div class="p-4 sm:ml-64">
            <!-- Tombol Tambah -->
            {{-- <div class="btn-tambah mb-3">
                <a href="{{ route('obat-masuk.create') }}"
                    class="btn btn-primary py-3 px-6 text-lg font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class='bx bx-plus'></i> Tambah Transaksi Pembelian
                </a>
            </div> --}}

            <!-- Search dan Sorting -->
            {{-- <div class="row mb-3">
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
            </div> --}}

            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Data Obat Masuk</h4>
                    <div>
                        <a href="{{ route('obat-masuk.create') }}" class="btn btn-success">
                            <i class='bx bx-plus'></i> Tambah Data
                        </a>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class='bx bx-filter'></i> Filter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('obat-masuk.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari No Faktur..."
                                    value="{{ request('search') }}">
                                <button type="submit"
                                    class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">
                                    <i class='bx bx-search'></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <form action="{{ route('obat-masuk.export') }}" method="GET" id="exportForm">
                                <!-- Hidden fields to carry over current filters to PDF export -->
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                                <input type="hidden" name="sales_id" value="{{ request('sales_id') }}">
                                <input type="hidden" name="apoteker_id" value="{{ request('apoteker_id') }}">

                                <button type="submit"
                                    class="btn btn-danger bg-red-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-red-700 focus:ring-4 focus:ring-red-500"
                                    target="_blank">
                                    <i class='bx bxs-file-pdf'></i> Export PDF
                                </button>
                                </form>
                                </div>
                                </div>

                                <!-- Active filters display -->
                                @if(request('search') || request('start_date') || request('end_date') || request('sales_id') || request('apoteker_id'))
                                    <div class="alert alert-info mb-3">
                                        <strong>Filter Aktif:</strong>
                                        @if(request('search'))
                                            <span class="badge bg-primary me-2">No Faktur: {{ request('search') }}</span>
                                        @endif
                                        @if(request('start_date') && request('end_date'))
                                            <span class="badge bg-primary me-2">Periode: {{ request('start_date') }} s/d {{ request('end_date') }}</span>
                                        @elseif(request('start_date'))
                                            <span class="badge bg-primary me-2">Dari Tanggal: {{ request('start_date') }}</span>
                                        @elseif(request('end_date'))
                                            <span class="badge bg-primary me-2">Sampai Tanggal: {{ request('end_date') }}</span>
                                        @endif
                                        @if(request('sales_id'))
                                            <span class="badge bg-primary me-2">Sales:
                                                {{ $salesList->where('id_sales', request('sales_id'))->first()->NamaSales ?? '' }}</span>
                                        @endif
                                        @if(request('apoteker_id'))
                                            <span class="badge bg-primary me-2">Apoteker:
                                                {{ $apotekerList->where('id', request('apoteker_id'))->first()->Nama ?? '' }}</span>
                                        @endif
                                        <a href="{{ route('obat-masuk.index') }}" class="btn btn-sm btn-outline-danger">Reset Filter</a>
                                    </div>
                                @endif

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
                                            @forelse ($transaksi as $index => $item)
                                                <tr class="border-t">
                                                    <td class="px-4 py-2 text-base">{{ $transaksi->firstItem() + $index }}</td>
                                                    <td class="px-4 py-2 text-base">{{ $item->NoFaktur }}</td>
                                                    <td class="px-4 py-2 text-base">{{ date('d-m-Y', strtotime($item->TglFaktur)) }}</td>
                                                    <td class="px-4 py-2 text-base">{{ date('H:i', strtotime($item->Waktu)) }}</td>
                                                    <td class="px-4 py-2 text-base">{{ date('d-m-Y', strtotime($item->TglJatuhTempo)) }}</td>
                                                    <td class="px-4 py-2 text-base">{{ $item->sales->NamaSales ?? '-' }}</td>
                                                    <td class="px-4 py-2 text-base">{{ $item->apoteker->Nama ?? '-' }}</td>
                                                    <td class="px-4 py-2 text-base">{{ $item->detailTransaksi->sum('qty') }}</td>
                                                    <td class="px-4 py-2 text-base">
                                                        @php
                                                            $harga = 0;
                                                            foreach ($item->detailTransaksi as $detail) {
                                                                $harga += $detail->HargaBeli * $detail->qty;
                                                            }
                                                        @endphp
                                                        Rp {{ number_format($harga, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-2 text-base">
                                                        <a href="{{ route('obat-masuk.show', $item->NoFaktur) }}"
                                                            class="action-btn view-btn text-green-500 hover:text-green-700 mr-2">
                                                            <i class='bx bx-show'></i>
                                                        </a>
                                                        <a href="{{ route('obat-masuk.edit', $item->NoFaktur) }}"
                                                            class="action-btn edit-btn text-blue-500 hover:text-blue-700 mr-2">
                                                            <i class='bx bx-edit'></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="px-4 py-2 text-center text-base">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                                    <tfoot>
                                                        <tr class="bg-light">
                                                            <td colspan="8" class="px-4 py-2 text-right font-semibold">Total Keseluruhan:</td>
                                                            <td class="px-4 py-2 font-semibold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                    </table>
                                                    </div>

                                                    <!-- Pagination -->
                                                    <div class="pagination-container mt-4 mb-4">
                                                        <nav aria-label="Page navigation">
                                                            {{ $transaksi->appends(request()->query())->links() }}
                                                            </nav>
                                                            </div>
                                                            </div>
                                                            </div>

                                                    <!-- Filter Modal -->
                                                    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="filterModalLabel">Filter Data Obat Masuk</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="{{ route('obat-masuk.index') }}" method="GET">
                                                                    <div class="modal-body">
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-6">
                                                                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                                                                <input type="date" class="form-control" id="start_date" name="start_date"
                                                                                    value="{{ request('start_date') }}">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                                                                <input type="date" class="form-control" id="end_date" name="end_date"
                                                                                    value="{{ request('end_date') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-6">
                                                                                <label for="sales_id" class="form-label">Sales</label>
                                                                                <select class="form-select" id="sales_id" name="sales_id">
                                                                                    <option value="">Semua Sales</option>
                                                                                    @foreach($salesList as $sales)
                                                                                        <option value="{{ $sales->id_sales }}" {{ request('sales_id') == $sales->id_sales ? 'selected' : '' }}>
                                                                                            {{ $sales->NamaSales }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="apoteker_id" class="form-label">Apoteker</label>
                                                                                <select class="form-select" id="apoteker_id" name="apoteker_id">
                                                                                    <option value="">Semua Apoteker</option>
                                                                                    @foreach($apotekerList as $apoteker)
                                                                                        <option value="{{ $apoteker->id }}" {{ request('apoteker_id') == $apoteker->id ? 'selected' : '' }}>
                                                                                            {{ $apoteker->Nama }}
                                                                                        </option>
                                                                                    @endforeach
                                                            </select>
                                                            </div>
                                                            </div>
                                                            <!-- Keep the search value if it exists -->
                                                            @if(request('search'))
                                                                <input type="hidden" name="search" value="{{ request('search') }}">
                                                            @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="{{ route('obat-masuk.index') }}" class="btn btn-secondary">Reset</a>
                                                                <button type="submit"
                                                                    class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">Terapkan
                                                                    Filter</button>
                                                            </div>
                                                            </form>
                                                            </div>
                                                            </div>
                                                            </div>

                                </div>


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize popovers or tooltips if needed
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush