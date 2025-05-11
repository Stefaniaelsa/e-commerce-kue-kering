<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Details extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'variant_id',
        'jumlah',
        'harga',
        'sub_total',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function variant()
    {
        return $this->belongsTo(Product_Variants::class, 'variant_id');
    }
}
