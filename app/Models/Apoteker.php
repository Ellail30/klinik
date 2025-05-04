<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apoteker extends Model
{
    use HasFactory;
    // Nama tabel yang digunakan
    protected $table = 'apoteker';

    // Primary key
    protected $primaryKey = 'id_Apoteker';

    // Jika primary key bukan integer, tambahkan ini
    protected $keyType = 'string';

    // Jika primary key auto increment, tambahkan ini
    public $incrementing = false;

    // Kolom yang dapat diisi
    protected $fillable = [
        'id_Apoteker',
        'NamaApoteker',
    ];

    // Relasi dengan model TransaksiPembelian
    public function transaksiPembelian()
    {
        return $this->hasMany(TransaksiPembelian::class, 'id_Apoteker', 'id_Apoteker');
    }
}
