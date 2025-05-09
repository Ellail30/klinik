@extends('layouts.app')
@section('title', 'Form Resep Obat')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">Form Resep Obat</h1>
                <a href="{{ route('dokter.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            {{-- @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <p>{{ session('error') }}</p>
                </div>
            @endif --}}

            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Data Pasien</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nomor Rekam Medis</p>
                        <p class="font-medium">{{ $pemeriksaan->kunjungan->pasien->Nrm }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Pasien</p>
                        <p class="font-medium">{{ $pemeriksaan->kunjungan->pasien->NamaPasien }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Jenis Kelamin</p>
                        <p class="font-medium">{{ $pemeriksaan->kunjungan->pasien->JenisKelamin }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Umur</p>
                        <p class="font-medium">
                            {{ \Carbon\Carbon::parse($pemeriksaan->kunjungan->pasien->TanggalLahir)->age }} Tahun</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Pemeriksaan</p>
                        <p class="font-medium">
                            {{ \Carbon\Carbon::parse($pemeriksaan->TanggalPemeriksaan)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Diagnosa</h2>
                <div class="p-4 bg-gray-50 rounded-md">
                    <p>{{ $pemeriksaan->Diagnosa }}</p>
                </div>
            </div>

            <form action="{{ route('dokter.simpanResep', $pemeriksaan->IdPemeriksaan) }}" method="POST"
                class="bg-white p-6 rounded-lg shadow-md">
                @csrf
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Resep Obat</h2>

                <div id="obat-container">
                    <div class="obat-item mb-4 p-4 border border-gray-200 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Obat <span
                                        class="text-red-500">*</span></label>
                                <select name="obat[]" required
                                    class="obat-select w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
                                    <option value="">Pilih Obat</option>
                                    @foreach ($obats as $obat)
                                        <option value="{{ $obat->id_obat }}" data-stok="{{ $obat->stok }}">
                                            {{ $obat->NamaObat }} (Stok: {{ $obat->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dosis <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="dosis[]" required placeholder="Contoh: 3x1 Sehari"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="jumlah[]" required min="1" value="1"
                                    class="jumlah-obat w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
                                <p class="stok-warning text-sm text-red-500 hidden">Jumlah melebihi stok yang tersedia!</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Konsumsi <span
                                        class="text-red-500">*</span></label>
                                <select name="waktu_konsumsi[]" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
                                    <option value="">Pilih Waktu Konsumsi</option>
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan">Sesudah Makan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <input type="text" name="catatan[]" placeholder="Catatan tambahan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
                        </div>
                        <div class="flex justify-end mt-2">
                            <button type="button"
                                class="remove-obat px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 hidden">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mb-6">
                    <button type="button" id="add-obat"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        <i class="fas fa-plus mr-2"></i>Tambah Obat
                    </button>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Simpan Resep
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Reference to the container
                const container = document.getElementById('obat-container');
                const addButton = document.getElementById('add-obat');

                // Function to check if jumlah exceeds stok
                function checkStok(itemEl) {
                    const selectEl = itemEl.querySelector('.obat-select');
                    const jumlahEl = itemEl.querySelector('.jumlah-obat');
                    const warningEl = itemEl.querySelector('.stok-warning');

                    if (selectEl.selectedIndex > 0) {
                        const option = selectEl.options[selectEl.selectedIndex];
                        const stok = parseInt(option.getAttribute('data-stok'));
                        const jumlah = parseInt(jumlahEl.value);

                        if (jumlah > stok) {
                            warningEl.classList.remove('hidden');
                            return false;
                        } else {
                            warningEl.classList.add('hidden');
                        }
                    }
                    return true;
                }

                // Add event listener to the first item
                const firstItem = container.querySelector('.obat-item');
                firstItem.querySelector('.jumlah-obat').addEventListener('input', function() {
                    checkStok(firstItem);
                });

                firstItem.querySelector('.obat-select').addEventListener('change', function() {
                    checkStok(firstItem);
                });

                // Add new obat item
                addButton.addEventListener('click', function() {
                    const items = container.querySelectorAll('.obat-item');
                    const newItem = items[0].cloneNode(true);

                    // Reset values
                    const selects = newItem.querySelectorAll('select');
                    const inputs = newItem.querySelectorAll('input');
                    selects.forEach(select => select.selectedIndex = 0);
                    inputs.forEach(input => {
                        if (input.type === 'number') {
                            input.value = 1;
                        } else {
                            input.value = '';
                        }
                    });

                    // Show remove button
                    const removeBtn = newItem.querySelector('.remove-obat');
                    removeBtn.classList.remove('hidden');

                    // Add event listeners
                    newItem.querySelector('.jumlah-obat').addEventListener('input', function() {
                        checkStok(newItem);
                    });

                    newItem.querySelector('.obat-select').addEventListener('change', function() {
                        checkStok(newItem);
                    });

                    removeBtn.addEventListener('click', function() {
                        newItem.remove();
                    });

                    // Hide warning
                    newItem.querySelector('.stok-warning').classList.add('hidden');

                    // Append the new item
                    container.appendChild(newItem);
                });

                // Form validation before submit
                document.querySelector('form').addEventListener('submit', function(e) {
                    const items = container.querySelectorAll('.obat-item');
                    let valid = true;

                    items.forEach(item => {
                        if (!checkStok(item)) {
                            valid = false;
                        }
                    });

                    if (!valid) {
                        e.preventDefault();
                        alert('Jumlah obat melebihi stok yang tersedia. Silakan periksa kembali.');
                    }
                });
            });
        </script>
    @endpush
@endsection
