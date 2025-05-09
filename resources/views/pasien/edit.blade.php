@extends('layouts.app')
@section('title','Edit Profil Pasien')
@section('content')
<div class="p-4 sm:ml-64">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">@yield('title')</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pasien.update', $pasien->Nrm) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                {{-- Data Pribadi --}}
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Data Pribadi</h2>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="Nrm">Nomor Rekam Medis</label>
                        <input type="text" name="Nrm" id="Nrm" 
                            value="{{ $pasien->Nrm }}" 
                            class="w-full px-3 py-2 border rounded-md bg-gray-200" 
                            readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="Nik">NIK *</label>
                        <input type="text" name="Nik" id="Nik" required 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('Nik', $pasien->Nik) }}" 
                            pattern="\d{16}" 
                            title="NIK harus 16 digit angka"
                            maxlength="16">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="NamaPasien">Nama Lengkap *</label>
                        <input type="text" name="NamaPasien" id="NamaPasien" required 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('NamaPasien', $pasien->NamaPasien) }}"
                            maxlength="25">
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="TempatLahir">Tempat Lahir</label>
                            <input type="text" name="TempatLahir" id="TempatLahir" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('TempatLahir', $pasien->TempatLahir) }}"
                                maxlength="30">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="TanggalLahir">Tanggal Lahir</label>
                            <input type="date" name="TanggalLahir" id="TanggalLahir" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('TanggalLahir', $pasien->TanggalLahir ? \Carbon\Carbon::parse($pasien->TanggalLahir)->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="JenisKelamin">Jenis Kelamin *</label>
                        <select name="JenisKelamin" id="JenisKelamin" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('JenisKelamin', $pasien->JenisKelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('JenisKelamin', $pasien->JenisKelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                {{-- Informasi Kontak dan Tambahan --}}
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Informasi Tambahan</h2>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="Alamat">Alamat</label>
                        <textarea name="Alamat" id="Alamat" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            maxlength="100">{{ old('Alamat', $pasien->Alamat) }}</textarea>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="NoTelp">Nomor Telepon</label>
                            <input type="tel" name="NoTelp" id="NoTelp" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('NoTelp', $pasien->NoTelp) }}"
                                maxlength="15">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="Email">Email</label>
                            <input type="email" name="Email" id="Email" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('Email', $pasien->Email) }}"
                                maxlength="100">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="GolonganDarah">Golongan Darah</label>
                            <select name="GolonganDarah" id="GolonganDarah"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A" {{ old('GolonganDarah', $pasien->GolonganDarah) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('GolonganDarah', $pasien->GolonganDarah) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('GolonganDarah', $pasien->GolonganDarah) == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('GolonganDarah', $pasien->GolonganDarah) == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="StatusPernikahan">Status Pernikahan</label>
                            <select name="StatusPernikahan" id="StatusPernikahan"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Status</option>
                                <option value="Belum Menikah" {{ old('StatusPernikahan', $pasien->StatusPernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Menikah" {{ old('StatusPernikahan', $pasien->StatusPernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Cerai" {{ old('StatusPernikahan', $pasien->StatusPernikahan) == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                            </select>
                        </div>
                    </div>
                       <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="Agama">Agama</label>
                            <select name="Agama" id="Agama"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('Agama', $pasien->Agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('Agama', $pasien->Agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katholik" {{ old('Agama', $pasien->Agama) == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                <option value="Budha" {{ old('Agama', $pasien->Agama) == 'Budha' ? 'selected' : '' }}>Budha</option>
                                <option value="Hindu" {{ old('Agama', $pasien->Agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Konghuchu" {{ old('Agama', $pasien->Agama) == 'Konghuchu' ? 'selected' : '' }}>Konghuchu</option>
                            </select>
                        </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('pasien.show', $pasien->Nrm) }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded-md hover:bg-gray-600 transition duration-300">
                    Batal
                </a>
                <button type="submit" 
                    class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition duration-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nikInput = document.getElementById('Nik');
        const tanggalLahirInput = document.getElementById('TanggalLahir');

        // Validasi NIK hanya angka
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^\d]/g, '');
        });

        // Hitung umur otomatis saat tanggal lahir berubah
        tanggalLahirInput.addEventListener('change', function() {
            const birthDate = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            // Jika ingin menambahkan field umur di form
            // const umurInput = document.getElementById('Umur');
            // if (umurInput) umurInput.value = age;
        });
    });
</script>
@endpush
@endsection