<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Resep Obat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .filter-info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .grand-total {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }

        .report-date {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN RESEP OBAT</h1>
        <p>{{ $currentDate }}</p>
    </div>

    <div class="filter-info">
        <p><strong>Filter:</strong> {{ $filterText }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NRM</th>
                <th>Nama Pasien</th>
                <th>ID Resep</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th class="text-right">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reseps as $index => $resep)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $resep->Nrm }}</td>
                    <td>{{ $resep->NamaPasien }}</td>
                    <td>{{ $resep->IdResep }}</td>
                    <td>{{ \Carbon\Carbon::parse($resep->TanggalResep)->format('d M Y') }}</td>
                    <td>{{ $resep->Status }}</td>
                    <td class="text-right">Rp {{ number_format($resep->TotalBayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada resep ditemukan</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="grand-total">
                <td colspan="6" class="text-right">Total Keseluruhan</td>
                <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p class="report-date">Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
        <p>{{ auth()->user()->name ?? 'Petugas Apotek' }}</p>
    </div>
</body>

</html>