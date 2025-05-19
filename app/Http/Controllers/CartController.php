<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Item_Keranjang;
use App\Models\Product;

class CartController extends Controller
{
    // Menampilkan isi keranjang pengguna yang sedang login
    public function index()
    {
        $keranjang = Keranjang::where('id_pengguna', Auth::id())
            ->where('status', 'keranjang') // sesuai dengan enum di migrasi
            ->first();

        // Ambil item keranjang jika ada, atau kosongkan koleksi
        $cartItems = $keranjang ? $keranjang->Item_Keranjang()->with('produk')->get() : collect();

        return view('keranjang', compact('cartItems'));
    }

    // Menambahkan produk ke keranjang
 public function store(Request $request)
{
    $request->validate([
        'id_produk' => 'required|exists:products,id',
        'jumlah' => 'required|integer|min:1',
        'id_varian' => 'nullable|exists:product_variants,id',
    ]);

    $produk = Product::findOrFail($request->id_produk);

    // Cek apakah pakai varian
    if ($request->filled('id_varian')) {
        $varian = \App\Models\ProductVariant::findOrFail($request->id_varian);
        $harga = $varian->harga;
    } else {
        // Jika tidak memilih varian, ambil varian default (misalnya ukuran NULL)
        $varian = \App\Models\ProductVariant::where('product_id', $produk->id)
            ->whereNull('ukuran')
            ->first();

        if (!$varian) {
            return back()->with('error', 'Produk tidak memiliki varian default.');
        }

        $harga = $varian->harga;
    }

    $subTotal = $harga * $request->jumlah;

    $keranjang = Keranjang::firstOrCreate(
        ['id_pengguna' => Auth::id(), 'status' => 'keranjang'],
        ['total_harga' => 0]
    );

    $item = Item_Keranjang::where('id_keranjang', $keranjang->id)
        ->where('id_produk', $request->id_produk)
        ->where('id_varian', $request->id_varian)
        ->first();

    if ($item) {
        $item->jumlah += $request->jumlah;
        $item->harga += $subTotal;
        $item->save();
    } else {
        Item_Keranjang::create([
            'id_keranjang' => $keranjang->id,
            'id_produk' => $request->id_produk,
            'id_varian' => $request->id_varian,
            'jumlah' => $request->jumlah,
            'harga' => $subTotal,
        ]);
    }

    $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
    $keranjang->save();

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

        return redirect()->route('cart.index');
    }

    // Mengubah jumlah item di keranjang
 public function update(Request $request, $id)
    {
        $item = Item_Keranjang::findOrFail($id);
        $item->jumlah = $request->input('jumlah');
        // Hitung ulang harga subtotal per item (jumlah * harga satuan produk/variant)
        $hargaSatuan = $item->variant ? $item->variant->harga : $item->produk->harga;
        $item->harga = $hargaSatuan * $item->jumlah;
        $item->save();

        return redirect()->back()->with('success', 'Jumlah item berhasil diperbarui');
    }

}

