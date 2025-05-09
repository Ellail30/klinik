<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'IdPembayaran';
    public $timestamps = false;

    protected $fillable = [
        'IdResep',
        'TanggalPembayaran',
        'TotalBayar',
        'IdApoteker',
        'Keterangan',
    ];

    public function resep()
    {
        return $this->belongsTo(Resep::class, 'IdResep');
    }

    public function apoteker()
    {
        return $this->belongsTo(User::class, 'IdApoteker');
    }
}
