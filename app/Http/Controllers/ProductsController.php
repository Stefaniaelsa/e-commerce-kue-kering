<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    // Untuk beranda
    public function beranda()
    {
        $bestSellerProduk = Product::where('kategori', 'best_seller')->get();
        $favoritProduk = Product::where('kategori', 'favorit')->get();
        return view('beranda', compact('bestSellerProduk', 'favoritProduk'));
    }

    // Untuk halaman produk
    public function index()
    {
        $produks = Product::all();
        return view('produk', compact('produks'));
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $produk = Product::with('variants')->findOrFail($id);
        return view('produk-detail', compact('produk'));
    }
}
