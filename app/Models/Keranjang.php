<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $fillable = [
        'user_id ',
        'status',
        'total_harga',
    ];

    public $timestamps = false;
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    public function item_keranjang()
    {
        return $this->hasMany(Item_Keranjang::class, 'id_keranjang');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'user_id ');
    }
}
