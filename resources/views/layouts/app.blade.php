<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.css" rel="stylesheet" />

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
            padding: 40px;
            margin-left: 64px;
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
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('layouts.navbar')

            @include('layouts.sidebar')
        </div>
        <!-- Konten -->
        @yield('content')
    </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
