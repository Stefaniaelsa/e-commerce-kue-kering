<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class Order_DetailsController extends Controller
{
    /**
     * Menampilkan semua detail pesanan berdasarkan ID order.
     */
    public function show($orderId)
    {
        $order = Order::with('details.variant')->findOrFail($orderId);
        return view('orders.details', compact('order'));
    }

    /**
     * Menambahkan detail pesanan ke order yang sudah ada (opsional).
     */
    public function store(Request $request, $orderId)
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($validated['variant_id']);
        $harga = $variant->product->harga + $variant->harga_tambahan;
        $subTotal = $harga * $validated['jumlah'];

        // Simpan detail pesanan
        OrderDetail::create([
            'order_id' => $orderId,
            'variant_id' => $variant->id,
            'jumlah' => $validated['jumlah'],
            'harga' => $harga,
            'sub_total' => $subTotal,
        ]);

        // Update total harga di tabel order
        $order = Order::findOrFail($orderId);
        $order->total_harga += $subTotal;
        $order->save();

        return redirect()->route('order.details', ['orderId' => $orderId])
                         ->with('success', 'Detail pesanan berhasil ditambahkan.');
    }


}
