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
        'harga',
        'stok',
        'gambar'
    ];

    public $timestamps = false;

    // Fungsi relasi ke varian produk
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
