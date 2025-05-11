<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Variants extends Model
{
    protected $table = 'product_variants'; // Sesuaikan jika nama tabel di database berbeda

    protected $fillable = [
        'product_id',
        'ukuran',
        'harga_tambahan'
    ];

    /**
     * Relasi ke model produk.
     * Setiap varian milik satu produk.
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
