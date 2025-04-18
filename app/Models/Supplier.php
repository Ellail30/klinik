<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_supplier';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'supplier';
    protected $fillable = ['id_supplier', 'NamaSupplier', 'NPWP', 'NoIjinPBF', 'Alamat'];
}
