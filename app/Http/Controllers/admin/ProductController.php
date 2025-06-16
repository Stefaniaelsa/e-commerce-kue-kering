<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('variants')->paginate(10); 
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->merge(['has_variants' => $request->has('has_variants')]);

        $rules = [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->has_variants) {
            foreach ($request->variants as $index => $variant) {
                if (isset($variant['enabled'])) {
                    $rules["variants.$index.ukuran"] = 'required|in:kecil,sedang,besar';
                    $rules["variants.$index.harga"] = 'required|numeric';
                    $rules["variants.$index.stok"] = 'required|integer';
                }
            }
        } else {
            $rules['harga'] = 'required|numeric';
            $rules['stok'] = 'required|integer';
        }

        $request->validate($rules);

        $filename = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
        }

        $product = Product::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'gambar' => $filename,
            'is_best_seller' => $request->has('is_best_seller') ? 1 : 0,
            'is_favorit' => $request->has('is_favorit') ? 1 : 0,
        ]);

        if ($request->has_variants) {
            foreach ($request->variants as $variant) {
                if (isset($variant['enabled'])) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'ukuran' => $variant['ukuran'],
                        'harga' => $variant['harga'],
                        'stok' => $variant['stok'],
                    ]);
                }
            }
        } else {
            ProductVariant::create([
                'product_id' => $product->id,
                'ukuran' => null,
                'harga' => $request->harga,
                'stok' => $request->stok,
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image',
            'variants.*.ukuran' => 'nullable|in:kecil,sedang,besar',
            'variants.*.harga' => 'nullable|numeric',
            'variants.*.stok' => 'nullable|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->nama = $request->input('nama');
        $product->deskripsi = $request->input('deskripsi');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $product->gambar = $filename;
        }

        $product->is_best_seller = $request->has('is_best_seller') ? 1 : 0;
        $product->is_favorit = $request->has('is_favorit') ? 1 : 0;

        $product->save();

        // Update varian
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                if (isset($variantData['id'])) {
                    $variant = ProductVariant::find($variantData['id']);
                    if ($variant && $variant->product_id == $product->id) {
                        $variant->ukuran = $variantData['ukuran'];
                        $variant->harga = $variantData['harga'];
                        $variant->stok = $variantData['stok'];
                        $variant->save();
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->gambar && file_exists(public_path('images/' . $product->gambar))) {
            unlink(public_path('images/' . $product->gambar));
        }
        $product->variants()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function search(Request $request)
{
    $keyword = $request->query('q');
    $products = Product::with('variants')
        ->where('nama', 'like', "%$keyword%")
        ->orWhere('deskripsi', 'like', "%$keyword%")
        ->get();

    return response()->json([
        'html' => view('admin.products.product_table', compact('products'))->render()
    ]);
}

}
