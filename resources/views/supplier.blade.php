@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-table">
            <!-- Tombol Tambah -->
            <div class="btn-tambah mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSupplierModal">
                    <i class='bx bx-plus'></i> Tambah Supplier
                </button>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ url('/supplier') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control me-2" type="search" name="search" placeholder="Cari supplier"
                                aria-label="Search" value="{{ request('search') }}">
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
                                    <button class="action-btn edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editSupplierModal" data-id="{{ $supplier->id_supplier }}"
                                        data-nama="{{ $supplier->NamaSupplier }}" data-npwp="{{ $supplier->NPWP }}"
                                        data-noijin="{{ $supplier->NoIjinPBF }}" data-alamat="{{ $supplier->Alamat }}">
                                        <i class='bx bx-edit'></i>
                                    </button>

                                    <button class="action-btn delete-btn btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal" data-id="{{ $supplier->id_supplier }}">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1"
                                        aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi
                                                        Penghapusan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus supplier ini?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-dismiss="modal">Tidak</button>
                                                    <form id="deleteForm" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-success" type="submit">Ya</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', () => {
                                            const deleteBtns = document.querySelectorAll('.delete-btn'); // Pilih semua tombol hapus
                                            const deleteForm = document.getElementById('deleteForm'); // Form dalam modal

                                            deleteBtns.forEach(btn => {
                                                btn.addEventListener('click', () => {
                                                    const supplierId = btn.getAttribute('data-id'); // Ambil ID supplier dari tombol
                                                    deleteForm.action =
                                                    `/supplier/${supplierId}`; // Update action form dengan ID yang sesuai
                                                });
                                            });
                                        });
                                    </script>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">Data tidak ditemukan.</td>
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

    <!-- Modal Tambah Supplier -->
    <div class="modal fade" id="tambahSupplierModal" tabindex="-1" aria-labelledby="tambahSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSupplierModalLabel">Tambah Supplier Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/supplier/store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_supplier" class="form-label">Kode Supplier</label>
                            <input type="text" class="form-control" id="id_supplier" name="id_supplier" required>
                        </div>
                        <div class="mb-3">
                            <label for="NamaSupplier" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="NamaSupplier" name="NamaSupplier" required>
                        </div>
                        <div class="mb-3">
                            <label for="NPWP" class="form-label">NPWP</label>
                            <input type="text" class="form-control" id="NPWP" name="NPWP" required>
                        </div>
                        <div class="mb-3">
                            <label for="NoIjinPBF" class="form-label">No Ijin PBF</label>
                            <input type="number" class="form-control" id="NoIjinPBF" name="NoIjinPBF" required>
                        </div>
                        <div class="mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="Alamat" name="Alamat" required>
                        </div>
                        <button class="btn btn-outline-primary" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Supplier -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSupplierForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editNamaSupplier" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="editNamaSupplier" name="NamaSupplier"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editNPWP" class="form-label">NPWP</label>
                            <input type="text" class="form-control" id="editNPWP" name="NPWP" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNoIjinPBF" class="form-label">No Ijin PBF</label>
                            <input type="number" class="form-control" id="editNoIjinPBF" name="NoIjinPBF" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="editAlamat" name="Alamat" required>
                        </div>
                        <button class="btn btn-outline-primary" type="submit">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editModal = document.getElementById('editSupplierModal');
            const editForm = document.getElementById('editSupplierForm');

            editModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const npwp = button.getAttribute('data-npwp');
                const noijin = button.getAttribute('data-noijin');
                const alamat = button.getAttribute('data-alamat');

                editForm.action = `/supplier/${id}`;
                document.getElementById('editNamaSupplier').value = nama;
                document.getElementById('editNPWP').value = npwp;
                document.getElementById('editNoIjinPBF').value = noijin;
                document.getElementById('editAlamat').value = alamat;
            });
        });
    </script>
@endsection
