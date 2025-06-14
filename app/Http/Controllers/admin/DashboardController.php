<?php
// DashboardController.php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalPesanan = Order::count();
        $totalPelanggan = User::count();

        // Daily Reports
        $dailyOrders = Order::whereDate('tanggal_pesanan', Carbon::today())
            ->count();
        $dailyRevenue = Order::whereDate('tanggal_pesanan', Carbon::today())
            ->where('status', 'selesai')
            ->sum('total_harga');

        // Weekly Reports
        $weeklyOrders = Order::whereBetween('tanggal_pesanan', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        $weeklyRevenue = Order::whereBetween('tanggal_pesanan', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('status', 'selesai')
            ->sum('total_harga');

        // Monthly Reports
        $monthlyOrders = Order::whereYear('tanggal_pesanan', Carbon::now()->year)
            ->whereMonth('tanggal_pesanan', Carbon::now()->month)
            ->count();
        $monthlyRevenue = Order::whereYear('tanggal_pesanan', Carbon::now()->year)
            ->whereMonth('tanggal_pesanan', Carbon::now()->month)
            ->where('status', 'selesai')
            ->sum('total_harga');

        // Daily Sales Chart Data
        $dailySales = Order::whereDate('tanggal_pesanan', '>=', Carbon::now()->subDays(7))
            ->where('status', 'selesai')
            ->selectRaw('DATE(tanggal_pesanan) as date, COUNT(*) as orders, SUM(total_harga) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $pesananTerbaru = Order::with([
            'user',
            'orderItems',
            'products.variants',
        ])->latest('tanggal_pesanan')->limit(10)->get()->map(function ($order) {
            return (object) [
                'nama_user' => $order->user?->nama,
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

        return view('admin.dashboard_admin', compact(
            'totalProduk', 
            'totalPesanan', 
            'totalPelanggan', 
            'pesananTerbaru',
            'dailyOrders',
            'dailyRevenue',
            'weeklyOrders',
            'weeklyRevenue',
            'monthlyOrders',
            'monthlyRevenue',
            'dailySales'
        ));
    }

    public function exportPDF(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now());
        
        $orders = Order::whereBetween('tanggal_pesanan', [$startDate, $endDate])
            ->with(['user', 'products'])
            ->get();
            
        $totalRevenue = $orders->where('status', 'selesai')->sum('total_harga');
        $totalOrders = $orders->count();
        
        $data = [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        $pdf = PDF::loadView('admin.reports.sales_report', $data);
        return $pdf->download('laporan-penjualan-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}
