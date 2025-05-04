<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    // Nama tabel yang digunakan
    protected $table = 'sales';

    // Primary key
    protected $primaryKey = 'id_sales';

    // Jika primary key bukan integer, tambahkan ini
    protected $keyType = 'string';

    // Jika primary key auto increment, tambahkan ini
    public $incrementing = false;

    // Kolom yang dapat diisi
    protected $fillable = [
        'id_sales',
        'id_supplier',
        'NamaSales',
    ];

    // Relasi dengan model Supplier (jika ada)
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    // Relasi dengan model TransaksiPembelian (jika ada)
    public function transaksiPembelian()
    {
        return $this->hasMany(TransaksiPembelian::class, 'id_sales', 'id_sales');
    }
}
