@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-table">
            <!-- Tombol Tambah -->
            <div class="btn-tambah mb-3">
                <!-- Tombol untuk menambah supplier yang membuka modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSupplierModal">
                    <i class='bx bx-plus'></i> Tambah Supplier
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ url('/supplier') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control me-2" type="search" name="search"
                                placeholder="Cari berdasarkan nama atau kode supplier" aria-label="Search"
                                value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Supplier -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>NPWP</th>
                        <th>No Ijin PBF</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($suppliers->count())
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                                <td>{{ $supplier->id_supplier }}</td>
                                <td>{{ $supplier->NamaSupplier }}</td>
                                <td>{{ $supplier->NPWP }}</td>
                                <td>{{ $supplier->NoIjinPBF }}</td>
                                <td>{{ $supplier->Alamat }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button class="action-btn edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editSupplierModal" data-id="{{ $supplier->id_supplier }}">
                                        <i class='bx bx-edit'></i>
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('supplier.destroy', $supplier->id_supplier) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination-container">
                {{ $suppliers->links('pagination::bootstrap-4') }}
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
