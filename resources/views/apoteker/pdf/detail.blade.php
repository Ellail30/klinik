<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Resep {{ $resep->IdResep }}</title>
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
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .info-container {
            margin-bottom: 20px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .info-row {
            display: table-row;
        }

        .info-cell {
            display: table-cell;
            padding: 5px 0;
            width: 50%;
        }

        .info-label {
            color: #666;
            font-size: 11px;
        }

        .info-value {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-completed {
            background-color: #D4EDDA;
            color: #155724;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DETAIL RESEP OBAT</h1>
        <p>{{ $currentDate }}</p>
    </div>

    <div class="info-container">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">ID Resep</div>
                    <div class="info-value">{{ $resep->IdResep }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span
                            class="status {{ $resep->Status == 'Belum Diambil' ? 'status-pending' : 'status-completed' }}">
                            {{ $resep->Status }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Nama Pasien</div>
                    <div class="info-value">{{ $resep->pemeriksaan->kunjungan->pasien->NamaPasien }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Nomor Rekam Medis</div>
                    <div class="info-value">{{ $resep->pemeriksaan->kunjungan->pasien->Nrm }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Dokter Pemeriksa</div>
                    <div class="info-value">{{ $resep->pemeriksaan->dokter->Nama }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Tanggal Resep</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($resep->TanggalResep)->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Waktu Konsumsi</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resep->detailResep as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->obat->NamaObat }}</td>
                    <td>{{ $detail->Dosis }}</td>
                    <td>{{ $detail->WaktuKonsumsi ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($detail->HargaSatuan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $detail->Jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($detail->HargaSatuan * $detail->Jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right">Total</td>
                <td class="text-right">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @if($resep->Status == 'Sudah Diambil')
        <div
            style="padding: 10px; background-color: #D4EDDA; border: 1px solid #C3E6CB; color: #155724; border-radius: 5px;">
            <p>Resep ini sudah diambil pada {{ \Carbon\Carbon::parse($resep->updated_at)->format('d M Y H:i') }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
        <p>{{ auth()->user()->name ?? 'Petugas Apotek' }}</p>
    </div>
</body>

</html>