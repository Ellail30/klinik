@extends('layouts.app')
@section('title', 'Antrian Pasien')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 rounded-lg">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Antrian Pasien - Poli {{ $poli }}</h1>

            <form action="{{ route('dokter.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Pasien</label>
                    <input type="text" name="search" id="search" placeholder="Nama/NRM/No. Antrian"
                        value="{{ request('search') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
                </div>
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </form>


            {{-- @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <p>{{ session('error') }}</p>
                </div>
            @endif --}}

            <div class="overflow-x-auto bg-white rounded-lg mt-2">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.
                                Antrian</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NRM
                            </th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Pasien</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                                Kelamin</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umur
                            </th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Keluhan</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($antrians as $antrian)
                            <tr>
                                <td class="py-3 px-4">{{ $antrian->NomorAntrian }}</td>
                                <td class="py-3 px-4">{{ $antrian->Nrm }}</td>
                                <td class="py-3 px-4">{{ $antrian->NamaPasien }}</td>
                                <td class="py-3 px-4">{{ $antrian->JenisKelamin }}</td>
                                <td class="py-3 px-4">
                                    {{ \Carbon\Carbon::parse($antrian->TanggalLahir)->age }} Tahun
                                </td>
                                <td class="py-3 px-4">{{ Str::limit($antrian->Keluhan, 50) }}</td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                        {{ $antrian->Status == 'Antri' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $antrian->Status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if ($antrian->Status == 'Antri')
                                        <a href="{{ route('dokter.panggilPasien', $antrian->IdKunjungan) }}"
                                            class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            Panggil
                                        </a>
                                    @elseif($antrian->Status == 'Dipanggil')
                                        <a href="{{ route('dokter.formPemeriksaan', $antrian->IdKunjungan) }}"
                                            class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                            Periksa
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-6 px-4 text-center text-gray-500">
                                    Tidak ada data antrian pasien
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
