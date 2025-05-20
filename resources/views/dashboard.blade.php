@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Sidebar --}}
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-5 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="p-4 sm:ml-64">
        {{-- Welcome Jumbotron --}}
        <section class="bg-blue-500 rounded-xl dark:bg-gray-900">
            <div class="py-8 px-6 mx-auto max-w-screen-xl text-center lg:py-16">
                <h1
                    class="mb-2 text-xl font-bold text-white tracking-tight leading-none md:text-3xl lg:text-4xl dark:text-white">
                    Selamat Datang di Sistem Informasi Pengendalian Obat</h1>
                <p class="text-lg font-bold text-white lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">
                    Klinik PKU Muhammadiyah Berbah</p>
            </div>
        </section>

        {{-- Statistics --}}
        @if (Auth::user()->role == 'apoteker')
            <section>
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
                    <p class="text-gray-600">Overview statistik dan peringatan sistem</p>
                </div>
            
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                    <!-- Card 1: Total Pembelian -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md p-3 bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Total Pembelian</h2>
                                <p class="text-xl font-semibold text-gray-800">{{ number_format($totalPembelian) }}</p>
                            </div>
                        </div>
                    </div>
            
                    <!-- Card 2: Total Penjualan -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md p-3 bg-green-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Total Penjualan</h2>
                                <p class="text-xl font-semibold text-gray-800">{{ number_format($totalPenjualan) }}</p>
                            </div>
                        </div>
                    </div>
            
                    <!-- Card 3: Total Revenue -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md p-3 bg-yellow-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Total Pendapatan</h2>
                                <p class="text-xl font-semibold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
            
                    <!-- Card 4: Total Items Out -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md p-3 bg-indigo-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Barang Keluar</h2>
                                <p class="text-xl font-semibold text-gray-800">{{ number_format($totalBarangKeluar) }}</p>
                            </div>
                        </div>
                    </div>
            
                    <!-- Card 5: Expired Items -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md p-3 bg-red-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Total Kadaluarsa</h2>
                                <p class="text-xl font-semibold text-gray-800">{{ number_format($totalKadaluarsa) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Expiring Medications Table -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Obat Hampir Kadaluarsa</h3>
                        <p class="mt-1 text-sm text-gray-500">Daftar obat yang akan kadaluarsa dalam 3 bulan ke depan</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Obat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kadaluarsa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Waktu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($expiringMeds as $obat)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $obat->id_obat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $obat->NamaObat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($obat->TglExp)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($obat->TglExp), false);
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $daysLeft <= 30 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $daysLeft }} hari
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $obat->stok }} {{ $obat->Satuan }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">Tidak ada obat yang akan kadaluarsa dalam 3 bulan kedepan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            
                <!-- Low Stock Medications Table -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Obat Stok Menipis</h3>
                        <p class="mt-1 text-sm text-gray-500">Daftar obat yang memerlukan restok segera</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Obat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Minimum</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($lowStockMeds as $obat)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $obat->id_obat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $obat->NamaObat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $obat->stok }} {{ $obat->Satuan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $obat->StokMinumum }} {{ $obat->Satuan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $percentage = ($obat->stok / $obat->StokMinumum) * 100;
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $percentage <= 50 ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800' }}">
                                            Perlu Restok
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">Tidak ada obat yang memerlukan restok</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Statistik Utama --}}
                <div class="bg-white shadow-md rounded-lg p-6 col-span-2">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Kunjungan</h2>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="bg-blue-100 p-4 rounded-md">
                            <div class="text-3xl font-bold text-blue-600">
                                {{ $totalPasien }}
                            </div>
                            <div class="text-gray-600">Total Pasien</div>
                        </div>
                        <div class="bg-green-100 p-4 rounded-md">
                            <div class="text-3xl font-bold text-green-600">
                                {{ $pasienBaruBulanIni }}
                            </div>
                            <div class="text-gray-600">Pasien Baru Bulan Ini</div>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-md">
                            <div class="text-3xl font-bold text-purple-600">
                                {{ $kunjunganHarian->sum('total') }}
                            </div>
                            <div class="text-gray-600">Kunjungan Hari Ini</div>
                        </div>
                    </div>

                    {{-- Grafik Kunjungan --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Grafik Kunjungan 7 Hari Terakhir</h3>
                        <canvas id="grafikKunjungan" class="h-64"></canvas>
                    </div>
                </div>

                {{-- Statistik Poli --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Poli</h2>

                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700">Kunjungan Hari Ini</h3>
                        @forelse($kunjunganHarian as $item)
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                    <div class="bg-blue-600 h-2.5 rounded-full"
                                        style="width: {{ ($item->total / $kunjunganHarian->sum('total')) * 100 }}%"></div>
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $item->Poli }} ({{ $item->total }})
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada kunjungan hari ini</p>
                        @endforelse

                        <hr class="my-4 border-gray-200">

                        <h3 class="text-lg font-semibold text-gray-700">Kunjungan Bulan Ini</h3>
                        @forelse($kunjunganBulanan as $item)
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                    <div class="bg-green-600 h-2.5 rounded-full"
                                        style="width: {{ ($item->total / $kunjunganBulanan->sum('total')) * 100 }}%"></div>
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $item->Poli }} ({{ $item->total }})
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada kunjungan bulan ini</p>
                        @endforelse
                    </div>
                </div>

                {{-- Status Kunjungan --}}
                <div class="bg-white shadow-md rounded-lg p-6 col-span-full">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Status Kunjungan Hari Ini</h2>

                    <div class="grid md:grid-cols-4 gap-4">
                        @forelse($statusKunjungan as $status)
                            <div class="bg-gray-100 p-4 rounded-md text-center">
                                <div
                                    class="text-3xl font-bold 
                            @if ($status->Status == 'Selesai') text-green-600
                            @elseif($status->Status == 'Antri') text-yellow-600
                            @elseif($status->Status == 'Diperiksa') text-blue-600
                            @elseif($status->Status == 'Batal') text-red-600 @endif">
                                    {{ $status->total }}
                                </div>
                                <div class="text-gray-600">{{ $status->Status }}</div>
                            </div>
                        @empty
                            <div class="col-span-4 text-center text-gray-500">
                                Belum ada kunjungan hari ini
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil data grafik kunjungan
                fetch('/dashboard/grafik-kunjungan')
                    .then(response => response.json())
                    .then(data => {
                        const ctx = document.getElementById('grafikKunjungan').getContext('2d');

                        // Persiapkan data untuk chart
                        const labels = [];
                        const datasets = {
                            Umum: [],
                            Kandungan: [],
                            Gigi: []
                        };

                        // Proses data
                        Object.keys(data).forEach(poli => {
                            data[poli].forEach(item => {
                                if (!labels.includes(item.tanggal)) {
                                    labels.push(item.tanggal);
                                }

                                // Pastikan setiap label memiliki data untuk setiap poli
                                if (!datasets[poli]) {
                                    datasets[poli] = new Array(labels.length).fill(0);
                                }

                                const index = labels.indexOf(item.tanggal);
                                datasets[poli][index] = item.total;
                            });
                        });

                        // Buat dataset untuk chart
                        const chartDatasets = Object.keys(datasets).map(poli => ({
                            label: poli,
                            data: datasets[poli],
                            borderColor: poli === 'Umum' ? 'rgb(54, 162, 235)' : poli === 'Kandungan' ?
                                'rgb(255, 99, 132)' : 'rgb(75, 192, 192)',
                            tension: 0.1
                        }));

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: chartDatasets
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1,
                                            callback: function(value) {
                                                return Number.isInteger(value) ? value : null;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
            });
        </script>
    @endpush
@endsection
