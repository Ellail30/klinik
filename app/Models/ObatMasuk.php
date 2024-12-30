<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatMasuk extends Model
{
    use HasFactory;
    protected $primaryKey = 'NoDetBeli';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'det_transaksi_pembelian';
    protected $fillable = ['NoDetBeli', 'NoFaktur', 'qty', 'BesarPotongan', 'PotCash', 'HargaBeli', 'id_obat'];
}
