<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'alamat'             => 'required|string|max:255',
            'metode_pembayaran'  => 'required|in:transfer,cod',
            'bank_tujuan'        => 'required_if:metode_pembayaran,transfer',
        ], [
            'bank_tujuan.required_if' => 'Silakan pilih bank tujuan jika metode pembayaran adalah transfer.'
        ]);

        // Ganti user_id menjadi id_pengguna sesuai kolom di tabel keranjang
        $cartItems = Keranjang::where('id_pengguna', $user->id)->get();

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
                'metode_pembayaran' => $request->input('metode_pembayaran'),
                'alamat_pengiriman' => $request->input('alamat'),
                'tanggal_pesanan'   => now(),
                'bank_tujuan'       => $request->input('bank_tujuan') ?? null,
                'no_rekening'       => '123456', // Atau ambil dari pengaturan toko
                'pengiriman'        => 'Reguler',
                'catatan'           => $request->input('catatan') ?? null,
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'variant_id' => $item->variant_id,
                    'jumlah'     => $item->jumlah,
                    'harga'      => $item->harga / max(1, $item->jumlah), // Hindari pembagian nol
                    'sub_total'  => $item->harga,
                ]);
            }

            Keranjang::where('id_pengguna', $user->id)->delete();

            DB::commit();

            return redirect()->route('checkout')->with('success', 'Pesanan berhasil dibuat. Silakan lanjut ke pembayaran.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
