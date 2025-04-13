@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="content-table">
            <!-- Tombol Tambah -->
            <div class="btn-tambah mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
                    <i class='bx bx-plus'></i> Tambah User
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ url('/config_user') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control me-2" type="search" name="search"
                                placeholder="Cari berdasarkan username atau role" aria-label="Search"
                                value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tabel User -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID User</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->role_id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>******</td>
                            <td>
                                <button type="button" class="action-btn delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal" data-username="{{ $user->username }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-container">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/config_user/store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="role" class="form-label">Jabatan</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="Dokter">Dokter</option>
                                <option value="Apoteker">Apoteker</option>
                                <option value="Pimpinan">Pimpinan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus user ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Modal Delete -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangani klik tombol delete
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const username = this.getAttribute('data-username');
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action = `/config_user/${username}`;
                });
            });
        });
    </script>
@endsection
