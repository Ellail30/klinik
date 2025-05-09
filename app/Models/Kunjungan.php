<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';
    protected $primaryKey = 'IdKunjungan';
    public $timestamps = false;

    protected $fillable = [
        'Nrm',
        'TanggalKunjungan',
        'Keluhan',
        'Poli',
        'NomorAntrian',
        'Status'
    ];

    // Relasi dengan pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'Nrm', 'Nrm');
    }

    // Method untuk generate Nomor Antrian
    public static function generateNomorAntrian($poli)
    {
        $today = now()->format('Y-m-d');
        $poliPrefix = substr($poli, 0, 1);

        $lastKunjungan = self::where('Poli', $poli)
            ->whereDate('TanggalKunjungan', $today)
            ->orderBy('IdKunjungan', 'desc')
            ->first();

        if (!$lastKunjungan) {
            return $poliPrefix . '01';
        }

        $lastNumber = substr($lastKunjungan->NomorAntrian, 1);
        $newNumber = str_pad((int)$lastNumber + 1, 2, '0', STR_PAD_LEFT);

        return $poliPrefix . $newNumber;
    }
}
