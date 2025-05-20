<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_Keranjang;

class CheckoutController extends Controller
{
    public function showForm(Request $request)
    {
        // Validasi dan ambil item berdasarkan input
        $items = Item_Keranjang::whereIn('id', $request->items)->get();
        return view('checkout', compact('items'));
    }

    public function simpan(Request $request)
    {
        // Simpan order ke database
        // Validasi, hitung total, simpan ke tabel orders dan order_details
    }
}
