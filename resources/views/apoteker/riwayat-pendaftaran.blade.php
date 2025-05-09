@extends('layouts.app')
@section('title', 'Bukti Pembayaran')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">Bukti Pembayaran Resep</h1>
                <p class="text-gray-600">No. {{ $pembayaran->IdPembayaran }}</p>
            </div>

            {{-- Pasien Information --}}
            <div class="grid grid-cols-2 gap-4 mb-6 border-b pb-4">
                <div>
                    <p class="text-gray-600">Nama Pasien</p>
                    <p class="font-semibold">{{ $pembayaran->resep->pemeriksaan->kunjungan->pasien->NamaPasien }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Nomor Rekam Medis (NRM)</p>
                    <p class="font-semibold">{{ $pembayaran->resep->pemeriksaan->kunjungan->pasien->Nrm }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Tanggal Pembayaran</p>
                    <p class="font-semibold">
                        {{ \Carbon\Carbon::parse($pembayaran->TanggalPembayaran)->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Apoteker</p>
                    <p class="font-semibold">{{ $pembayaran->apoteker->Nama }}</p>
                </div>
            </div>

            {{-- Obat Table --}}
            <div class="overflow-x-auto mb-6">
                <table class="w-full bg-white border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Nama Obat</th>
                            <th class="px-4 py-2 text-right">Harga Satuan</th>
                            <th class="px-4 py-2 text-right">Jumlah</th>
                            <th class="px-4 py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalHarga = 0; @endphp
                        @foreach ($pembayaran->resep->detailResep as $index => $detail)
                            @php
                                $subtotal = $detail->obat->HargaJual * $detail->Jumlah;
                                $totalHarga += $subtotal;
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $detail->obat->NamaObat }}</td>
                                <td class="px-4 py-2 text-right">Rp
                                    {{ number_format($detail->obat->HargaJual, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right">{{ $detail->Jumlah }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 font-bold">
                            <td colspan="4" class="px-4 py-2 text-right">Total</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Pembayaran Details --}}
            <div class="bg-gray-50 p-4 rounded-md">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Total Bayar</p>
                        <p class="font-semibold text-green-600">Rp
                            {{ number_format($pembayaran->TotalBayar, 0, ',', '.') }}</p>
                    </div>
                    @if ($pembayaran->Keterangan)
                        <div>
                            <p class="text-gray-600">Keterangan</p>
                            <p class="font-semibold">{{ $pembayaran->Keterangan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-6 flex justify-between">
                <button onclick="window.print()"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                    Cetak Bukti
                </button>
                <a href="{{ route('apoteker.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300">
                    Kembali ke Daftar Resep
                </a>
            </div>
        </div>
    </div>

    {{-- Print-specific Styles --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-container,
            .print-container * {
                visibility: visible;
            }

            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
@endsection
