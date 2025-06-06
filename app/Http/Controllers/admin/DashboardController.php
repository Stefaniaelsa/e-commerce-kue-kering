<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $totalProduk = Product::count();
    $totalPesanan = Order::count();
    $totalPelanggan = User::count();

    // Eager load orderItems dan variant
    $pesananTerbaru = Order::with('orderItems')
        ->orderBy('tanggal_pesanan', 'desc')
        ->take(5)
        ->get();

    return view('admin.dashboard_admin', compact('totalProduk', 'totalPesanan', 'totalPelanggan', 'pesananTerbaru'));
}
   
}
