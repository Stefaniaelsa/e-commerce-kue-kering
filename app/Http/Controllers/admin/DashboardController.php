<?php
// DashboardController.php
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

        $pesananTerbaru = Order::with([
            'user',
            'orderItems',
            'products.variants',
        ])->latest('tanggal_pesanan')->limit(10)->get()->map(function ($order) {
            return (object) [
                'nama_user' => $order->user->nama,
                'total_harga' => $order->total_harga,
                'status' => $order->status,
                'tanggal_pesanan' => $order->tanggal_pesanan,
                'produk' => $order->products->map(function ($product) use ($order) {
                    $orderItem = $order->orderItems->where('varian_id', $product->variants->first()?->id)->first();

                    return (object) [
                        'nama_produk' => $product->nama,
                        'ukuran' => $product->variants->first()?->ukuran,
                        'jumlah' => $orderItem ? $orderItem->jumlah : 0,
                    ];
                }),
            ];
        });
        
        // Debug: tampilkan hasil dalam bentuk pretty JSON
        // return response()->json([
        //     'totalProduk' => $totalProduk,
        //     'totalPesanan' => $totalPesanan,
        //     'totalPelanggan' => $totalPelanggan,
        //     'pesananTerbaru' => $pesananTerbaru
        // ], 200, [], JSON_PRETTY_PRINT);
        
        return view('admin.dashboard_admin', compact('totalProduk', 'totalPesanan', 'totalPelanggan', 'pesananTerbaru'));
    }

}