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
            <div class="col-md-6 text-end">
                <form action="{{ url('/supplier') }}" method="GET">
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
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
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
                        <label for="editSupplierId" class="form-label">Kode Supplier</label>
                        <input type="text" class="form-control" id="editSupplierId" name="id_supplier" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNamaSupplier" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="editNamaSupplier" name="NamaSupplier" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNPWP" class="form-label">NPWP</label>
                        <input type="text" class="form-control" id="editNPWP" name="npwp" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNoIjinPBF" class="form-label">No Ijin PBF</label>
                        <input type="number" class="form-control" id="editNoIjinPBF" name="NoIjinPBF" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAlamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="editAlamat" name="alamat" required>
                    </div>
                    <button class="btn btn-outline-primary" type="submit">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

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
            @if ($errors->has('id_supplier'))
                Swal.fire({
                    title: 'Gagal! Kode Supplier sudah ada.',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#007bff', // Blue color for 'Ok' button
                });
            @endif

            // Handle Delete Button
            const deleteBtns = document.querySelectorAll('.delete-btn');
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const supplierId = btn.getAttribute('data-id');
                    const supplierName = btn.getAttribute('data-name');
                    Swal.fire({
                        title: `Apakah Anda yakin ingin menghapus supplier "${supplierName}"?`,
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
                            form.action = `/supplier/${supplierId}`;  // Fixed route URL to delete supplier
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

           document.addEventListener('DOMContentLoaded', () => {
    // Handle Edit Button
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const supplierId = btn.getAttribute('data-id');
            fetch(`/supplier/${supplierId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        // Fill the form with data
                        document.getElementById('editSupplierId').value = data.id;  // Ensure the 'id' field is filled
                        document.getElementById('editNamaSupplier').value = data.NamaSupplier;
                        document.getElementById('editNPWP').value = data.npwp;
                        document.getElementById('editNoIjinPBF').value = data.NoIjinPBF;
                        document.getElementById('editAlamat').value = data.alamat;

                        // Update the form's action URL
                        const formAction = `/supplier/update/${supplierId}`;
                        document.getElementById('editSupplierForm').action = formAction;

                        // Open the modal
                        $('#editSupplierModal').modal('show');
                    } else {
                        Swal.fire({
                            title: 'Error fetching data.',
                            icon: 'error',
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#007bff',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching supplier data:', error);
                    Swal.fire({
                        title: 'Error fetching data.',
                        icon: 'error',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#007bff',
                    });
                });
        });
    });

    // Handle form submission for updating supplier
    document.getElementById('editSupplierForm').addEventListener('submit', function(e) {
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
                    title: 'Supplier ' + data.NamaSupplier + ' berhasil diperbarui!',
                    icon: 'success',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#007bff',
                }).then(() => {
                    location.reload();  // Reload the page to show updated data
                });
            } else {
                Swal.fire({
                    title: data.error || 'An error occurred while updating supplier.',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#007bff',
                });
            }
        })
        .catch(error => {
            console.error('Error updating supplier:', error);
            Swal.fire({
                title: 'An error occurred while updating supplier.',
                icon: 'error',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#007bff',
            });
        });
    });
});

        });
    </script>

@endsection
