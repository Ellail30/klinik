<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Obat Masuk</title>
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
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .total-row {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        @page {
            size: A4;
            margin: 1cm;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN DATA OBAT MASUK</h1>
        <p>Periode: {{ request('start_date') ? date('d-m-Y', strtotime(request('start_date'))) : 'Semua' }}
            {{ request('end_date') ? 's/d ' . date('d-m-Y', strtotime(request('end_date'))) : '' }}
        </p>
        <p>Tanggal Cetak: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Faktur</th>
                <th>Tanggal Faktur</th>
                <th>Jatuh Tempo</th>
                <th>Sales</th>
                <th>Apoteker</th>
                <th>Total Item</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->NoFaktur }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->TglFaktur)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->TglJatuhTempo)) }}</td>
                    <td>{{ $item->sales->NamaSales ?? '-' }}</td>
                    <td>{{ $item->apoteker->Nama ?? '-' }}</td>
                    <td>{{ $item->detailTransaksi->sum('qty') }}</td>
                    <td>
                        @php
                            $harga = 0;
                            foreach ($item->detailTransaksi as $detail) {
                                $harga += $detail->HargaBeli * $detail->qty;
                            }
                        @endphp
                        Rp {{ number_format($harga, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">Total Keseluruhan:</td>
                <td>{{ $transaksi->sum(function ($item) {
    return $item->detailTransaksi->sum('qty'); }) }}</td>
                <td>Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>
            Sleman, {{ date('d F Y') }}<br><br><br><br>
            (_____________________)<br>
        </p>
    </div>
</body>

</html>