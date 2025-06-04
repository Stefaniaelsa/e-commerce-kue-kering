<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_Keranjang;
use App\Models\Keranjang;
use App\Models\Order;

class PesananController extends Controller
{
    // Method gabungan untuk menampilkan halaman pesanan / konfirmasi
   public function index(Request $request)
{
    $itemIds = $request->input('items');

    if ($itemIds) {
        $cartItems = Item_Keranjang::with('varian.produk')
            ->whereIn('id', $itemIds)
            ->get();
    } else {
        $cartItems = Keranjang::with(['item_Keranjang.varian.produk'])
            ->where('user_id', auth()->id())
            ->first()?->item_Keranjang ?? collect();
    }

    $user = auth()->user();
    $totalHarga = $cartItems->sum('harga') + 10000;

    // Hanya menampilkan halaman, tanpa buat order baru
    return view('pesanan', compact('cartItems', 'user', 'totalHarga'));
}

public function store(Request $request)
{
    // Validasi data jika perlu
    $request->validate([
        'items' => 'required|array',
    ]);

    $itemIds = $request->input('items');

    $cartItems = Item_Keranjang::whereIn('id', $itemIds)->get();

    $totalHarga = $cartItems->sum('harga') + 10000;

    // Simpan order baru
    $order = Order::create([
        'user_id' => auth()->id(),
        'total_harga' => $totalHarga,
        'status' => 'menunggu',
    ]);

    // Simpan detail order atau proses lainnya sesuai kebutuhan...

    // Redirect ke halaman sukses atau riwayat pesanan
    return redirect()->route('pesanan.sukses')->with('success', 'Pesanan berhasil dibuat!');
}


public function prosesPesanan(Request $request)
{
    $request->validate([
        'alamat' => 'required|string',
        'metode_pengiriman' => 'required',
        'metode_pembayaran' => 'required',
        'bank_tujuan' => 'required_if:metode_pembayaran,transfer',
    ]);

    $user = auth()->user();
    $cart = Keranjang::where('user_id', $user->id)->first();

    if (!$cart || $cart->item_Keranjang->isEmpty()) {
        return redirect()->back()->with('error', 'Keranjang Anda kosong.');
    }

    $totalHarga = $cart->item_Keranjang->sum('harga');
    $ongkir = $request->metode_pengiriman === 'ambil' ? 0 : 10000;
    $grandTotal = $totalHarga + $ongkir;

    // Simpan order utama
    $order = Order::create([
        'user_id' => $user->id,
        'alamat' => $request->alamat,
        'metode_pengiriman' => $request->metode_pengiriman,
        'metode_pembayaran' => $request->metode_pembayaran,
        'bank_tujuan' => $request->bank_tujuan,
        'catatan' => $request->catatan,
        'total_harga' => $grandTotal,
        'status' => 'menunggu',
        'tanggal_pesanan' => now(),
    ]);

    foreach ($cart->item_Keranjang as $item) {
        $order->order_details()->create([
            'produk_id' => $item->varian->produk->id,
            'varian_id' => $item->varian_id,
            'jumlah' => $item->jumlah,
            'harga' => $item->harga,
        ]);
    }

    // Hapus isi keranjang setelah dipesan
    $cart->item_Keranjang()->delete();

    return redirect('/beranda')->with('success', 'Pesanan berhasil dibuat!');
}

}