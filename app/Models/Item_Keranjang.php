<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Item_Keranjang extends Model
{
    protected $table = 'item_keranjang';

    protected $fillable = [
        'id_keranjang',
        'id_produk',
        'id_varian',
        'jumlah',
        'harga',
    ];

    public $timestamps = false;
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'id_varian');
    }
}
