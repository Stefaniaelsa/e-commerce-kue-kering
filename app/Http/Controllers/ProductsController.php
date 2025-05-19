<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{

// untuk beranda
public function beranda()
{
    $bestSellerProduk = Product::where('kategori', 'best seller')->get();
    $favoritProduk = Product::where('kategori', 'favorit')->get();
    return view('beranda', compact('bestSellerProduk', 'favoritProduk'));
}

// untuk halaman produk
public function index()
{
    $produks = Product::all();
    return view('produk', compact('produks'));
}



public function show($id)
    {
        // Mencari produk berdasarkan ID, beserta varian produk yang terkait
        $produk = Product::with('variants')->findOrFail($id);
        // Menampilkan halaman detail produk dengan data produk
        return view('produk-detail', compact('produk'));
    }
}
