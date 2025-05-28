<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'alamat'             => 'required|string|max:255',
            'metode_pembayaran'  => 'required|in:transfer,cod',
            'metode_pengiriman'  => 'required|in:gojek,ambil',
        ]);

        // Ambil data keranjang milik user
        $cartItems = Keranjang::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kamu kosong.');
        }

        DB::beginTransaction();

        try {
            $subtotal = $cartItems->sum('harga');
            // Ongkir hanya berlaku jika pengiriman gojek
            $ongkir = ($request->input('metode_pengiriman') === 'gojek') ? 10000 : 0;
            $total = $subtotal + $ongkir;

            // Simpan data order baru
            $order = Order::create([
                'user_id'           => $user->id,
                'total_harga'       => $total,
                'status'            => 'Menunggu Pembayaran',
                'alamat_pengiriman' => $request->input('alamat'),
                'tanggal_pesanan'   => now(),
                'pengiriman'        => $request->input('metode_pengiriman'), // simpan metode pengiriman
                'catatan'           => $request->input('catatan') ?? null,
            ]);

            // Simpan detail order per item di keranjang
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'variant_id' => $item->variant_id, // Sesuaikan nama kolom jika berbeda
                    'jumlah'     => $item->jumlah,
                    'harga'      => $item->harga / max(1, $item->jumlah), // Harga per item
                    'sub_total'  => $item->harga,
                ]);
            }

            // Hapus data keranjang user setelah order sukses
            Keranjang::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('checkout')->with('success', 'Pesanan berhasil dibuat. Silakan lanjut ke pembayaran.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal membuat pesanan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }
}
