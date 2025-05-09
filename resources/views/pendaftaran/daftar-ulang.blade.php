@extends('layouts.app')
@section('title', 'Pendaftaran Ulang Pasien')
@section('content')
<div class="p-4 sm:ml-64">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">@yield('title')</h1>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Data Pasien</h2>
                
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-600">Nomor Rekam Medis:</span>
                        <span class="text-gray-800">{{ $pasien->Nrm }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">NIK:</span>
                        <span class="text-gray-800">{{ $pasien->Nik }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Nama Lengkap:</span>
                        <span class="text-gray-800">{{ $pasien->NamaPasien }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Jenis Kelamin:</span>
                        <span class="text-gray-800">{{ $pasien->JenisKelamin }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Umur:</span>
                        <span class="text-gray-800">{{ $pasien->Umur }} Tahun</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Riwayat Kunjungan Terakhir</h2>
                
                @if($pasien->kunjungan->count() > 0)
                    @php
                        $terakhirKunjungan = $pasien->kunjungan->sortByDesc('TanggalKunjungan')->first();
                    @endphp
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium text-gray-600">Tanggal Kunjungan:</span>
                            <span class="text-gray-800">
                                {{ \Carbon\Carbon::parse($terakhirKunjungan->TanggalKunjungan)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Poli:</span>
                            <span class="text-gray-800">{{ $terakhirKunjungan->Poli }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Keluhan:</span>
                            <span class="text-gray-800">{{ $terakhirKunjungan->Keluhan }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Status:</span>
                            <span class="text-gray-800">{{ $terakhirKunjungan->Status }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-yellow-600">Belum ada riwayat kunjungan</p>
                @endif
            </div>
        </div>

        <form action="{{ route('pendaftaran.simpan-daftar-ulang', $pasien->Nrm) }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
            @csrf
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Informasi Kunjungan Baru</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="Keluhan">Keluhan *</label>
                <textarea name="Keluhan" id="Keluhan" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    rows="4">{{ old('Keluhan') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="Poli">Poli *</label>
                <select name="Poli" id="Poli" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Poli</option>
                    <option value="Umum" {{ old('Poli') == 'Umum' ? 'selected' : '' }}>Poli Umum</option>
                    <option value="Kandungan" {{ old('Poli') == 'Kandungan' ? 'selected' : '' }}>Poli Kandungan</option>
                    <option value="Gigi" {{ old('Poli') == 'Gigi' ? 'selected' : '' }}>Poli Gigi</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                    class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition duration-300">
                    Daftar Ulang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection