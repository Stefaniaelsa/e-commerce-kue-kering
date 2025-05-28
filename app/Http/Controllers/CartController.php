<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Item_Keranjang;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderDetail;

class CartController extends Controller
{
    // Menampilkan isi keranjang pengguna yang sedang login
 public function index()
{
    $keranjang = Keranjang::where('user_id', Auth::id())
        ->where('status', 'keranjang')
        ->first();

    $cartItems = $keranjang ? $keranjang->Item_Keranjang()->with('varian.produk')->get() : collect();

    return view('keranjang', compact('cartItems'));
}

    // Menambahkan produk ke keranjang
  public function store(Request $request)
{
    $request->validate([
        'id_varian' => 'required|exists:product_variants,id',
        'jumlah' => 'required|integer|min:1',
    ]);

    $varian = ProductVariant::findOrFail($request->id_varian);
    $harga = $varian->harga;

    $subTotal = $harga * $request->jumlah;

    $keranjang = Keranjang::firstOrCreate(
        ['user_id' => Auth::id(), 'status' => 'keranjang'],
        ['total_harga' => 0]
    );

    // Cari item di keranjang berdasar varian
    $item = Item_Keranjang::where('id_keranjang', $keranjang->id)
        ->where('id_varian', $request->id_varian)
        ->first();

    if ($item) {
        $item->jumlah += $request->jumlah;
        $item->harga += $subTotal;
        $item->save();
    } else {
        Item_Keranjang::create([
            'id_keranjang' => $keranjang->id,
            'id_varian' => $request->id_varian,
            'jumlah' => $request->jumlah,
            'harga' => $subTotal,
        ]);
    }

    // Update total harga keranjang
    $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
    $keranjang->save();

    // Kurangi stok varian setelah dimasukkan ke keranjang
    $varian->stok -= $request->jumlah;
    $varian->save();

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
}


    // Menghapus item dari keranjang
    public function destroy($id)
    {
        $item = Item_Keranjang::findOrFail($id);
        $keranjang = $item->keranjang;

        $item->delete();

        // Update total harga keranjang
        $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
        $keranjang->save();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    // Mengubah jumlah item di keranjang
    public function update(Request $request, $id)
{
    $item = Item_Keranjang::findOrFail($id);

    $oldJumlah = $item->jumlah;

    if ($request->has('action')) {
        if ($request->action === 'increase') {
            $item->jumlah += 1;
        } elseif ($request->action === 'decrease' && $item->jumlah > 1) {
            $item->jumlah -= 1;
        }
    } elseif ($request->has('jumlah')) {
        $item->jumlah = max(1, (int) $request->jumlah);
    }

    $diffJumlah = $item->jumlah - $oldJumlah;

    $varian = ProductVariant::findOrFail($item->id_varian);
    $hargaSatuan = $varian->harga;

    $item->harga = $item->jumlah * $hargaSatuan;
    $item->save();

    // Penyesuaian stok varian
    $varian->stok -= $diffJumlah;
    $varian->save();

    $keranjang = $item->keranjang;
    $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
    $keranjang->save();

    return back()->with('success', 'Keranjang diperbarui dan stok disesuaikan');
}

public function checkout(Request $request)
{
    $user = Auth::user();

    // Validasi input checkout
    $request->validate([
        'alamat' => 'required|string',
        'pengiriman' => 'required|in:gojek,ambil ditempat',
        'catatan' => 'nullable|string',
    ]);

    $keranjang = Keranjang::where('user_id', $user->id)
        ->where('status', 'keranjang')
        ->with('Item_Keranjang') // pastikan relasi ini ada di model
        ->first();

    if (!$keranjang || $keranjang->Item_Keranjang->isEmpty()) {
        return back()->with('error', 'Keranjang kosong.');
    }

    DB::beginTransaction();

    try {
        // Buat pesanan baru
        $order = Order::create([
            'user_id' => $user->id,
            'total_harga' => $keranjang->total_harga,
            'status' => 'menunggu',
            'alamat_pengiriman' => $request->alamat,
            'pengiriman' => $request->pengiriman,
            'catatan' => $request->catatan,
        ]);

        // Pindahkan semua item ke order_items
        foreach ($keranjang->Item_Keranjang as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'varian_id' => $item->id_varian,
                'jumlah' => $item->jumlah,
                'harga' => $item->harga,
            ]);
        }

        // Tandai keranjang sudah selesai
        $keranjang->update(['status' => 'selesai']);

        DB::commit();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
    }
}


}
