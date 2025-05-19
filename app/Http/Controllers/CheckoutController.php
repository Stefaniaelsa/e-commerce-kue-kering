<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_Keranjang;

class CheckoutController extends Controller
{
    public function proses(Request $request)
    {
        $ids = $request->input('items');

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Pilih minimal satu produk.');
        }

        $items = Item_Keranjang::with('produk')->whereIn('id', $ids)->get();

        // Nanti arahkan ke view checkout
        return view('checkout', compact('items'));
    }
}
