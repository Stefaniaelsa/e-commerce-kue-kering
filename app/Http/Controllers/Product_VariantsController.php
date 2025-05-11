<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductVariantController extends Controller
{
    public function show($id)
    {
        // Mencari produk berdasarkan ID, beserta varian produk yang terkait
        $produk = Products::with('variants')->findOrFail($id);

        // Menampilkan halaman detail produk dengan data produk
        return view('produk-detail', compact('produk'));
    }
}
