<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obat</title>
    <!-- Sertakan Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Sertakan Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        /* Sidebar */
        .sidebar {
            min-height: 120vh;
            background: linear-gradient(to top, #49A8E8 10%, #247ADC 100%);
            padding: 5px;
            text-align: center;
            /* Pusatkan konten */
        }

        .logo img {
            width: 100px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 10px;
            align-items: center;
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 20px;
        }

        .sidebar a:hover {
            background-color: rgb(11, 180, 226, 0.5);
        }

        .content-table {
            background: whitesmoke;
            color: #49A8E8;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .content {
            padding: 20px;
        }

        /* Konten utama */
        .obat-header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
        }

        /* Styling Tabel */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th {
            background-color: #ffffff;
        }

        .action-btn {
            cursor: pointer;
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 5px;
        }

        .edit-btn {
            background-color: #247ADC;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .action-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="logo">
                    <img src="images/clinic.png" alt="clinic">
                </div>
                <a href="{{ url('/dashboard') }}">
                    <i class='bx bxs-dashboard'></i> Dashboard
                </a>
                <a href="#">
                    <i class='bx bxs-cog'></i> Config User
                </a>
                <a href="{{ url('/obat') }}">
                    <i class='bx bxs-capsule'></i> Obat
                </a>
                <a href="#">
                    <i class='bx bx-cart-alt'></i> Supplier
                </a>
                <a href="{{ url('/pasien') }}">
                    <i class='bx bxs-user'></i> Pasien
                </a>
                <a href="{{ url('/obat_keluar') }}">
                    <i class='bx bxs-log-out'></i> Obat Keluar
                </a>
                <a href="#">
                    <i class='bx bxs-lock-alt'></i> Change Password
                </a>
                <a href="{{ url('/obat_kadaluwarsa') }}">
                    <i class='bx bxs-error'></i> Obat Kedaluwarsa
                </a>
                <a href="{{ url('/laporan_keluar') }}">
                    <i class='bx bxs-file'></i> Laporan Obat Keluar
                </a>
                <a href="{{ url('/laporan_masuk') }}">
                    <i class='bx bxs-file-plus'></i> Laporan Obat Masuk
                </a>
                <a href="{{ url('/laporan_persediaan') }}">
                    <i class='bx bxs-box'></i> Laporan Persediaan
                </a>
            </div>

            <!-- Konten -->
            <div class="col-md-10 content">
                <div class="content-table">
                    <!-- Tombol Tambah -->
                    <div class="btn-tambah mb-3">
                        <h2>Obat</h2>
                        <!-- Tombol untuk menambah obat yang membuka modal -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahObatModal">
                            <i class='bx bx-plus'></i> Tambah Obat
                        </button>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ url('/obat') }}" method="GET">
                                <div class="input-group">
                                    <input class="form-control me-2" type="search" name="search"
                                        placeholder="Cari berdasarkan satuan atau kode obat" aria-label="Search" value="{{ request('search') }}">
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
                                <th>Kode Obat</th>
                                <th>Nama Obat</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>TglExp</th>
                                <th>NoBatch</th>
                                <th>Harga Beli</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obat as $item)
                                <tr>
                                    <td>{{ $obat->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->id_obat }}</td>
                                    <td>{{ $item->NamaObat }}</td>
                                    <td>{{ $item->Satuan }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->TglExp)->format('d/m/Y') }}</td>
                                    <td>{{ $item->NoBatch }}</td>
                                    <td>{{ $item->HargaBeli }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="action-btn edit-btn" data-bs-toggle="modal"
                                            data-bs-target="#editObatModal" data-id="{{ $item->id_obat }}">
                                            <i class='bx bx-edit'></i>
                                        </button>

                                        <!-- Tombol Delete -->
                                        <form action="{{ route('obat.destroy', $item->id_obat) }}" method="POST"
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
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="pagination-container">
                        {{ $obat->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="tambahObatModal" tabindex="-1" aria-labelledby="tambahObatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahObatModalLabel">Tambah Obat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/obat/store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_obat" class="form-label">Kode Obat</label>
                            <input type="text" class="form-control" id="id_obat" name="id_obat" required>
                        </div>
                        <div class="mb-3">
                            <label for="NamaObat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="NamaObat" name="NamaObat" required>
                        </div>
                        <div class="mb-3">
                            <label for="Satuan" class="form-label">Satuan</label>
                            <select class="form-control" id="Satuan" name="Satuan" required>
                                <option value="BOTOL">BOTOL</option>
                                <option value="TUBE">TUBE</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="TglEXP" class="form-label">Tanggal Expired</label>
                            <input type="date" class="form-control" id="TglEXP" name="TglEXP" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">NoBatch</label>
                            <input type="text" class="form-control" id="NoBatch" name="NoBatch" required>
                        </div>
                        <div class="mb-3">
                            <label for="HargaBeli" class="form-label">Harga Beli</label>
                            <input type="number" class="form-control" id="HargaBeli" name="HargaBeli" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Obat -->
    <div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editObatModalLabel">Edit Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('obat.update', $item->id_obat) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Menentukan request menggunakan method PUT -->

                        <div class="mb-3">
                            <label for="id_obat" class="form-label">Kode Obat</label>
                            <input type="text" class="form-control" id="id_obat" name="id_obat" required
                                disabled value="{{ old('id_obat', $item->id_obat ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="NamaObat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="NamaObat" name="NamaObat"
                                value="{{ $item->NamaObat }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="Satuan" class="form-label">Satuan</label>
                            <select class="form-control" id="Satuan" name="Satuan" required>
                                <option value="BOTOL" {{ $item->Satuan == 'BOTOL' ? 'selected' : '' }}>BOTOL</option>
                                <option value="TUBE" {{ $item->Satuan == 'TUBE' ? 'selected' : '' }}>TUBE</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="editstok" name="stok"
                                value="{{ $item->stok }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="TglExp" class="form-label">Tanggal Expired</label>
                            <input type="date" class="form-control" id="TglEXP" name="TglExp"
                                value="{{ $item->TglExp }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="NoBatch" class="form-label">NoBatch</label>
                            <input type="text" class="form-control" id="NoBatch" name="NoBatch"
                                value="{{ $item->NoBatch }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="HargaBeli" class="form-label">Harga Beli</label>
                            <input type="number" class="form-control" id="HargaBeli" name="HargaBeli"
                                value="{{ $item->HargaBeli }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Sertakan JS untuk modal dan interaksi lainnya -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
