<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'role',
        'jabatan',
        'Nama',
        'FotoProfil',
        'no_telp',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'string',
    ];
}
