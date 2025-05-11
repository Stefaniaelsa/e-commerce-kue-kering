<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;


class ProductsController extends Controller
{
    public function show($id)
    {
        $produk = \App\Models\Products::findOrFail($id);
        return view('produk-detail', compact('produk'));
    }
}
