<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table = 'resep';
    protected $primaryKey = 'IdResep';
    public $incrementing = false; // karena primary key berupa VARCHAR
    public $timestamps = false;

    protected $fillable = [
        'IdResep',
        'IdPemeriksaan',
        'TanggalResep',
        'Status',
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'IdPemeriksaan');
    }

    public function detailResep()
    {
        return $this->hasMany(DetailResep::class, 'IdResep');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'IdResep');
    }
}
