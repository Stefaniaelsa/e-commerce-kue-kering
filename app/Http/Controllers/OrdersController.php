<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_Keranjang;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $itemIds = $request->input('items', []);

        if (empty($itemIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu item untuk dipesan');
        }

        $userId = Auth::id();

        DB::beginTransaction();
        try {
            // Buat order baru
            $order = Order::create([
                'id_pengguna' => $userId,
                'status' => 'pending',
                'total_harga' => 0, // nanti diupdate setelah hitung total
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);

            $items = Item_Keranjang::with(['produk', 'variant'])
                ->whereIn('id', $itemIds)
                ->get();

            $totalHarga = 0;

            foreach ($items as $item) {
                $hargaSatuan = $item->variant ? $item->variant->harga : $item->produk->harga;
                $subtotal = $hargaSatuan * $item->jumlah;

                // Buat order detail
                Order_Detail::create([
                    'id_order' => $order->id,
                    'id_produk' => $item->id_produk,
                    'id_varian' => $item->id_varian,
                    'jumlah' => $item->jumlah,
                    'harga' => $subtotal,
                    'dibuat_pada' => now(),
                    'diperbarui_pada' => now(),
                ]);

                $totalHarga += $subtotal;

                // Hapus item dari keranjang
                $item->delete();
            }

            // Update total harga order
            $order->total_harga = $totalHarga;
            $order->save();

            DB::commit();

            return redirect()->route('order.success')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }
    }
}
