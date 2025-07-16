<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    // Untuk beranda
public function beranda()
{
    $produks = Product::with('defaultVariant')->get();
    $keranjang = \App\Models\Keranjang::where('user_id', auth()->id())->first();
    session(['total_produk' => $keranjang ? $keranjang->total_produk : 0]);

    // Query Best Seller: hanya produk yang terjual lebih dari 1
    $bestSellerProduk = DB::table('order_items as oi')
        ->join('product_variants as pv', 'oi.varian_id', '=', 'pv.id')
        ->join('products as p', 'pv.product_id', '=', 'p.id')
        ->select('p.id', 'p.nama', 'p.gambar', DB::raw('SUM(oi.jumlah) as total_terjual'))
        ->groupBy('p.id', 'p.nama', 'p.gambar')
        ->having('total_terjual', '>', 1)
        ->orderByDesc('total_terjual')
        ->get();

    return view('beranda', compact('produks', 'bestSellerProduk'));
}


    // Untuk halaman produk
    public function index()
    {
        $produks = Product::orderBy('nama', 'asc')->get();
        return view('produk', compact('produks'));
    }


    // Menampilkan detail produk
    public function show($id)
    {
        $produk = Product::with('variants')->findOrFail($id);
        return view('produk-detail', compact('produk'));
    }

  public function search(Request $request)
    {
        $query = $request->input('query');

        $produks = Product::where('nama', 'LIKE', '%' . $query . '%')
            ->orWhere('deskripsi', 'LIKE', '%' . $query . '%')
            ->orderBy('nama', 'asc')
            ->limit(10)
            ->get();

        return response()->json($produks);
    }

}
