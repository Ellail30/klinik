<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetTransaksiPembelian extends Model
{
    use HasFactory;
    // Nama tabel yang digunakan
    protected $table = 'det_transaksi_pembelian';

    // Primary key
    protected $primaryKey = 'NoDetBeli';

    // Jika primary key bukan integer, tambahkan ini
    // protected $keyType = 'bigint';

    // Jika primary key auto increment, tambahkan ini
    public $incrementing = true;
    public $timestamps = false;

    // Kolom yang dapat diisi
    protected $fillable = [
        'NoFaktur',
        'qty',
        'BesarPotongan',
        'PotCash',
        'HargaBeli',
        'id_obat',
    ];

    // Relasi dengan model Obat
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id_obat');
    }

    // Relasi dengan model TransaksiPembelian
    public function transaksiPembelian()
    {
        return $this->belongsTo(TransaksiPembelian::class, 'NoFaktur', 'NoFaktur');
    }
}
