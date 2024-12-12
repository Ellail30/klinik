@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-table">
            <!-- Tombol Tambah -->
            <div class="btn-tambah mb-3">
                <!-- Tombol untuk menambah obat yang membuka modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahObatModal">
                    <i class='bx bx-plus'></i> Tambah User
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ url('/config_user') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control me-2" type="search" name="search"
                                placeholder="Cari berdasarkan satuan atau kode User" aria-label="Search"
                                value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Obat -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($supplier as $item) --}}
                    <tr>
                        <td>1</td>
                        <td>Adellakusayang123</td>
                        <td>Pimpinan</td>
                        <td>Password123.</td>
                        {{-- <td>
                            <!-- Tombol Edit -->
                            <button class="action-btn edit-btn" data-bs-toggle="modal"
                                data-bs-target="#editObatModal" data-id="{{ $item->id_supplier }}">
                                <i class='bx bx-edit'></i>
                            </button>

                            <!-- Tombol Delete -->
                            <form action="{{ route('supplier.destroy', $item->id_supplier) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination-container">
                {{-- {{ $supplier->links('pagination::bootstrap-4') }} --}}
            </div>
        </div>
    </div>




    <!-- Sertakan JS untuk modal dan interaksi lainnya -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
