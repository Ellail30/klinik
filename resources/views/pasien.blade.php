@extends('layouts.app')

@section('title', 'Daftar Pasien')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-table">
            <!-- Tombol Tambah -->
            <div class="btn-tambah mb-3">
                <!-- Tombol untuk menambah pasien yang membuka modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPasienModal">
                    <i class='bx bx-plus'></i> Tambah Pasien
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ url('/pasien') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control me-2" type="search" name="search"
                                placeholder="Cari berdasarkan nama dan alamat" aria-label="Search"
                                value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Pasien -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>NRM</th>
                        <th>Nama Pasien</th>
                        <th>Umur</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasien as $item)
                        <tr>
                            <td>{{ $pasien->firstItem() + $loop->index }}</td>
                            <td>{{ $item->Nik }}</td>
                            <td>{{ $item->Nrm }}</td>
                            <td>{{ $item->NamaPasien }}</td>
                            <td>{{ $item->Umur }}</td>
                            <td>{{ $item->Alamat }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <button class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editPasienModal"
                                    data-id="{{ $item->Nik }}">
                                    <i class='bx bx-edit'></i>
                                </button>

                                <!-- Tombol Delete -->
                                <form action="{{ route('pasien.destroy', $item->Nik) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn delete-btn" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal" data-id="{{ $item->Nik }}">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade" id="confirmDeleteModal" tabindex="-1"
                                    aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data ini?
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
                                    // Menangkap tombol hapus dan mengupdate action form
                                    var deleteBtns = document.querySelectorAll('.delete-btn');
                                    deleteBtns.forEach(function(btn) {
                                        btn.addEventListener('click', function(event) {
                                            var pasienId = event.target.closest('button').getAttribute('data-id');
                                            var form = document.getElementById('deleteForm');
                                            form.action = '/pasien/' + pasienId;
                                        });
                                    });
                                </script>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination-container">
                {{ $pasien->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="tambahPasienModal" tabindex="-1" aria-labelledby="tambahPasienModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPasienModalLabel">Tambah Pasien Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/pasien/store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="Nik" class="form-label">NIK</label>
                            <input type="number" class="form-control" id="Nik" name="Nik" required>
                        </div>
                        <div class="mb-3">
                            <label for="Nrm" class="form-label">NRM</label>
                            <input type="text" class="form-control" id="Nrm" name="Nrm" required>
                        </div>
                        <div class="mb-3">
                            <label for="NamaPasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="NamaPasien" name="NamaPasien" required>
                        </div>
                        <div class="mb-3">
                            <label for="Umur" class="form-label">Umur</label>
                            <input type="number" class="form-control" id="Umur" name="Umur" required>
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
    <!-- Modal Edit Pasien -->
    <div class="modal fade" id="editPasienModal" tabindex="-1" aria-labelledby="editPasienModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasienModalLabel">Edit Data Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pasien.update', $item->Nik) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Menentukan request menggunakan method PUT -->

                        <div class="mb-3">
                            <label for="Nik" class="form-label">NIK</label>
                            <input type="number" class="form-control" id="Nik" name="Nik" required disabled
                                value="{{ old('Nik', $item->Nik ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="Nrm" class="form-label">NRM</label>
                            <input type="text" class="form-control" id="Nrm" name="Nrm"
                                value="{{ $item->Nrm }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="NamaPasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="NamaPasien" name="NamaPasien"
                                value="{{ $item->NamaPasien }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="Umur" class="form-label">Umur</label>
                            <input type="number" class="form-control" id="Umur" name="Umur"
                                value="{{ $item->Umur }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="Alamat" name="Alamat"
                                value="{{ $item->Alamat }}" required>
                        </div>
                        <button class="btn btn-outline-primary" type="submit">Simpan perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Sertakan JS untuk modal dan interaksi lainnya -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
