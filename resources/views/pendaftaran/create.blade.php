@extends('layouts.app')
@section('title', 'Pendaftaran Pasien Baru')
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
<button type="button" onclick="autofillData()"
    class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition duration-300 mb-4">
    Isi Data Otomatis
</button>

            <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Data Pribadi --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Data Pribadi</h2>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="Nik">NIK *</label>
                            <input type="text" name="Nik" id="Nik" required
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('Nik') }}" pattern="\d{16}" title="NIK harus 16 digit angka"
                                maxlength="16">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="NamaPasien">Nama Lengkap *</label>
                            <input type="text" name="NamaPasien" id="NamaPasien" required
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('NamaPasien') }}" maxlength="25">
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="TempatLahir">Tempat Lahir</label>
                                <input type="text" name="TempatLahir" id="TempatLahir"
                                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('TempatLahir') }}" maxlength="30">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="TanggalLahir">Tanggal Lahir</label>
                                <input type="date" name="TanggalLahir" id="TanggalLahir"
                                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('TanggalLahir') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="JenisKelamin">Jenis Kelamin *</label>
                            <select name="JenisKelamin" id="JenisKelamin" required
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('JenisKelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('JenisKelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Informasi Kontak dan Tambahan --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Informasi Tambahan</h2>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="Alamat">Alamat</label>
                            <textarea name="Alamat" id="Alamat"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" maxlength="100">{{ old('Alamat') }}</textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="NoTelp">Nomor Telepon</label>
                                <input type="tel" name="NoTelp" id="NoTelp"
                                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('NoTelp') }}" maxlength="15">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="Email">Email</label>
                                <input type="email" name="Email" id="Email"
                                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('Email') }}" maxlength="100">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="GolonganDarah">Golongan
                                    Darah</label>
                                <select name="GolonganDarah" id="GolonganDarah"
                                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A" {{ old('GolonganDarah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('GolonganDarah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('GolonganDarah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('GolonganDarah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="StatusPernikahan">Status
                                    Pernikahan</label>
                                <select name="StatusPernikahan" id="StatusPernikahan"
                                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Menikah"
                                        {{ old('StatusPernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah
                                    </option>
                                    <option value="Menikah" {{ old('StatusPernikahan') == 'Menikah' ? 'selected' : '' }}>
                                        Menikah</option>
                                    <option value="Cerai" {{ old('StatusPernikahan') == 'Cerai' ? 'selected' : '' }}>
                                        Cerai</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2" for="Agama">Agama</label>
                            <select name="Agama" id="Agama"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('Agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('Agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katholik" {{ old('Agama') == 'Katholik' ? 'selected' : '' }}>Katholik
                                </option>
                                <option value="Budha" {{ old('Agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                <option value="Hindu" {{ old('Agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Konghuchu" {{ old('Agama') == 'Konghuchu' ? 'selected' : '' }}>Konghuchu
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Informasi Kunjungan --}}
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Informasi Kunjungan</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="Keluhan">Keluhan *</label>
                        <textarea name="Keluhan" id="Keluhan" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4">{{ old('Keluhan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="Poli">Poli *</label>
                        <select name="Poli" id="Poli" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Poli</option>
                            <option value="Umum" {{ old('Poli') == 'Umum' ? 'selected' : '' }}>Poli Umum</option>
                            <option value="Kandungan" {{ old('Poli') == 'Kandungan' ? 'selected' : '' }}>Poli Kandungan
                            </option>
                            <option value="Gigi" {{ old('Poli') == 'Gigi' ? 'selected' : '' }}>Poli Gigi</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition duration-300">
                        Daftar Pasien
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Optional: Tambahkan validasi atau interaksi tambahan di sini
            document.addEventListener('DOMContentLoaded', function() {
                const nikInput = document.getElementById('Nik');
                nikInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^\d]/g, '');
                });
            });

            function autofillData() {
        document.getElementById('Nik').value = '1234567890123456';
        document.getElementById('NamaPasien').value = 'Budi Santoso';
        document.getElementById('TempatLahir').value = 'Jakarta';
        document.getElementById('TanggalLahir').value = '1990-01-01';
        document.getElementById('JenisKelamin').value = 'Laki-laki';
        document.getElementById('Alamat').value = 'Jl. Merdeka No. 123, Jakarta';
        document.getElementById('NoTelp').value = '081234567890';
        document.getElementById('Email').value = 'budi@example.com';
        document.getElementById('GolonganDarah').value = 'O';
        document.getElementById('StatusPernikahan').value = 'Menikah';
        document.getElementById('Agama').value = 'Islam';
        document.getElementById('Keluhan').value = 'Demam dan batuk sejak 3 hari';
        document.getElementById('Poli').value = 'Umum';
    }
        </script>
    @endpush
@endsection
