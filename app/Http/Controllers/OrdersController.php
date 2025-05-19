<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Details;
use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cari data produk dan varian
        $produk = Product::findOrFail($validated['product_id']);
        $variant = ProductVariant::findOrFail($validated['variant_id']);

        // Hitung subtotal
        $hargaPerItem = $produk->harga + $variant->harga_tambahan;
        $subTotal = $hargaPerItem * $validated['quantity'];

        // Buat data pesanan (order)
        $order = Order::create([  // Use the correct model here
            'user_id' => auth()->id(),
            'total_harga' => $subTotal,
            'status' => 'pending',
            'metode_pembayaran' => 'belum dipilih',
            'alamat_pengiriman' => 'belum diisi',
            'tanggal_pesanan' => now(),
            'bank_tujuan' => null,
            'no_rekening' => null,
            'pengiriman' => null,
        ]);

        // Tambahkan detail pesanan (order_detail)
        Order_Details::create([  // Use the correct model here
            'order_id' => $order->id,
            'variant_id' => $variant->id,
            'jumlah' => $validated['quantity'],
            'harga' => $hargaPerItem,
            'sub_total' => $subTotal,
        ]);

        // Redirect ke halaman konfirmasi
        return redirect()->route('order.confirm', ['order' => $order->id]);
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userId = auth()->id();  // cek apakah nilainya muncul
        $orders = Order::where('user_id', $userId)->get();

        return view('pesanan-detail', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderDetails.variant.product'])->findOrFail($id);
        return view('pesanan-detail', compact('order'));
    }
}
