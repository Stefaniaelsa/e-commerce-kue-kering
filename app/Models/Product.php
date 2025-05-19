<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'is_best_seller',
        'is_favorit',
    ];

    public $timestamps = false;

    /**
     * Relasi ke semua varian produk
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Relasi ke varian default (ukuran NULL)
     */
    public function defaultVariant()
    {
        return $this->hasOne(ProductVariant::class)->whereNull('ukuran');
    }

    /**
     * Accessor untuk harga produk (dari varian default)
     */
    public function getHargaAttribute()
    {
        return $this->defaultVariant ? $this->defaultVariant->harga : null;
    }

    /**
     * Accessor untuk stok produk (dari varian default)
     */
    public function getStokAttribute()
    {
        return $this->defaultVariant ? $this->defaultVariant->stok : null;
    }



}
