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
                <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="sm:hidden">
                        <label for="tabs" class="sr-only">Select tab</label>
                        <select id="tabs"
                            class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>Obat Masuk</option>
                            <option>Obat Keluar</option>
                            <option>Persediaan</option>
                        </select>
                    </div>
                    <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400 rtl:divide-x-reverse"
                        id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                        <li class="w-full">
                            <button id="stats-tab" data-tabs-target="#stats" type="button" role="tab"
                                aria-controls="stats" aria-selected="true"
                                class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">
                                Obat Masuk
                            </button>
                        </li>
                        <li class="w-full">
                            <button id="about-tab" data-tabs-target="#about" type="button" role="tab"
                                aria-controls="about" aria-selected="false"
                                class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">
                                Obat Keluar
                            </button>
                        </li>
                        <li class="w-full">
                            <button id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="faq"
                                aria-selected="false"
                                class="inline-block w-full p-4 rounded-se-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">
                                Persediaan
                            </button>
                        </li>
                    </ul>
                    <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
                        <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel"
                            aria-labelledby="stats-tab">
                            <dl
                                class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                                <div class="flex flex-col items-center justify-center">
                                    <dt class="mb-2 text-3xl font-extrabold">{{ $totalTransaksi }}</dt>
                                </div>
                                <div class="flex flex-col items-center justify-center">
                                    <dt class="mb-2 text-3xl font-extrabold">0</dt>
                                </div>
                                <div class="flex flex-col items-center justify-center">
                                    <dt class="mb-2 text-3xl font-extrabold">0</dt>
                                </div>
                            </dl>
                        </div>
                        <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel"
                            aria-labelledby="about-tab">
                            <h2 class="mb-5 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">We invest
                                in the world's potential</h2>
                            <ul role="list" class="space-y-4 text-gray-500 dark:text-gray-400">
                                <li class="flex space-x-2 rtl:space-x-reverse items-center">
                                    <svg class="flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>
                                    <span class="leading-tight">Dynamic reports and dashboards</span>
                                </li>
                                <li class="flex space-x-2 rtl:space-x-reverse items-center">
                                    <svg class="flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>
                                    <span class="leading-tight">Templates for everyone</span>
                                </li>
                                <li class="flex space-x-2 rtl:space-x-reverse items-center">
                                    <svg class="flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>
                                    <span class="leading-tight">Development workflow</span>
                                </li>
                                <li class="flex space-x-2 rtl:space-x-reverse items-center">
                                    <svg class="flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>
                                    <span class="leading-tight">Limitless business automation</span>
                                </li>
                            </ul>
                        </div>
                        <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="faq" role="tabpanel"
                            aria-labelledby="faq-tab">
                            <div id="accordion-flush" data-accordion="collapse"
                                data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                data-inactive-classes="text-gray-500 dark:text-gray-400">
                                <h2 id="accordion-flush-heading-1">
                                    <button type="button"
                                        class="flex items-center justify-between w-full py-5 font-medium text-left rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                                        data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                                        aria-controls="accordion-flush-body-1">
                                        <span>What is Flowbite?</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-flush-body-1" class="hidden"
                                    aria-labelledby="accordion-flush-heading-1">
                                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                                        <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is an open-source library
                                            of interactive components built on top of Tailwind CSS including buttons,
                                            dropdowns, modals, navbars, and more.</p>
                                        <p class="text-gray-500 dark:text-gray-400">Check out this guide to learn how to <a
                                                href="/docs/getting-started/introduction/"
                                                class="text-blue-600 dark:text-blue-500 hover:underline">get started</a>
                                            and start developing websites even faster with components on top of Tailwind
                                            CSS.</p>
                                    </div>
                                </div>
                                {{-- Rest of the accordion items --}}
                            </div>
                        </div>
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
