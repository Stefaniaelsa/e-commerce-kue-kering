<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_Keranjang;

class PaymentController extends Controller
{
public function show(Request $request)
{
$itemIds = $request->input('items', []);
$cartItems = Item_Keranjang::with(['produk', 'varian'])
->whereIn('id', $itemIds)
->get();

return view('payment', compact('cartItems'));
}
}
