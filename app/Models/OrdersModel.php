<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'total_harga', 'status', 'metode_pembayaran', 'alamat_pengiriman', 'tanggal_pesanan', 'bank_tujuan', 'no_rekening', 'pengiriman',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

