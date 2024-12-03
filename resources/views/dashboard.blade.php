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
        /* Sidebar */
        .sidebar {
            min-height: 120vh;
            background: linear-gradient(to top, #49A8E8 10%, #247ADC 100%);
            padding: 5px;
            text-align: center; /* Pusatkan konten */
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

        /* Panel Selamat Datang */
        .welcome-panel {
            background: linear-gradient(to right, #247ADC 80%, #49A8E8 100%, #9CD2ED 100%);
            color: white;
            text-align: center;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .content {
            padding: 20px;
        }

        /* Konten utama */
        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="logo">
                    <img src="public\images\clinic.png" alt="clinic">
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
                <!-- Panel Selamat Datang -->
                <div class="welcome-panel">
                        <p style="font-weight: bold;">
                            SELAMAT DATANG DI SISTEM INFORMASI <br>
                            PENGENDALIAN OBAT KLINIK PKU <br>
                            MUHAMMADIYAH BERBAH
                        </p>

                </div>

                <!-- Dashboard Content -->
                <div class="dashboard-header">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
