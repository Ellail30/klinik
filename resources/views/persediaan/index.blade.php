@extends('layouts.app')
@section('title', 'Laporan Persediian')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl text-black font-semibold">Daftar Obat</h1>
                <a href="{{ route('persediaan.export-pdf', request()->query()) }}"
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">
                    <i class='bx bxs-file-pdf'></i> Export PDF
                </a>
            </div>

            {{-- Search and Filter Section --}}
            <form action="{{ route('obat.index') }}" method="GET" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-4">
                    {{-- Search Input --}}
                    <div class="col-span-1 md:col-span-2">
                        <input type="text" name="search" placeholder="Cari ID Obat, Nama Obat, atau No Batch"
                            value="{{ request('search') }}"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Satuan Filter --}}
                    <div>
                        <select name="satuan"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Satuan</option>
                            <option value="TABLET" {{ request('satuan') == 'TABLET' ? 'selected' : '' }}>Tablet</option>
                            <option value="KAPSUL" {{ request('satuan') == 'KAPSUL' ? 'selected' : '' }}>Kapsul</option>
                            <option value="KAPLET" {{ request('satuan') == 'KAPLET' ? 'selected' : '' }}>Kaplet</option>
                            <option value="PIL" {{ request('satuan') == 'PIL' ? 'selected' : '' }}>Pil</option>
                            <option value="BUTIR" {{ request('satuan') == 'BUTIR' ? 'selected' : '' }}>Butir</option>
                            <option value="STRIP" {{ request('satuan') == 'STRIP' ? 'selected' : '' }}>Strip</option>
                            <option value="BOTOL" {{ request('satuan') == 'BOTOL' ? 'selected' : '' }}>Botol</option>
                            <option value="TUBE" {{ request('satuan') == 'TUBE' ? 'selected' : '' }}>Tube</option>
                            <option value="SACHET" {{ request('satuan') == 'SACHET' ? 'selected' : '' }}>Sachet</option>
                            <option value="AMPUL" {{ request('satuan') == 'AMPUL' ? 'selected' : '' }}>Ampul</option>
                            <option value="VIAL" {{ request('satuan') == 'VIAL' ? 'selected' : '' }}>Vial</option>
                            <option value="ML" {{ request('satuan') == 'ML' ? 'selected' : '' }}>ML</option>
                            <option value="LITER" {{ request('satuan') == 'LITER' ? 'selected' : '' }}>Liter</option>
                            <option value="TETES" {{ request('satuan') == 'TETES' ? 'selected' : '' }}>Tetes</option>
                            <option value="GRAM" {{ request('satuan') == 'GRAM' ? 'selected' : '' }}>Gram</option>
                            <option value="DOSIS" {{ request('satuan') == 'DOSIS' ? 'selected' : '' }}>Dosis</option>
                        </select>
                    </div>

                    {{-- Kondisi Stok Filter --}}
                    <div>
                        <select name="kondisi_stok"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kondisi Stok</option>
                            <option value="harus_restock" {{ request('kondisi_stok') == 'harus_restock' ? 'selected' : '' }}>
                                Harus Restock</option>
                            <option value="stok_aman" {{ request('kondisi_stok') == 'stok_aman' ? 'selected' : '' }}>Stok Aman
                            </option>
                        </select>
                    </div>

                    {{-- Kondisi Expired Filter --}}
                    <div>
                        <select name="kondisi_expired"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kondisi Expired</option>
                            <option value="expired" {{ request('kondisi_expired') == 'expired' ? 'selected' : '' }}>Expired
                            </option>
                            <option value="akan_expired" {{ request('kondisi_expired') == 'akan_expired' ? 'selected' : '' }}>
                                Akan Expired</option>
                            <option value="aman" {{ request('kondisi_expired') == 'aman' ? 'selected' : '' }}>Aman</option>
                        </select>
                    </div>

                    {{-- Search Button --}}
                    <div>
                        <button type="submit"
                            class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                            <i class='bx bx-search'></i> Cari
                        </button>
                    </div>
                </div>

                {{-- Date Range Filter --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Expired Dari</label>
                        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Expired Sampai</label>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end">
                        <a href="{{ route('obat.index') }}"
                            class="w-full bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300 text-center">
                            <i class='bx bx-refresh'></i> Reset Filter
                        </a>
                    </div>
                </div>
            </form>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-500 rounded-lg">
                            <i class='bx bx-package text-white text-xl'></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Item Obat</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $obats->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-500 rounded-lg">
                            <i class='bx bx-chart text-white text-xl'></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Total Stok</p>
                            <p class="text-2xl font-bold text-green-900">{{ number_format($totalStok) }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-500 rounded-lg">
                            <i class='bx bx-money text-white text-xl'></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-yellow-600">Total Nilai Stok</p>
                            <p class="text-2xl font-bold text-yellow-900">Rp
                                {{ number_format($totalNilaiStok, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Obat Table --}}
            <div class="overflow-x-auto">
                <table class="w-full bg-white border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">ID Obat</th>
                            <th class="px-4 py-2 text-left">Nama Obat</th>
                            <th class="px-4 py-2 text-left">Tanggal Expired</th>
                            <th class="px-4 py-2 text-left">No Batch</th>
                            <th class="px-4 py-2 text-left">Satuan</th>
                            <th class="px-4 py-2 text-right">Harga Beli</th>
                            <th class="px-4 py-2 text-right">Harga Jual</th>
                            <th class="px-4 py-2 text-right">Stok</th>
                            <th class="px-4 py-2 text-right">Stok Minimum</th>
                            <th class="px-4 py-2 text-center">Kondisi Stok</th>
                            <th class="px-4 py-2 text-center">Kondisi Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obats as $index => $obat)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-mono">{{ $obat->id_obat }}</td>
                                <td class="px-4 py-2 font-medium">{{ $obat->NamaObat }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($obat->TglExp)->format('d M Y') }}</td>
                                <td class="px-4 py-2 font-mono">{{ $obat->NoBatch }}</td>
                                <td class="px-4 py-2">{{ $obat->Satuan }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($obat->HargaBeli, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($obat->HargaJual, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right font-bold">{{ number_format($obat->stok) }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($obat->StokMinimum) }}</td>
                                <td class="px-4 py-2 text-center">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium
                                                {{ $obat->kondisi_stok == 'Harus Restock' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $obat->kondisi_stok }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                                @if($obat->kondisi_expired == 'Expired')
                                                    bg-red-100 text-red-800
                                                @elseif($obat->kondisi_expired == 'Akan Expired')
                                                    bg-yellow-100 text-yellow-800
                                                @else
                                                    bg-green-100 text-green-800
                                                @endif">
                                        {{ $obat->kondisi_expired }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center py-8 text-gray-500">
                                    <i class='bx bx-package text-4xl mb-2'></i>
                                    <p>Tidak ada data obat ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($obats->count() > 0)
                        <tfoot>
                            <tr class="bg-gray-50 font-bold">
                                <td colspan="8" class="px-4 py-3 text-right">Total:</td>
                                <td class="px-4 py-3 text-right">{{ number_format($totalStok) }}</td>
                                <td colspan="3" class="px-4 py-3 text-right">Nilai: Rp
                                    {{ number_format($totalNilaiStok, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <style>
        .action-btn {
            display: inline-block;
            padding: 0.25rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection