<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'varian_id',
        'jumlah',
        'harga',
        // 'sub_total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->variant ? $this->variant->product : null;
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'varian_id');
    }
}

