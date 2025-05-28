<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'total_harga',
        'status',
        'alamat_pengiriman',
        'tanggal_pesanan',
        'pengiriman',
        'catatan',
    ];

    protected $dates = ['tanggal_pesanan'];

    // Relasi ke user (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke order details
      public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
