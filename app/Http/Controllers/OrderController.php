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
use App\Models\Alamat;


class OrderController extends Controller
{
  
public function store(Request $request)
{
    $user = Auth::user();

    // Ambil data alamat pengguna
    $alamatModel = \App\Models\Alamat::where('user_id', $user->id)->first();

    if (!$alamatModel && $request->input('metode_pengiriman') === 'kurir') {
        return redirect()->back()->with('error', 'Alamat belum tersedia untuk pengiriman dengan kurir.');
    }


    // Susun alamat dalam bentuk string
    $alamatText = $alamatModel
        ? "{$alamatModel->jalan}, {$alamatModel->kelurahan}, {$alamatModel->kecamatan}, {$alamatModel->provinsi}"
        : '-';

    // Masukkan ke request agar bisa divalidasi
    $request->merge(['alamat' => $alamatText]);

    // Validasi
    $request->validate([
        'alamat' => 'required|string|max:255',
        'metode_pembayaran' => 'required|in:transfer,bayar ditempat',
        'metode_pengiriman' => 'required|in:kurir,ambil ditempat',
    ]);

    // Cek kombinasi pengiriman dan pembayaran
    if (
        $request->metode_pengiriman === 'kurir' &&
        $request->metode_pembayaran === 'bayar ditempat'
    ) {
        return redirect()->back()->with('error', 'Pengiriman dengan kurir hanya bisa dibayar melalui transfer.');
    }

    $cartItems = Keranjang::with('item_keranjang')
        ->where('user_id', $user->id)
        ->first();

    if ($cartItems === null) {
        return redirect()->back()->with('error', 'Keranjang kamu kosong.');
    }

    DB::beginTransaction();

    try {
        $subtotal = $cartItems->item_keranjang->sum('harga');
        $ongkir = ($request->input('metode_pengiriman') === 'kurir') ? 10000 : 0;
        $total = $subtotal + $ongkir;

        $status = $request->input('metode_pembayaran') === 'bayar ditempat' ? 'diproses' : 'menunggu';
        \Log::info('Pengiriman: ' . $request->metode_pengiriman);
        \Log::info('Alamat ID: ' . ($alamatModel->id ?? 'NULL'));

        $order = Order::create([
            'user_id' => $user->id,
            'total_harga' => $total,
            'status' => $status,
            'alamat_pengiriman' => $alamatText,
            'alamat_id' => ($request->input('metode_pengiriman') === 'kurir' && $alamatModel) ? $alamatModel->id : null,
            'tanggal_pesanan' => now(),
            'pengiriman' => $request->input('metode_pengiriman'),
            'metode_pembayaran' => $request->input('metode_pembayaran'),
            'catatan' => $request->input('catatan') ?? null,
        ]);

        foreach ($cartItems->item_keranjang as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'varian_id'  => $item->id_varian,
                'jumlah'     => $item->jumlah,
                'harga'      => $item->harga / max(1, $item->jumlah),
                'sub_total'  => $item->harga,
            ]);

             $varian = \App\Models\ProductVariant::find($item->id_varian);
            if ($varian) {
                if ($item->jumlah > $varian->stok) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Stok produk {$varian->ukuran} tidak mencukupi.");
                }

                $varian->stok -= $item->jumlah;
                $varian->save();
            }
        }

        Keranjang::where('user_id', $user->id)->delete();
        Session::forget('total-produk');
        DB::commit();

        if ($request->input('metode_pembayaran') === 'bayar ditempat') {
            return redirect()->route('beranda')->with('success', 'Pesanan bayar ditempat berhasil dibuat. Silakan tunggu pesanan dikirim.');
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