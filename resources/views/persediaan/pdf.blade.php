<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Daftar Obat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .summary-item p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 11px;
        }

        table td {
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .kondisi-stok {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }

        .stok-aman {
            background-color: #d4edda;
            color: #155724;
        }

        .harus-restock {
            background-color: #f8d7da;
            color: #721c24;
        }

        .kondisi-expired {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }

        .expired {
            background-color: #f8d7da;
            color: #721c24;
        }

        .akan-expired {
            background-color: #fff3cd;
            color: #856404;
        }

        .aman {
            background-color: #d4edda;
            color: #155724;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }

        tfoot {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DAFTAR OBAT</h1>
        <p>Laporan Data Obat</p>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <h3>{{ $obats->count() }}</h3>
            <p>Total Item Obat</p>
        </div>
        <div class="summary-item">
            <h3>{{ number_format($totalStok) }}</h3>
            <p>Total Stok</p>
        </div>
        <div class="summary-item">
            <h3>Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</h3>
            <p>Total Nilai Stok</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="8%">ID Obat</th>
                <th width="15%">Nama Obat</th>
                <th width="8%">Tgl Expired</th>
                <th width="8%">No Batch</th>
                <th width="6%">Satuan</th>
                <th width="8%">Harga Beli</th>
                <th width="8%">Harga Jual</th>
                <th width="5%">Stok</th>
                <th width="5%">Min</th>
                <th width="8%">Kondisi Stok</th>
                <th width="8%">Kondisi Exp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obats as $index => $obat)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $obat->id_obat }}</td>
                    <td>{{ $obat->NamaObat }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($obat->TglExp)->format('d/m/Y') }}</td>
                    <td>{{ $obat->NoBatch }}</td>
                    <td class="text-center">{{ $obat->Satuan }}</td>
                    <td class="text-right">{{ number_format($obat->HargaBeli, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($obat->HargaJual, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($obat->stok) }}</td>
                    <td class="text-right">{{ number_format($obat->StokMinimum) }}</td>
                    <td class="text-center">
                        <span
                            class="kondisi-stok {{ $obat->kondisi_stok == 'Harus Restock' ? 'harus-restock' : 'stok-aman' }}">
                            {{ $obat->kondisi_stok }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="kondisi-expired 
                                @if($obat->kondisi_expired == 'Expired')
                                    expired
                                @elseif($obat->kondisi_expired == 'Akan Expired')
                                    akan-expired
                                @else
                                    aman
                                @endif">
                            {{ $obat->kondisi_expired }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" class="text-right"><strong>TOTAL:</strong></td>
                <td class="text-right"><strong>{{ number_format($totalStok) }}</strong></td>
                <td colspan="3" class="text-right"><strong>Nilai: Rp
                        {{ number_format($totalNilaiStok, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>

    </div>
</body>

</html>