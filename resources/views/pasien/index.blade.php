@extends('layouts.app')
@section('title', 'Daftar Pasien')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">@yield('title')</h1>

            <div class="mb-6">
                <form action="{{ route('pasien.cari') }}" method="GET" class="flex items-center">
                    <input type="text" name="query" placeholder="Cari Pasien (NIK/Nama/NRM)"
                        class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ $query }}">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 transition duration-300">
                        Cari
                    </button>
                </form>
            </div>

            @if ($pasiens->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="py-3 px-4 text-left">NRM</th>
                                <th class="py-3 px-4 text-left">NIK</th>
                                <th class="py-3 px-4 text-left">Nama Pasien</th>
                                <th class="py-3 px-4 text-left">Jenis Kelamin</th>
                                <th class="py-3 px-4 text-left">Umur</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($pasiens as $pasien)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-4 text-left whitespace-nowrap">
                                        <span class="font-medium">{{ $pasien->Nrm }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-left">{{ $pasien->Nik }}</td>
                                    <td class="py-3 px-4 text-left">{{ $pasien->NamaPasien }}</td>
                                    <td class="py-3 px-4 text-left">{{ $pasien->JenisKelamin }}</td>
                                    <td class="py-3 px-4 text-left">{{ $pasien->Umur }} Tahun</td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('pendaftaran.daftar-ulang', $pasien->Nrm) }}"
                                                class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition duration-300 text-sm">
                                                Daftar Ulang
                                            </a>
                                            <a href="{{ route('pasien.show', $pasien->Nrm)}}" 
                                                class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 transition duration-300 text-sm">
                                                Detail
                                        </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">Tidak ada pasien yang ditemukan untuk pencarian
                        "{{ $query }}".</span>
                </div>
            @endif
        </div>

        {{-- Modal Detail Pasien --}}
        {{-- <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-1/2 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Detail Pasien</h2>
                    <button onclick="closeDetailModal()" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
                </div>

                <div id="detailModalContent" class="grid md:grid-cols-2 gap-4">
                    {{-- Konten detail pasien akan diisi secara dinamis --}}
                </div>
            </div>
        </div> --}}
    </div>

    {{-- @push('scripts')
        <script>
            function showDetailModal(nrm) {
                // Ambil data pasien via AJAX
                fetch(`/pasien/${nrm}`)
                    .then(response => response.json())
                    .then(pasien => {
                        const content = document.getElementById('detailModalContent');
                        content.innerHTML = `
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Data Pribadi</h3>
                        <p><strong>NRM:</strong> ${pasien.Nrm}</p>
                        <p><strong>NIK:</strong> ${pasien.Nik}</p>
                        <p><strong>Nama:</strong> ${pasien.NamaPasien}</p>
                        <p><strong>Tempat, Tanggal Lahir:</strong> ${pasien.TempatLahir}, ${pasien.TanggalLahir}</p>
                        <p><strong>Jenis Kelamin:</strong> ${pasien.JenisKelamin}</p>
                        <p><strong>Umur:</strong> ${pasien.Umur} Tahun</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Informasi Kontak</h3>
                        <p><strong>Alamat:</strong> ${pasien.Alamat || '-'}</p>
                        <p><strong>No. Telp:</strong> ${pasien.NoTelp || '-'}</p>
                        <p><strong>Email:</strong> ${pasien.Email || '-'}</p>
                        <p><strong>Golongan Darah:</strong> ${pasien.GolonganDarah || '-'}</p>
                        <p><strong>Status Pernikahan:</strong> ${pasien.StatusPernikahan || '-'}</p>
                        <p><strong>Agama:</strong> ${pasien.Agama || '-'}</p>
                    </div>
                `;

                        // Tampilkan modal
                        document.getElementById('detailModal').classList.remove('hidden');
                        document.getElementById('detailModal').classList.add('flex');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat detail pasien');
                    });
            }

            function closeDetailModal() {
                const modal = document.getElementById('detailModal');
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        </script>
    @endpush --}}
@endsection
