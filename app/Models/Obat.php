<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_obat';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'obat'; // Nama tabel di database
    protected $fillable = ['id_obat','NamaObat', 'Satuan', 'stok', 'TglEXP','NoBatch', 'HargaBeli', 'HargaJual']; // Kolom yang bisa diisi
}
