@extends('layouts.app')
@section('title', 'Detail Resep')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-4">Detail Resep Obat</h1>

            {{-- Pasien Information --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-gray-600">Nama Pasien</p>
                    <p class="font-semibold">{{ $resep->pemeriksaan->kunjungan->pasien->NamaPasien }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Nomor Rekam Medis (NRM)</p>
                    <p class="font-semibold">{{ $resep->pemeriksaan->kunjungan->pasien->Nrm }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Dokter Pemeriksa</p>
                    <p class="font-semibold">{{ $resep->pemeriksaan->dokter->Nama }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Tanggal Resep</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($resep->TanggalResep)->format('d M Y') }}</p>
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
                        @foreach($resep->detailResep as $index => $detail)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $detail->obat->NamaObat }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($detail->obat->HargaJual, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right">{{ $detail->Jumlah }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($detail->obat->HargaJual * $detail->Jumlah, 0, ',', '.') }}</td>
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

            {{-- Pembayaran Form --}}
            @if($resep->Status != 'Sudah Diambil')
                <form action="{{ route('apoteker.simpanPembayaran', $resep->IdResep) }}" method="POST" class="bg-gray-50 p-4 rounded-md">
                    @csrf
                    <h2 class="text-xl font-semibold mb-4">Proses Pembayaran</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2" for="total_bayar">Total Bayar</label>
                            <input type="number" name="total_bayar" id="total_bayar" 
                                   min="{{ $totalHarga }}" 
                                   value="{{ $totalHarga }}"
                                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2" for="keterangan">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" id="keterangan" 
                                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">
                            Simpan Pembayaran
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-green-50 border border-green-200 p-4 rounded-md">
                    <p class="text-green-700">Resep sudah diambil pada {{ \Carbon\Carbon::parse($resep->updated_at)->format('d M Y H:i') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection