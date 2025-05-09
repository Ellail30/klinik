<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// class Pasien extends Model
// {
//     use HasFactory;

//     protected $primaryKey = 'Nik';
//     protected $keyType = 'string';
//     public $timestamps = false;
//     protected $table = 'pasien';
//     protected $fillable = ['Nik', 'Nrm', 'NamaPasien', 'Umur', 'Alamat'];
// }


class Pasien extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'Nrm';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Nrm',
        'Nik',
        'NamaPasien',
        'TempatLahir',
        'TanggalLahir',
        'JenisKelamin',
        'Alamat',
        'NoTelp',
        'Email',
        'GolonganDarah',
        'StatusPernikahan',
        'Agama'
    ];

    public function getUmurAttribute()
    {
        if (!$this->TanggalLahir) {
            return null;
        }

        return Carbon::parse($this->TanggalLahir)->age;
    }

    // Relasi dengan kunjungan
    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'Nrm', 'Nrm');
    }

    // Method untuk generate NRM otomatis
    public static function generateNrm()
    {
        $prefix = date('Ymd');
        $lastPasien = self::where('Nrm', 'like', $prefix . '%')
            ->orderBy('Nrm', 'desc')
            ->first();

        if (!$lastPasien) {
            return $prefix . '001';
        }

        $lastNumber = substr($lastPasien->Nrm, -3);
        $newNumber = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return $prefix . $newNumber;
    }
}