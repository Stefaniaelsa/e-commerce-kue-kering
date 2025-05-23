<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Item_Keranjang;
use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{
    // Menampilkan isi keranjang pengguna yang sedang login
    public function index()
    {
        $keranjang = Keranjang::where('id_pengguna', Auth::id())
            ->where('status', 'keranjang') // sesuai enum migrasi
            ->first();

        // Ambil item keranjang jika ada, atau kosongkan koleksi
        $cartItems = $keranjang ? $keranjang->Item_Keranjang()->with(['produk', 'varian'])->get() : collect();


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

        // Cek varian, jika ada
        if ($request->filled('id_varian')) {
            $varian = ProductVariant::findOrFail($request->id_varian);
            $harga = $varian->harga;
        } else {
            // Ambil varian default jika varian tidak dipilih
            $varian = ProductVariant::where('product_id', $produk->id)
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

        // Cek apakah item sudah ada di keranjang
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

        // Update total harga keranjang
        $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
        $keranjang->save();

        // Kurangi stok varian atau produk setelah item berhasil dimasukkan ke keranjang
        if ($request->filled('id_varian')) {
            $varian->stok -= $request->jumlah;
            $varian->save();
        } else {
            $produk->stok -= $request->jumlah;
            $produk->save();
        }


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

        // Simpan stok lama untuk penyesuaian
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

        // Hitung selisih quantity
        $diffJumlah = $item->jumlah - $oldJumlah;

        // Update harga
        $hargaSatuan = $item->id_varian
            ? ProductVariant::find($item->id_varian)?->harga
            : $item->produk->harga;

        $item->harga = $item->jumlah * $hargaSatuan;
        $item->save();

        // Penyesuaian stok sesuai selisih quantity
        if ($item->id_varian) {
            $varian = ProductVariant::find($item->id_varian);
            $varian->stok -= $diffJumlah;  // kurang atau tambah stok
            $varian->save();
        } else {
            $produk = Product::find($item->id_produk);
            $produk->stok -= $diffJumlah; // kurang atau tambah stok
            $produk->save();
        }

        $keranjang = $item->keranjang;
        $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
        $keranjang->save();

        return back()->with('success', 'Keranjang diperbarui dan stok disesuaikan');
    }
}
