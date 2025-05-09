@extends('layouts.app')
@section('title', 'Detail Pasien')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="grid md:grid-cols-2 gap-6">
            {{-- Profil Pasien --}}
            <div class="md:col-span-1 bg-white shadow-md rounded-lg p-6">
                <div class="text-center mb-6">
                    <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-4xl text-gray-500">
                            {{ substr($pasien->NamaPasien, 0, 1) }}
                        </span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $pasien->NamaPasien }}</h2>
                    <p class="text-gray-600">NRM: {{ $pasien->Nrm }}</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <span class="font-medium text-gray-600">NIK:</span>
                        <span class="text-gray-800">{{ $pasien->Nik }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Jenis Kelamin:</span>
                        <span class="text-gray-800">{{ $pasien->JenisKelamin }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Tempat, Tanggal Lahir:</span>
                        <span class="text-gray-800">
                            {{ $pasien->TempatLahir }},
                            {{ $pasien->TanggalLahir ? \Carbon\Carbon::parse($pasien->TanggalLahir)->format('d F Y') : '-' }}
                        </span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Umur:</span>
                        <span class="text-gray-800">{{ $pasien->Umur }} Tahun</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Golongan Darah:</span>
                        <span class="text-gray-800">{{ $pasien->GolonganDarah ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Status Pernikahan:</span>
                        <span class="text-gray-800">{{ $pasien->StatusPernikahan ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Agama:</span>
                        <span class="text-gray-800">{{ $pasien->Agama ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-6 flex space-x-2">
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('pasien.edit', $pasien->Nrm) }}"
                            class="w-full text-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                            Edit Profil
                        </a>
                        <a href="{{ route('pendaftaran.daftar-ulang', $pasien->Nrm) }}"
                            class="w-full text-center bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                            Daftar Ulang
                        </a>
                    @endif
                </div>
            </div>

            {{-- Statistik dan Riwayat Kunjungan --}}
            <div class="md:col-span-4 space-y-6">
                {{-- Statistik Kunjungan --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Kunjungan</h2>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="bg-gray-100 p-4 rounded-md text-center">
                            <div class="text-3xl font-bold text-blue-600">
                                {{ $statistikKunjungan['total'] }}
                            </div>
                            <div class="text-gray-600">Total Kunjungan</div>
                        </div>
                        @foreach ($statistikKunjungan['perPoli'] as $poli => $jumlah)
                            <div class="bg-gray-100 p-4 rounded-md text-center">
                                <div class="text-3xl font-bold text-green-600">
                                    {{ $jumlah }}
                                </div>
                                <div class="text-gray-600">Poli {{ $poli }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Riwayat Kunjungan per Tahun --}}
                @foreach ($kunjunganByYear as $tahun => $kunjungan)
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Riwayat Kunjungan {{ $tahun }}</h2>
                            <a href="{{ route('pasien.riwayat-kunjungan', $pasien->Nrm) }}"
                                class="text-blue-500 hover:text-blue-600">
                                Lihat Semua
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-200 text-gray-600">
                                    <tr>
                                        <th class="py-2 px-4 text-left">Tanggal</th>
                                        <th class="py-2 px-4 text-left">Poli</th>
                                        <th class="py-2 px-4 text-left">Keluhan</th>
                                        <th class="py-2 px-4 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kunjungan->take(5) as $item)
                                        <tr class="border-b hover:bg-gray-100">
                                            <td class="py-2 px-4">
                                                {{ \Carbon\Carbon::parse($item->TanggalKunjungan)->format('d F Y') }}
                                            </td>
                                            <td class="py-2 px-4">{{ $item->Poli }}</td>
                                            <td class="py-2 px-4">{{ $item->Keluhan }}</td>
                                            <td class="py-2 px-4">
                                                <span
                                                    class="
                                                @if ($item->Status == 'Selesai') text-green-600
                                                @elseif($item->Status == 'Antri') text-yellow-600
                                                @elseif($item->Status == 'Batal') text-red-600
                                                @else text-blue-600 @endif
                                            ">
                                                    {{ $item->Status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
