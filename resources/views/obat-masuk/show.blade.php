@extends('layouts.app')

@section('title', 'Detail Transaksi Pembelian')

@section('content')

    <div class="p-4 sm:ml-64">
        <div class="content-detail">
            <!-- Header Transaksi -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-blue-600">Detail Transaksi Pembelian</h2>
                    <a href="{{ route('obat-masuk.detail.export', urlencode($transaksi->NoFaktur)) }}"
                        class="btn btn-danger bg-red-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-red-700 focus:ring-4 focus:ring-red-500">
                        <i class='bx bxs-file-pdf'></i> Export PDF
                    </a>


                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 font-semibold">Nomor Faktur:
                            <span class="text-black">{{ $transaksi->NoFaktur }}</span>
                        </p>
                        <p class="text-gray-600 font-semibold">Tanggal Faktur:
                            <span
                                class="text-black">{{ \Carbon\Carbon::parse($transaksi->TglFaktur)->format('d/m/Y') }}</span>
                        </p>
                        <p class="text-gray-600 font-semibold">Waktu:
                            <span class="text-black">{{ $transaksi->Waktu }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-semibold">Tanggal Jatuh Tempo:
                            <span
                                class="text-black">{{ \Carbon\Carbon::parse($transaksi->TglJatuhTempo)->format('d/m/Y') }}</span>
                        </p>
                        <p class="text-gray-600 font-semibold">Sales:
                            <span class="text-black">{{ $transaksi->NamaSales }}</span>
                        </p>
                        <p class="text-gray-600 font-semibold">Apoteker:
                            <span class="text-black">{{ $transaksi->Nama }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Detail Obat -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold text-blue-600 mb-4">Daftar Obat</h3>

                <div class="overflow-x-auto">
                    <table class="table table-striped min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-base font-semibold">No</th>
                                <th class="px-4 py-2 text-left text-base font-semibold">Kode Obat</th>
                                <th class="px-4 py-2 text-left text-base font-semibold">Nama Obat</th>
                                <th class="px-4 py-2 text-left text-base font-semibold">Qty</th>
                                <th class="px-4 py-2 text-left text-base font-semibold">Harga Beli</th>
                                <th class="px-4 py-2 text-left text-base font-semibold">Potongan</th>
                                <th class="px-4 py-2 text-left text-base font-semibold">Potongan Cash</th>
                                <th class="px-4 py-2 text-left text-base font-semibold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $index => $detail)
                                <tr class="border-t">
                                    <td class="px-4 py-2 text-base">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 text-base">{{ $detail->id_obat }}</td>
                                    <td class="px-4 py-2 text-base">{{ $detail->NamaObat }}</td>
                                    <td class="px-4 py-2 text-base">{{ $detail->qty }}</td>
                                    <td class="px-4 py-2 text-base">Rp.
                                        {{ number_format($detail->HargaBeli, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-base">Rp.
                                        {{ number_format($detail->BesarPotongan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-base">Rp. {{ number_format($detail->PotCash, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-base">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-100 font-bold">
                            <tr>
                                <td colspan="7" class="px-4 py-2 text-right text-base">Total Keseluruhan</td>
                                <td class="px-4 py-2 text-base">Rp. {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 mt-6">

                <a href="{{ route('obat-masuk.index') }}"
                class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">
                Kembali
                </a>

                {{-- <button class="action-btn delete-btn text-red-500 hover:text-red-700"
                    data-route="{{ route('obat-masuk.destroy', $transaksi->NoFaktur) }}"
                    data-name="{{ $transaksi->NoFaktur }}" data-type="transaksi pembelian">
                    <i class='bx bx-trash mr-2'></i>Hapus Transaksi
                </button> --}}
            </div>

        </div>
    </div>


@endsection
