<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductVariantController extends Controller
{
    public function show($id)
    {
        // Mencari produk berdasarkan ID, beserta varian produk yang terkait
        $produk = Product::with('variants')->findOrFail($id);

        // Menampilkan halaman detail produk dengan data produk
        return view('produk-detail', compact('produk'));
    }
}

