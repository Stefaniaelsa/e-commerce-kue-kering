<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'alamat' => 'required|string|max:255',
            'metode_pembayaran' => 'required|in:transfer,cod',
            'metode_pengiriman' => 'required|in:gojek,ambil ditempat',
        ]);

        // Ambil data keranjang milik user
        $cartItems = Keranjang::with('item_keranjang')
            ->where('user_id', $user->id)
            ->first();

        if ($cartItems === null) {
            return redirect()->back()->with('error', 'Keranjang kamu kosong.');
        }

        DB::beginTransaction();

        try {
            $subtotal = $cartItems->total_harga;
            $ongkir = ($request->input('metode_pengiriman') === 'gojek') ? 10000 : 0;
            $total = $subtotal + $ongkir;

            // Set status berdasarkan metode pembayaran
            $status = $request->input('metode_pembayaran') === 'cod' ? 'diproses' : 'menunggu';

            // Simpan data order baru
            $order = Order::create([
                'user_id' => $user->id,
                'total_harga' => $total,
                'status' => $status,
                'alamat_pengiriman' => $request->input('alamat'),
                'tanggal_pesanan' => now(),
                'pengiriman' => $request->input('metode_pengiriman'),
                'metode_pembayaran' => $request->input('metode_pembayaran'),
                'catatan' => $request->input('catatan') ?? null,
            ]);

            // Simpan detail order per item di keranjang
            foreach ($cartItems->item_keranjang as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'varian_id'  => $item->id_varian,
                    'jumlah'     => $item->jumlah,
                    'harga'      => $item->harga / max(1, $item->jumlah), // Harga per item
                    'sub_total'  => $item->harga,
                ]);
            }

            // Hapus data keranjang user setelah order sukses
            Keranjang::where('user_id', $user->id)->delete();
            Session::forget('total-produk');

            DB::commit();

            // Redirect berdasarkan metode pembayaran
            if ($request->input('metode_pembayaran') === 'cod') {
                return redirect()->route('beranda')->with('success', 'Pesanan COD berhasil dibuat. Silakan tunggu pesanan dikirim.');
            } else {
                return redirect()->route('pembayaran')->with('success', 'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal membuat pesanan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }
}
