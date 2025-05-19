<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Menampilkan form untuk menambah produk baru
    public function create()
    {
        return view('admin.products.create');
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'has_variants' => 'nullable|boolean',
            'ukuran' => 'nullable|in:kecil,sedang,besar',
            'variant_harga' => 'nullable|numeric',
            'variant_stok' => 'nullable|integer',
        ]);

        // Simpan produk umum
        $product = Product::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            // Simpan gambar ke folder public/images jika ada
            'gambar' => $request->hasFile('gambar') ? $request->file('gambar')->store('images', 'public') : null,
        ]);

        // Jika produk memiliki varian
        if ($request->has('has_variants')) {
            ProductVariant::create([
                'product_id' => $product->id,
                'ukuran' => $request->ukuran,
                'harga' => $request->variant_harga,
                'stok' => $request->variant_stok,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id){
        $product = Product::findOrFail($id);
        // die($produk);
        return view('admin.products.edit', compact('product'));
    }

    // Mengupdate produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'ukuran' => 'nullable|in:kecil,sedang,besar',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->nama = $request->nama;
        $product->deskripsi = $request->deskripsi;
        $product->harga = $request->harga;
        $product->stok = $request->stok;
        $product->ukuran = $request->ukuran;

        // Update gambar jika ada
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('public/products');
            $product->gambar = basename($gambarPath);
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
