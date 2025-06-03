<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\ProductVariant;

class Order_DetailsController extends Controller
{
    // Tampilkan detail dari sebuah order
    public function index($order_id)
    {
        $orderDetails = OrderItem::where('order_id', $order_id)->with('variant', 'order')->get();

        return view('order_details.index', compact('orderDetails'));
    }

    // Tampilkan form tambah detail (opsional)
    public function create()
    {
        $orders = Order::all();
        $variants = ProductVariant::all();
        return view('order_details.create', compact('orders', 'variants'));
    }

    // Simpan detail baru (opsional)
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'variant_id' => 'required|exists:product_variants,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        OrderItem::create([
            'order_id' => $request->order_id,
            'variant_id' => $request->variant_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'sub_total' => $request->jumlah * $request->harga,
        ]);

        return redirect()->route('order_details.index', $request->order_id)
            ->with('success', 'Detail pesanan berhasil ditambahkan.');
    }

    // Hapus detail
    public function destroy($id)
    {
        $orderDetail = OrderItem::findOrFail($id);
        $order_id = $orderDetail->order_id;
        $orderDetail->delete();

        return redirect()->route('order_details.index', $order_id)
            ->with('success', 'Detail pesanan berhasil dihapus.');
    }
}
