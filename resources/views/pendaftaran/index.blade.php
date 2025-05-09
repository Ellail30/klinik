@extends('layouts.app')
@section('title', 'Pendaftaran Pasien')
@section('content')
    {{-- <div class="container mx-auto px-4 py-6"> --}}
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">@yield('title')</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <form action="{{ route('pendaftaran.cari') }}" method="GET" class="flex items-center">
                    <input type="text" name="query" placeholder="Cari Pasien (NIK/Nama/NRM)"
                        class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 transition duration-300">
                        Cari
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-100 p-4 rounded-md text-center">
                    <h2 class="text-xl font-semibold mb-4">Pasien Baru</h2>
                    <a href="{{ route('pendaftaran.create') }}"
                        class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition duration-300 inline-block">
                        Daftar Pasien Baru
                    </a>
                </div>

                <div class="bg-gray-100 p-4 rounded-md">
                    <h2 class="text-xl font-semibold mb-4 text-center">Statistik Hari Ini</h2>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div>
                            <div class="font-bold text-2xl text-blue-600">{{ $kunjunganHariIni->count() }}</div>
                            <div class="text-sm text-gray-600">Total Pasien</div>
                        </div>
                        <div>
                            <div class="font-bold text-2xl text-yellow-600">
                                {{ $kunjunganHariIni->where('Status', 'Antri')->count() }}</div>
                            <div class="text-sm text-gray-600">Antri</div>
                        </div>
                        <div>
                            <div class="font-bold text-2xl text-green-600">
                                {{ $kunjunganHariIni->where('Status', 'Selesai')->count() }}</div>
                            <div class="text-sm text-gray-600">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="bg-gray-100 p-4 rounded-md mt-6 overflow-x-auto"> --}}
                <table class="w-full">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm">
                        <tr>
                            <th class="py-3 px-4 border-b">Jam Kunjungan</th>
                            <th class="py-3 px-4 border-b">NIK</th>
                            <th class="py-3 px-4 border-b">Nama Pasien</th>
                            <th class="py-3 px-4 border-b">Nomor Antrian</th>
                            <th class="py-3 px-4 border-b">Poli</th>
                            <th class="py-3 px-4 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjunganHariIni as $kunjungan)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b">
                                    {{ \Carbon\Carbon::parse($kunjungan->TanggalKunjungan)->format('H:i') }}</td>
                                <td class="py-2 px-4 border-b">{{ $kunjungan->pasien->Nik ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border-b">{{ $kunjungan->pasien->NamaPasien ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border-b">{{ $kunjungan->NomorAntrian }}</td>
                                <td class="py-2 px-4 border-b">{{ $kunjungan->Poli }}</td>
                                @php
                                    $statusClasses = [
                                        'Menunggu' => 'text-yellow-600 font-semibold',
                                        'Dipanggil' => 'text-blue-600 font-semibold',
                                        'Lewat' => 'text-red-600 font-semibold',
                                        'Selesai' => 'text-green-600 font-semibold',
                                        'Antri' => 'text-yellow-600 font-semibold',
                                        'Diperiksa' => 'text-indigo-600 font-semibold',
                                        'Batal' => 'text-gray-600 font-semibold',
                                    ];
                                    $statusClass = $statusClasses[$kunjungan->Status] ?? 'text-gray-600';
                                @endphp
                                <td class="py-2 px-4 border-b {{ $statusClass }}">{{ $kunjungan->Status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">Tidak ada kunjungan hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            {{-- </div> --}}



        </div>
    </div>
@endsection
