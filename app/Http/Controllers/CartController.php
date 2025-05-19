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
        ]);

        $produk = Product::findOrFail($request->id_produk);
        $subTotal = $produk->harga * $request->jumlah;

        // Ambil atau buat keranjang baru untuk user dengan status 'keranjang'
        $keranjang = Keranjang::firstOrCreate(
            ['id_pengguna' => Auth::id(), 'status' => 'keranjang'],
            ['total_harga' => 0]
        );

        // Cek apakah item sudah ada dalam keranjang
        $item = Item_Keranjang::where('id_keranjang', $keranjang->id)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($item) {
            $item->jumlah += $request->jumlah;
            $item->harga += $subTotal;
            $item->save();
        } else {
            Item_Keranjang::create([
                'id_keranjang' => $keranjang->id,
                'id_produk' => $request->id_produk,
                'jumlah' => $request->jumlah,
                'harga' => $subTotal,
            ]);
        }

        // Update total harga keranjang
        $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
        $keranjang->save();

        return redirect()->route('cart.index');
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

    public function update(Request $request, $id)
    {
        $item = Item_Keranjang::with('produk')->findOrFail($id);

        if ($request->action == 'increase') {
            $item->jumlah += 1;
        } elseif ($request->action == 'decrease' && $item->jumlah > 1) {
            $item->jumlah -= 1;
        }

        // Pastikan relasi produk tidak null
        if ($item->produk) {
            $item->harga = $item->produk->harga * $item->jumlah;
            $item->save();

            // Update total harga keranjang
            $item->keranjang->total_harga = $item->keranjang->Item_Keranjang()->sum('harga');
            $item->keranjang->save();
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah diperbarui!');
    }
}
