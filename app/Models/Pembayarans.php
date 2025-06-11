<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayarans extends Model
{
    use HasFactory;
    protected $table = 'pembayarans';
    protected $fillable = [
        'order_id',
        'metode',
        'bank_asal',
        'bukti_transfer',
        'status',
    ];
}
