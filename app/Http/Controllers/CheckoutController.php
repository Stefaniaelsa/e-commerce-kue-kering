<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_Keranjang;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout'); // Buat file checkout.blade.php
    }

    public function proses(Request $request)
    {
        $ids = $request->input('items');

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Tidak ada item yang dipilih.');
        }
    }
}
