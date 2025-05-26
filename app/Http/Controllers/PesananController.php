<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_Keranjang;
use App\Models\Keranjang;
use App\Models\Order;

class PesananController extends Controller
{
    public function show(Request $request)
    {
        $itemIds = $request->input('items', []);
        $cartItems = Item_Keranjang::with(['produk', 'varian'])
            ->whereIn('id', $itemIds)
            ->get();

        return view('pesanan', compact('cartItems'));
    }
    public function pesanan()
    {
        $cartItems = Keranjang::where('user_id', auth()->id())->get();
        $order = Order::where('user_id', auth()->id())->latest()->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_harga' => $cartItems->sum('harga') + 10000,
                'status' => 'pending',
            ]);
        }

        $user = auth()->user();  // Ambil data user dari session login

        return view('pesanan', compact('cartItems', 'order', 'user'));
    }
}
