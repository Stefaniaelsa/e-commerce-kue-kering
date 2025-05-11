<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products'; // Sesuaikan jika nama tabelnya berbeda

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'gambar'
    ];

    /**
     * Relasi dengan model ProductVariant.
     * Satu produk bisa memiliki banyak varian.
     */
    public function variants()
    {
        return $this->hasMany(Product_Variants::class, 'product_id');
    }
}
