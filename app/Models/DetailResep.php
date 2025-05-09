<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailResep extends Model
{
    protected $table = 'detail_resep';
    protected $primaryKey = 'IdDetailResep';
    public $timestamps = false;

    protected $fillable = [
        'IdResep',
        'IdObat',
        'Dosis',
        'Jumlah',
        'WaktuKonsumsi',
        'Catatan',
    ];

    public function resep()
    {
        return $this->belongsTo(Resep::class, 'IdResep');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'IdObat');
    }
}
