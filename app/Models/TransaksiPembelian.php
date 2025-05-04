<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembelian extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pembelian';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'NoFaktur';

    /**
     * Indicates if the primary key is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'NoFaktur',
        'TglFaktur',
        'Waktu',
        'TglJatuhTempo',
        'id_sales',
        'id_Apoteker'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'TglFaktur' => 'date',
        'Waktu' => 'datetime:H:i:s',
        'TglJatuhTempo' => 'date'
    ];

    /**
     * Relationship with detail transaksi pembelian
     */
    public function detailTransaksi()
    {
        return $this->hasMany(DetTransaksiPembelian::class, 'NoFaktur', 'NoFaktur');
    }

    /**
     * Relationship with sales
     */
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'id_sales');
    }

    /**
     * Relationship with apoteker
     */
    // public function apoteker()
    // {
    //     return $this->belongsTo(Apoteker::class, 'id_Apoteker');
    // }

    public function apoteker()
    {
        return $this->belongsTo(User::class, 'id_Apoteker');
    }
}
