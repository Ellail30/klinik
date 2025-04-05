@extends('layouts.app')

@section('title', 'Pasien')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="content-table">
        <div class="p-4 grid grid-cols-3 gap-4">

            <!-- Form Entry Data -->
            <div class="bg-white p-5 shadow rounded-lg col-span-1">
                <h2 class="text-black font-semibold mb-4">Entry Data</h2>
                @csrf

                <label class="block text-gray-600">NIK</label>
                <input type="text" name="Nik" id="Nik" class="w-full p-2 border rounded mb-3">

                <label class="block text-gray-600">Kode Obat</label>
                <input type="text" name="KodeObat" id="id_obat" class="w-full p-2 border rounded mb-3" >

                <label class="block text-gray-600">Tanggal Keluar</label>
                <input type="date" name="TanggalKeluar" id="TanggalKeluar" class="w-full p-2 border rounded mb-3">

                <label class="block text-gray-600">Jumlah</label>
                <input type="number" name="Jumlah" id="Jumlah" class="w-full p-2 border rounded mb-3" >
                <button class="w-full bg-blue-500 text-white p-2 rounded">Simpan</button>
            </div>

            <!-- Table Pasien -->
            <div class="overflow-x-auto col-span-2">
                <table class="table table-striped min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-base font-semibold">No</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">NIK</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">NRM</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Nama Pasien</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Umur</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pasien as $item)
                        <tr class="border-t cursor-pointer hover:bg-gray-100" onclick="selectPasien('{{ $item->Nik }}')">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $item->Nik }}</td>
                            <td class="px-4 py-2">{{ $item->Nrm }}</td>
                            <td class="px-4 py-2">{{ $item->NamaPasien }}</td>
                            <td class="px-4 py-2">{{ $item->Umur }}</td>
                            <td class="px-4 py-2">{{ $item->Alamat }}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination -->
            <div class="pagination-container">
                {{ $pasien->links('pagination::bootstrap-4') }}
            </div>
            </div>
        </div>

            <!-- Table Obat -->
            <div class="overflow-x-auto">
                <table class="table table-striped min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                            <tr>
                            <th class="px-4 py-2 text-left text-base font-semibold">No</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Kode Obat</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Nama Obat</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Satuan</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Stok</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">TglExp</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">NoBatch</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Harga Beli</th>
                            <th class="px-4 py-2 text-left text-base font-semibold">Harga Jual</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obat as $item)
                            <tr class="border-t cursor-pointer hover:bg-gray-100" onclick="selectObat('{{ $item->id_obat }}')">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $item->id_obat }}</td>
                                <td class="px-4 py-2">{{ $item->NamaObat }}</td>
                                <td class="px-4 py-2">{{ $item->Satuan }}</td>
                                <td class="px-4 py-2">{{ $item->stok }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->TglExp)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">{{ $item->NoBatch }}</td>
                                <td class="px-4 py-2">{{ $item->HargaBeli }}</td>
                                <td class="px-4 py-2">{{ $item->HargaJual }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

              <!-- Pagination -->
        <div class="pagination-container mt-4 mb-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-start">
                    <!-- Previous Button -->
                    <li class="page-item {{ $obat->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $obat->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <!-- Pagination Links -->
                    @foreach ($obat->getUrlRange(1, $obat->lastPage()) as $page => $url)
                        <li class="page-item {{ $obat->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach

                    <!-- Next Button -->
                    <li class="page-item {{ !$obat->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $obat->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function selectPasien(Nik, Nrm, NamaPasien, Umur, Alamat) {
        document.getElementById('Nik').value = Nik;
        document.getElementById('Nrm').value = Nrm;
        document.getElementById('NamaPasien').value = NamaPasien;
        document.getElementById('Umur').value = Umur;
        document.getElementById('Alamat').value = Alamat;
    }

    function selectObat(id_obat, NamaObat, Satuan, stok, TglExp, NoBatch, HargaBeli, HargaJual) {
        document.getElementById('id_obat').value = id_obat;
        document.getElementById('NamaObat').value = NamaObat;
        document.getElementById('Satuan').value = Satuan;
        document.getElementById('stok').value = stok;
        document.getElementById('TglExp').value = TglExp;
        document.getElementById('NoBatch').value = NoBatch;
        document.getElementById('HargaBeli').value = HargaBeli;
        document.getElementById('HargaJual').value = HargaJual;

    }
</script>
@endsection
