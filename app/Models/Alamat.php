<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    public $timestamps = false;
    protected $table = 'alamat';

    protected $fillable = [
        'user_id', 'jalan', 'kota', 'provinsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
