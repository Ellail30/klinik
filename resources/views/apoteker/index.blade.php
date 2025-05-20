@extends('layouts.app')
@section('title', 'Daftar Resep Obat')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl text-black font-semibold mb-4">Daftar Resep Obat</h1>

            {{-- Search and Filter Section --}}
            <form action="{{ route('apoteker.index') }}" method="GET" class="mb-4">
                <div class="flex space-x-4">
                    {{-- Search Input --}}
                    <div class="flex-grow">
                        <input type="text" name="search" placeholder="Cari Nama Pasien, NRM, atau ID Resep" 
                               value="{{ request('search') }}" 
                               class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Status Filter --}}
                    <select name="status" class="px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="Belum Diambil" {{ request('status') == 'Belum Diambil' ? 'selected' : '' }}>Belum Diambil</option>
                        <option value="Sudah Diambil" {{ request('status') == 'Sudah Diambil' ? 'selected' : '' }}>Sudah Diambil</option>
                    </select>

                    {{-- Date Filter --}}
                    <input type="date" name="tanggal" 
                           value="{{ request('tanggal') }}" 
                           class="px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                    {{-- Search Button --}}
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Resep Table --}}
            {{-- Resep Table --}}
            <div class="overflow-x-auto">
                <table class="w-full bg-white border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">NRM</th>
                            <th class="px-4 py-2 text-left">Nama Pasien</th>
                            <th class="px-4 py-2 text-left">ID Resep</th>
                            <th class="px-4 py-2 text-left">Tanggal Resep</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-right">Total Bayar</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reseps as $index => $resep)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $resep->Nrm }}</td>
                                <td class="px-4 py-2">{{ $resep->NamaPasien }}</td>
                                <td class="px-4 py-2">{{ $resep->IdResep }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($resep->TanggalResep)->format('d M Y') }}</td>
                                <td class="px-4 py-2">
                                    <span class="{{ $resep->Status == 'Belum Diambil' ? 'text-yellow-600' : 'text-green-600' }}">
                                        {{ $resep->Status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($resep->TotalBayar, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('apoteker.detailResep', $resep->IdResep) }}" class="text-blue-500 hover:text-blue-700 font-medium">
                                        Detail
                                    </a>
                                    </td>
                                    </tr>
                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-gray-500">
                                                Tidak ada resep ditemukan
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50 font-bold">
                                            <td colspan="6" class="px-4 py-3 text-right">Total Keseluruhan:</td>
                                            <td class="px-4 py-3 text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                    </table>
                                    </div>

                                    {{-- Export Button --}}
                                    <div class="mt-4 flex justify-end">
                                        <a href="{{ route('obat-keluar.export', ['search' => request('search'), 'status' => request('status'), 'tanggal' => request('tanggal')]) }}"
                                            class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300 flex items-center"
                                            target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Export PDF
                                        </a>
                                    </div>
        </div>
    </div>
@endsection