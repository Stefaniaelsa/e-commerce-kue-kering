<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_harga',
        'status',
        'metode_pembayaran',
        'alamat_pengiriman',
        'tanggal_pesanan',
        'bank_tujuan',
        'no_rekening',
        'pengiriman'
    ];
}
