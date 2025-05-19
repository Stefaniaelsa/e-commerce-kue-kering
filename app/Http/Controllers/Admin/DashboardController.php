<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data yang diperlukan
        $totalProduk = Product::count();
        $totalPesanan = Order::count();
        $totalPelanggan = User::where('role', 'user')->count();

        // Mengambil pesanan terbaru
        $pesananTerbaru = Order::orderBy('tanggal_pesanan', 'desc')->take(5)->get();

        return view('admin.dashboard_admin', compact('totalProduk', 'totalPesanan', 'totalPelanggan', 'pesananTerbaru'));

    }
}
