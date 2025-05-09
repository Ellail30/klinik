@extends('layouts.app')
@section('title', 'Form Pemeriksaan Pasien')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">Form Pemeriksaan Pasien</h1>
                <a href="{{ route('dokter.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
            
            {{-- @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <p>{{ session('error') }}</p>
                </div>
            @endif --}}
            
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Data Pasien</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nomor Rekam Medis</p>
                        <p class="font-medium">{{ $kunjungan->Nrm }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Pasien</p>
                        <p class="font-medium">{{ $kunjungan->NamaPasien }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Jenis Kelamin</p>
                        <p class="font-medium">{{ $kunjungan->JenisKelamin }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Umur</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($kunjungan->TanggalLahir)->age }} Tahun</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Alamat</p>
                        <p class="font-medium">{{ $kunjungan->Alamat ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Poli</p>
                        <p class="font-medium">{{ $kunjungan->Poli }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Keluhan Pasien</h2>
                <div class="p-4 bg-gray-50 rounded-md">
                    <p>{{ $kunjungan->Keluhan }}</p>
                </div>
            </div>
            
            <form action="{{ route('dokter.simpanPemeriksaan', $kunjungan->IdKunjungan) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                @csrf
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Hasil Pemeriksaan</h2>
                
                <div class="mb-4">
                    <label for="diagnosa" class="block text-sm font-medium text-gray-700 mb-1">Diagnosa <span class="text-red-500">*</span></label>
                    <textarea name="diagnosa" id="diagnosa" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 @error('diagnosa') border-red-500 @enderror">{{ old('diagnosa') }}</textarea>
                    @error('diagnosa')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="tindakan" class="block text-sm font-medium text-gray-700 mb-1">Tindakan</label>
                    <textarea name="tindakan" id="tindakan" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 @error('tindakan') border-red-500 @enderror">{{ old('tindakan') }}</textarea>
                    @error('tindakan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Simpan & Lanjutkan ke Resep
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection