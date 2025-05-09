<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaan';
    protected $primaryKey = 'IdPemeriksaan';
    public $timestamps = false;

    protected $fillable = [
        'IdKunjungan',
        'IdDokter',
        'TanggalPemeriksaan',
        'Diagnosa',
        'Tindakan',
        'Status',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'IdKunjungan');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'IdDokter');
    }

    public function resep()
    {
        return $this->hasOne(Resep::class, 'IdPemeriksaan');
    }
}
