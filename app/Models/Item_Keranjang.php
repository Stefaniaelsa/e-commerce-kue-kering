<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Item_Keranjang extends Model
{
    protected $table = 'item_keranjang';

    protected $fillable = [
        'id_keranjang',
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

    // Hapus relasi produk() karena sudah gak ada id_produk

    public function varian()
    {
        return $this->belongsTo(ProductVariant::class, 'id_varian');
    }
}
