<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi Pembelian - {{ $transaksi->NoFaktur }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #2563eb;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        .info-section {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
        }

        .info-column {
            flex: 1;
            min-width: 300px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .label {
            font-weight: bold;
            color: #4b5563;
            display: inline-block;
            width: 150px;
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

        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 8px;
            text-align: left;
        }

        .total-row {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        h2 {
            color: #2563eb;
            font-size: 16px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        @page {
            size: A4;
            margin: 1cm;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DETAIL TRANSAKSI PEMBELIAN OBAT</h1>
        <p>Tanggal Cetak: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <div class="info-section">
        <div class="info-column">
            <div class="info-item">
                <span class="label">Nomor Faktur:</span>
                <span>{{ $transaksi->NoFaktur }}</span>
            </div>
            <div class="info-item">
                <span class="label">Tanggal Faktur:</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->TglFaktur)->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <span class="label">Waktu:</span>
                <span>{{ $transaksi->Waktu }}</span>
            </div>
        </div>
        <div class="info-column">
            <div class="info-item">
                <span class="label">Tanggal Jatuh Tempo:</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->TglJatuhTempo)->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <span class="label">Sales:</span>
                <span>{{ $transaksi->sales->NamaSales ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Apoteker:</span>
                <span>{{ $transaksi->apoteker->Nama ?? '-' }}</span>
            </div>
        </div>
    </div>

    <h2>Daftar Obat</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Qty</th>
                <th>Harga Beli</th>
                <th>Potongan</th>
                <th>Potongan Cash</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->id_obat }}</td>
                    <td>{{ $detail->NamaObat }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp. {{ number_format($detail->HargaBeli, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($detail->BesarPotongan, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($detail->PotCash, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="7" style="text-align: right;">Total Keseluruhan</td>
                <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>
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