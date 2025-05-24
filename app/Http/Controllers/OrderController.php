<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Simpan pesanan baru dari keranjang
     */
    public function store(Request $request)
    {
        $cartItemIds = $request->input('items', []);

        if (empty($cartItemIds)) {
            return redirect()->back()->with('error', 'Tidak ada item yang dipilih untuk dipesan.');
        }

        // Ambil item keranjang yang sesuai milik user yang sedang login
        $cartItems = Keranjang::whereIn('id', $cartItemIds)
            ->where('id_pengguna', Auth::id())
            ->with(['produk', 'varian'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Item keranjang tidak ditemukan atau tidak valid.');
        }

        DB::beginTransaction();

        try {
            // Hitung total harga (termasuk ongkos kirim Rp10.000)
            $subtotal = $cartItems->sum('harga');
            $ongkir = 10000;
            $totalHarga = $subtotal + $ongkir;

            // Buat pesanan baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_harga' => $totalHarga,
                'status' => 'pending',
                'tanggal_pesanan' => Carbon::now(),
                // Tambahkan kolom lain seperti alamat_pengiriman, metode_pembayaran jika perlu
            ]);

            // Simpan setiap item ke dalam order_details
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'variant_id' => $item->variant_id,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->jumlah > 0 ? ($item->harga / $item->jumlah) : 0,
                    'sub_total' => $item->harga,
                ]);
            }

            // Hapus item dari keranjang
            Keranjang::whereIn('id', $cartItemIds)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail pesanan berdasarkan ID
     */
    public function show($id)
    {
        $order = Order::with(['details.variant.produk'])
            ->where('user_id', Auth::id()) // hanya user terkait yang bisa lihat
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}
