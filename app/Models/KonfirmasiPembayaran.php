<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KonfirmasiPembayaran extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi_pembayaran'; // sesuaikan jika nama tabel bukan plural

    protected $fillable = [
        'order_id',
        'metode',
        'bukti_transfer',
        'status',
    ];

    /**
     * Relasi ke model Order (jika ada)
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
