@extends('layouts.app')
@section('title', 'Cetak Resep')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">Cetak Resep Obat</h1>
                <div>
                    <a href="{{ route('dokter.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 mr-2">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        <i class="fas fa-print mr-2"></i>Cetak
                    </button>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md mb-6" id="printable-content">
                <div class="text-center mb-6 border-b pb-4">
                    <h1 class="text-2xl font-bold text-gray-800">Klinik PKU Muhammadiyah Berbah</h1>
                    <p>Krikilan, Tegaltirto, Kec. Berbah, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55282</p>
                    <p>Telp: 0895-1631-5090</p>
                </div>
                
                <div class="flex justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold">RESEP OBAT</h2>
                        <p class="text-gray-600">No. Resep: {{ $resep->IdResep }}</p>
                        <p class="text-gray-600">Tanggal: {{ \Carbon\Carbon::parse($resep->TanggalResep)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Dokter: {{ $resep->pemeriksaan->dokter->Nama }}</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Data Pasien</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <p><span class="font-medium">Nama:</span> {{ $resep->pemeriksaan->kunjungan->pasien->NamaPasien }}</p>
                        </div>
                        <div>
                            <p><span class="font-medium">No. RM:</span> {{ $resep->pemeriksaan->kunjungan->pasien->Nrm }}</p>
                        </div>
                        <div>
                            <p><span class="font-medium">Jenis Kelamin:</span> {{ $resep->pemeriksaan->kunjungan->pasien->JenisKelamin }}</p>
                        </div>
                        <div>
                            <p><span class="font-medium">Umur:</span> {{ \Carbon\Carbon::parse($resep->pemeriksaan->kunjungan->pasien->TanggalLahir)->age }} Tahun</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">                    
                    <table class="min-w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border text-left">No</th>
                                <th class="py-2 px-4 border text-left">Nama Obat</th>
                                <th class="py-2 px-4 border text-left">Jumlah</th>
                                <th class="py-2 px-4 border text-left">Dosis</th>
                                <th class="py-2 px-4 border text-left">Waktu Konsumsi</th>
                                <th class="py-2 px-4 border text-left">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resep->detailResep as $index => $detail)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                                    <td class="py-2 px-4 border">{{ $detail->obat->NamaObat }}</td>
                                    <td class="py-2 px-4 border">{{ $detail->Jumlah }} {{ $detail->obat->Satuan }}</td>
                                    <td class="py-2 px-4 border">{{ $detail->Dosis }}</td>
                                    <td class="py-2 px-4 border">{{ $detail->WaktuKonsumsi }}</td>
                                    <td class="py-2 px-4 border">{{ $detail->Catatan ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="flex justify-end mt-8">
                    <div class="text-center">
                        <p>Dokter,</p>
                        <div class="h-16"></div>
                        <p class="font-semibold">{{ $resep->pemeriksaan->dokter->Nama }}</p>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t text-sm text-gray-600">
                    <p>* Silahkan bawa resep ini ke bagian apotek untuk pengambilan obat</p>
                    <p>* Resep berlaku 7 hari sejak diterbitkan</p>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-content, #printable-content * {
                visibility: visible;
            }
            #printable-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 40px;
            }
            .print\:hidden {
                display: none;
            }
        }
    </style>
@endsection