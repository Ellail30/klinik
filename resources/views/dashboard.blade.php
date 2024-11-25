<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Sertakan Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Sertakan Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 200vh;
            background-color: #1d82ca;
            padding: 15px;
            text-align: center; /* Pusatkan konten */
        }

        .logo img {
            width: 150px; /* Lebar logo */
            height: auto; /* Menjaga proporsi gambar */
            margin-bottom: 15px;
            border-radius: 10px; /* Opsional, membuat sudut melengkung */
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar a i {
            margin-right: 10px;
            /* Jarak antara ikon dan teks */
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: rgb(11, 180, 226);
        }

        .content {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <!-- Logo -->
                <div class="logo">
                    <img src="images/clinic.png" alt="clinic">
                </div>
                <!-- Navigasi -->
                <a href="{{ url('/dashboard') }}">
                    <i class='bx bxs-dashboard'></i> Dashboard
                </a>
                <a href="{{ url('/obat') }}">
                    <i class='bx bxs-capsule'></i> Obat
                </a>
                <a href="{{ url('/pasien') }}">
                    <i class='bx bxs-user'></i> Pasien
                </a>
                <a href="#">
                    <i class='bx bxs-cog'></i> Config User
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
                <h1>Selamat Datang di Dashboard</h1>
            </div>
        </div>
    </div>
</body>

</html>
