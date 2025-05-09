@extends('layouts.app')
@section('title', 'Riwayat Kunjungan Pasien')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ $pasien->NamaPasien }}</span>
                    <span class="text-gray-600">NRM: {{ $pasien->Nrm }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm">
                        <tr>
                            <th class="py-3 px-4 text-left">Tanggal Kunjungan</th>
                            <th class="py-3 px-4 text-left">Nomor Antrian</th>
                            <th class="py-3 px-4 text-left">Poli</th>
                            <th class="py-3 px-4 text-left">Keluhan</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($kunjungan as $item)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-4">
                                    {{ \Carbon\Carbon::parse($item->TanggalKunjungan)->translatedFormat('d F Y H:i') }}
                                </td>
                                <td class="py-3 px-4">{{ $item->NomorAntrian }}</td>
                                <td class="py-3 px-4">{{ $item->Poli }}</td>
                                <td class="py-3 px-4">{{ $item->Keluhan }}</td>
                                <td class="py-3 px-4">
                                    <span
                                        class="
                                    @if ($item->Status == 'Selesai') text-green-600
                                    @elseif($item->Status == 'Antri') text-yellow-600
                                    @elseif($item->Status == 'Batal') text-red-600
                                    @else text-blue-600 @endif
                                    font-semibold">
                                        {{ $item->Status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <button onclick="showDetailModal({{ $item->IdKunjungan }})"
                                        class="text-blue-500 hover:text-blue-600 hover:underline">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    Tidak ada riwayat kunjungan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $kunjungan->links('components.pagination') }}
            </div>
        </div>

        {{-- Modal Detail Kunjungan --}}
        <div id="detailKunjunganModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-1/2 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Detail Kunjungan</h2>
                    <button onclick="closeDetailModal()" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
                </div>

                <div id="detailKunjunganContent" class="space-y-4">
                    {{-- Konten detail kunjungan akan diisi secara dinamis --}}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showDetailModal(idKunjungan) {
                // Ambil data kunjungan via AJAX
                fetch(`/kunjungan/${idKunjungan}`)
                    .then(response => response.json())
                    .then(kunjungan => {
                        const content = document.getElementById('detailKunjunganContent');
                        content.innerHTML = `
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Informasi Kunjungan</h3>
                            <p><strong>Tanggal:</strong> ${new Date(kunjungan.TanggalKunjungan).toLocaleString()}</p>
                            <p><strong>Nomor Antrian:</strong> ${kunjungan.NomorAntrian}</p>
                            <p><strong>Poli:</strong> ${kunjungan.Poli}</p>
                            <p><strong>Status:</strong> ${kunjungan.Status}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Detail Keluhan</h3>
                            <p>${kunjungan.Keluhan}</p>
                        </div>
                    </div>
                `;

                        // Tampilkan modal
                        document.getElementById('detailKunjunganModal').classList.remove('hidden');
                        document.getElementById('detailKunjunganModal').classList.add('flex');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat detail kunjungan');
                    });
            }

            function closeDetailModal() {
                const modal = document.getElementById('detailKunjunganModal');
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        </script>
    @endpush
@endsection
