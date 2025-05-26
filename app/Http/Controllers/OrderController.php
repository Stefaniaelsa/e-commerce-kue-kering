<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'alamat_pengiriman' => 'required|string|max:255',
        ]);

        $cartItems = Keranjang::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kamu kosong.');
        }

        DB::beginTransaction();

        try {
            $subtotal = $cartItems->sum('harga');
            $ongkir = 10000;
            $total = $subtotal + $ongkir;

            $order = Order::create([
                'user_id'           => $user->id,
                'total_harga'       => $total,
                'status'            => 'Menunggu Pembayaran',
                'metode_pembayaran' => 'Transfer Bank',
                'alamat_pengiriman' => $request->input('alamat_pengiriman'),
                'tanggal_pesanan'   => now(),
                'pengiriman'        => 'Reguler',
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'variant_id' => $item->variant_id,
                    'jumlah'     => $item->jumlah,
                    'harga'      => $item->harga / max(1, $item->jumlah), // Hindari pembagian 0
                    'sub_total'  => $item->harga,
                ]);
            }

            Keranjang::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('checkout')
                ->with('success', 'Pesanan berhasil dibuat. Silakan lanjut ke pembayaran.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }
}
