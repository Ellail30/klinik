@extends('layouts.app')

@section('title', 'Daftar Obat')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="content-table">
        <!-- Tombol Tambah -->
        <div class="btn-tambah mb-3">
            <button class="btn btn-primary py-3 px-6 text-lg font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500" data-bs-toggle="modal" data-bs-target="#tambahObatModal">
                <i class='bx bx-plus'></i> Tambah Obat
            </button>
        </div>

        <div class="row mb-3">
            <!-- Search di sebelah kiri -->
            <div class="col-md-6">
                <form action="{{ url('/obat') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control me-2" type="search" name="search" placeholder="Cari berdasarkan kode obat atau nama" aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <div class="col-md-6 text-end">
                <form action="{{ url('/obat') }}" method="GET">
                    <!-- Sorting Dropdown -->
                    <div class="relative inline-block text-left">
                        <!-- Button to Toggle Dropdown -->
                        <button type="button" id="dropdownSortButton" class="inline-flex justify-center items-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 hover:bg-blue-700 focus:ring-offset-2 focus:ring-offset-blue-200">
                            <i class="bx bx-sort mr-2"></i> Sorting
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu" class="absolute right-0 z-10 mt-2 origin-top-right bg-white rounded-md shadow-lg w-48 ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                            <div class="py-1">
                                <!-- Sorting Options -->
                                <button type="submit" name="sort_by" value="NamaObat_asc" class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none" title="Urutkan A-Z">
                                    <i class="bx bx-sort-a-z mr-2"></i> Urutkan A-Z
                                </button>
                                <button type="submit" name="sort_by" value="NamaObat_desc" class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none" title="Urutkan Z-A">
                                    <i class="bx bx-sort-z-a mr-2"></i> Urutkan Z-A
                                </button>
                                <button type="submit" name="sort_by" value="TglExp_asc" class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none" title="Tanggal Expired Ascending">
                                    <i class="bx bx-calendar mr-2"></i> Tanggal Expired Ascending
                                </button>
                                <button type="submit" name="sort_by" value="HargaBeli_asc" class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none" title="Harga Beli Terendah">
                                    <i class="bx bx-chevron-up mr-2"></i> Harga Beli Terendah
                                </button>
                                <button type="submit" name="sort_by" value="HargaBeli_desc" class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none" title="Harga Beli Tertinggi">
                                    <i class="bx bx-chevron-down mr-2"></i> Harga Beli Tertinggi
                                </button>
                                <button type="submit" name="sort_by" value="Satuan" class="text-blue-600 block px-4 py-2 text-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none" title="Urutkan Berdasarkan Satuan">
                                    <i class="bx bx-capsule mr-2"></i> Urutkan Berdasarkan Satuan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Obat -->
        <div class="overflow-x-auto">
            <table class="table table-striped min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-base font-semibold">No</th>
                        <th class="px-4 py-2 text-left text-base font-semibold">Kode Obat</th>
                        <th class="px-4 py-2 text-left text-base font-semibold">Nama Obat</th>
                        <th class="px-4 py-2 text-left text-base font-semibold">Satuan</th>
                        <th class="px-4 py-2 text-left text-base font-semibold">Stok</th>
                        <th class="px-4 py-2 text-left text-base font-semibold">TglExp</th>
                        <th class="px-4 py-2 text-left text-base font-semibold">NoBatch</th>
                        <th class="px-4 py-2 text-left text-base font-semibold">Harga Beli</th>
                        <th class="px-4 py-2 text-left text-base font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obat as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-base">{{ $obat->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-2 text-base">{{ $item->id_obat }}</td>
                            <td class="px-4 py-2 text-base">{{ $item->NamaObat }}</td>
                            <td class="px-4 py-2 text-base">{{ $item->Satuan }}</td>
                            <td class="px-4 py-2 text-base">{{ $item->stok }}</td>
                            <td class="px-4 py-2 text-base">{{ \Carbon\Carbon::parse($item->TglExp)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-base">{{ $item->NoBatch }}</td>
                            <td class="px-4 py-2 text-base">{{ $item->HargaBeli }}</td>
                            <td class="px-4 py-2 text-base">
                                <button class="action-btn edit-btn text-blue-500 hover:text-blue-700" data-bs-toggle="modal" data-bs-target="#editObatModal" data-id="{{ $item->id_obat }}">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="action-btn delete-btn text-red-500 hover:text-red-700" data-bs-toggle="modal" data-id="{{ $item->id_obat }}" data-name="{{ $item->NamaObat }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container mt-4 mb-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-start">
                    <!-- Previous Button -->
                    <li class="page-item {{ $obat->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $obat->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <!-- Pagination Links -->
                    @foreach ($obat->getUrlRange(1, $obat->lastPage()) as $page => $url)
                        <li class="page-item {{ $obat->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach

                    <!-- Next Button -->
                    <li class="page-item {{ !$obat->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $obat->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>










    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="tambahObatModal" tabindex="-1" aria-labelledby="tambahObatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white shadow-lg rounded-lg max-w-lg mx-auto">
                <div class="modal-header border-b border-gray-200">
                    <h5 class="modal-title text-xl font-semibold text-blue-600" id="tambahObatModalLabel">Tambah Obat Baru
                    </h5>
                    <button type="button" class="btn-close text-blue-600 hover:text-blue-800" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <form action="{{ url('/obat/store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="id_obat" class="block text-sm font-medium text-gray-700">Kode Obat</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="id_obat" name="id_obat" required>
                        </div>
                        <div class="mb-4">
                            <label for="NamaObat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="NamaObat" name="NamaObat" required>
                        </div>
                        <div class="mb-4">
                            <label for="Satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                            <select
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="Satuan" name="Satuan" required>
                                <option value="BOTOL">BOTOL</option>
                                <option value="TUBE">TUBE</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="stok" name="stok" required>
                        </div>
                        <div class="mb-4">
                            <label for="TglEXP" class="block text-sm font-medium text-gray-700">Tanggal Expired</label>
                            <input type="date"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="TglEXP" name="TglEXP" required>
                        </div>
                        <div class="mb-4">
                            <label for="NoBatch" class="block text-sm font-medium text-gray-700">NoBatch</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="NoBatch" name="NoBatch" required>
                        </div>
                        <div class="mb-4">
                            <label for="HargaBeli" class="block text-sm font-medium text-gray-700">Harga Beli</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="HargaBeli" name="HargaBeli" required>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                class="btn btn-secondary bg-transparent border-2 border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm hover:bg-blue-600 hover:text-white focus:ring-4 focus:ring-blue-500"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit"
                                class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Obat -->
    <div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white shadow-lg rounded-lg max-w-lg mx-auto">
                <div class="modal-header border-b border-gray-200">
                    <h5 class="modal-title text-xl font-semibold text-blue-600" id="editObatModalLabel">Edit Obat</h5>
                    <button type="button" class="btn-close text-blue-600 hover:text-blue-800" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <form id="editObatForm" action="{{ route('obat.update', ['id' => ':id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editObatId" name="id_obat">
                        <div class="mb-4">
                            <label for="NamaObat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editNamaObat" name="NamaObat" required>
                        </div>
                        <div class="mb-4">
                            <label for="Satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                            <select
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editSatuan" name="Satuan" required>
                                <option value="BOTOL">BOTOL</option>
                                <option value="TUBE">TUBE</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editStok" name="stok" required>
                        </div>
                        <div class="mb-4">
                            <label for="TglEXP" class="block text-sm font-medium text-gray-700">Tanggal Expired</label>
                            <input type="date"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editTglEXP" name="TglEXP" required>
                        </div>
                        <div class="mb-4">
                            <label for="NoBatch" class="block text-sm font-medium text-gray-700">NoBatch</label>
                            <input type="text"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editNoBatch" name="NoBatch" required>
                        </div>
                        <div class="mb-4">
                            <label for="HargaBeli" class="block text-sm font-medium text-gray-700">Harga Beli</label>
                            <input type="number"
                                class="form-control mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                id="editHargaBeli" name="HargaBeli" required>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                class="btn btn-secondary bg-transparent border-2 border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm hover:bg-blue-600 hover:text-white focus:ring-4 focus:ring-blue-500"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit"
                                class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <script>
        // JavaScript to Toggle Dropdown Visibility
        const dropdownButton = document.getElementById('dropdownSortButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', () => {
            // Toggle the 'hidden' class to show/hide the dropdown menu with smooth transitions
            dropdownMenu.classList.toggle('hidden');
            dropdownMenu.classList.toggle('scale-95');
        });

        // Close the dropdown if the user clicks outside
        window.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownMenu.classList.add('scale-95');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Check if there's a session success message to show a notification
            @if (session('success'))
                Swal.fire({
                    title: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#007bff',  // Blue color for 'Ok' button
                });
            @endif

            // Check if there's a validation error message for duplicate data
            @if ($errors->has('id_obat'))
                Swal.fire({
                    title: 'Gagal! Kode Obat sudah ada.',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#007bff',  // Blue color for 'Ok' button
                });
            @endif

            // Handle Delete Button
            const deleteBtns = document.querySelectorAll('.delete-btn');
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const obatId = btn.getAttribute('data-id');
                    const obatName = btn.getAttribute('data-name');
                    Swal.fire({
                        title: `Apakah Anda yakin ingin menghapus obat "${obatName}"?`,
                        text: "Tindakan ini tidak dapat dibatalkan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#007bff',  // Blue color for 'Ya, Hapus!' button
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/obat/${obatId}`;
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

            // Handle Edit Button
            const editBtns = document.querySelectorAll('.edit-btn');
            editBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const obatId = btn.getAttribute('data-id');
                    fetch(`/obat/${obatId}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('editObatId').value = data.id_obat;
                            document.getElementById('editNamaObat').value = data.NamaObat;
                            document.getElementById('editSatuan').value = data.Satuan;
                            document.getElementById('editStok').value = data.stok;
                            document.getElementById('editTglEXP').value = data.TglExp;
                            document.getElementById('editNoBatch').value = data.NoBatch;
                            document.getElementById('editHargaBeli').value = data.HargaBeli;
                            const formAction = `/obat/update/${obatId}`;
                            document.getElementById('editObatForm').action = formAction;
                        })
                        .catch(error => console.error('Error fetching drug data:', error));
                });
            });

            // Handle form submission for updating drug
            document.getElementById('editObatForm').addEventListener('submit', function(e) {
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
                                title: 'Obat ' + data.NamaObat + ' berhasil diperbarui!',
                                icon: 'success',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#007bff',  // Blue color for 'Ok' button
                            }).then(() => {
                                location.reload();
                            });
                        } else if (data.error) {
                            Swal.fire({
                                title: data.error,
                                icon: 'error',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#007bff',  // Blue color for 'Ok' button
                            });
                        }
                    })
                    .catch(error => console.error('Error updating drug:', error));
            });
        });
    </script>



    <!-- Sertakan JS untuk modal dan interaksi lainnya -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
