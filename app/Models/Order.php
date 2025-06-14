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
        'metode_pembayaran',
        'catatan',
    ];

    protected $dates = ['tanggal_pesanan'];

    // Relasi ke user (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Relasi ke produk melalui order items
    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'order_id', 'id', 'id', 'varian_id');
    }

    // Relasi ke varian produk melalui order items
    public function variants()
    {
        return $this->hasManyThrough(ProductVariant::class, OrderItem::class, 'order_id', 'id', 'id', 'varian_id');
    }

    public function isExpired()
    {
        if ($this->status !== 'menunggu' || $this->metode_pembayaran !== 'transfer') {
            return false;
        }

        return now()->diffInHours($this->tanggal_pesanan) >= 24;
    }

    public function checkAndUpdateExpired()
    {
        if ($this->isExpired()) {
            // Update status menjadi dibatalkan
            $this->update(['status' => 'dibatalkan']);

            // Kembalikan stok
            foreach ($this->orderItems as $orderItem) {
                $variant = $orderItem->variant;
                if ($variant) {
                    $variant->increment('stok', $orderItem->jumlah);
                }
            }

            return true;
        }

        return false;
    }

    public function getDeadlineTime()
    {
        return $this->tanggal_pesanan->addHours(24);
    }

    public function getRemainingTime()
    {
        if ($this->status !== 'menunggu' || $this->metode_pembayaran !== 'transfer') {
            return null;
        }

        $deadline = $this->getDeadlineTime();
        $now = now();

        if ($now->gt($deadline)) {
            return 'Waktu pembayaran telah habis';
        }

        return $now->diffForHumans($deadline, ['parts' => 2]);
    }
}
