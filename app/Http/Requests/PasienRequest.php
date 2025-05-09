<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Aturan validasi untuk pendaftaran pasien
            'Nik' => 'required|unique:pasien|digits:16',
            'NamaPasien' => 'required|max:25',
            'TempatLahir' => 'nullable|max:30',
            'TanggalLahir' => 'nullable|date',
            'JenisKelamin' => 'required|in:Laki-laki,Perempuan',
            'Alamat' => 'nullable|max:100',
            'NoTelp' => 'nullable|max:15',
            'Email' => 'nullable|email|max:100',
            'GolonganDarah' => 'nullable|in:A,B,AB,O',
            'StatusPernikahan' => 'nullable|in:Belum Menikah,Menikah,Cerai',
            'Agama' => 'nullable|in:Islam,Kristen,Katholik,Budha,Hindu,Konghuchu',

            // Aturan validasi untuk kunjungan
            'Keluhan' => 'required|string',
            'Poli' => 'required|in:Kandungan,Gigi,Umum'
        ];
    }

    public function messages()
    {
        return [
            'Nik.required' => 'NIK wajib diisi',
            'Nik.unique' => 'NIK sudah terdaftar',
            'Nik.digits' => 'NIK harus terdiri dari 16 digit',
            'NamaPasien.required' => 'Nama pasien wajib diisi',
            'NamaPasien.max' => 'Nama pasien maksimal 25 karakter',
            'JenisKelamin.required' => 'Jenis kelamin wajib dipilih',
            'Keluhan.required' => 'Keluhan wajib diisi',
            'Poli.required' => 'Poli wajib dipilih'
        ];
    }
}
