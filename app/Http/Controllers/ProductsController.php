<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function show($id)
    {
        // Mencari produk berdasarkan ID, beserta varian produk yang terkait
        $produk = Product::with('variants')->findOrFail($id);
        //die($produk);
        // Menampilkan halaman detail produk dengan data produk
        return view('produk-detail', compact('produk'));
    }


    public function index(){
        $produks = Product::all();
        // die($produks);
        return view('produk', compact('produks'));
    }
}
