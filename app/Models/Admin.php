<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nomor_telepon',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

     public $timestamps = false;
}
