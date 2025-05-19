<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'ukuran',
        'harga',
        'stok',
    ];

    public $timestamps = false;

    /**
     * Casts untuk memastikan tipe data konsisten
     */
    protected $casts = [
        'harga' => 'decimal:2',
        'stok'  => 'integer',
    ];

    /**
     * Scope untuk varian default (ukuran NULL)
     */
    public function scopeDefault($query)
    {
        return $query->whereNull('ukuran');
    }

    /**
     * Relasi ke produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
