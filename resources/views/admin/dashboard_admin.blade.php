@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-gray-800">Dashboard</h1>
            <p class="text-sm text-gray-600 mt-1">Overview & Statistik</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.dashboard.export') }}" method="GET" class="flex items-center gap-2">
                <input type="date" name="start_date" class="px-3 py-2 border rounded-lg text-sm">
                <input type="date" name="end_date" class="px-3 py-2 border rounded-lg text-sm">
                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-pink-600 transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </button>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Laporan Harian</h2>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                </div>
                <div class="p-3 bg-pink-100 rounded-full">
                    <i class="fas fa-chart-line text-xl text-pink-500"></i>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Pesanan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $dailyOrders }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pendapatan</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($dailyRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Laporan Mingguan</h2>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->startOfWeek()->format('d M') }} - {{ \Carbon\Carbon::now()->endOfWeek()->format('d M') }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-calendar-week text-xl text-purple-500"></i>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Pesanan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $weeklyOrders }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pendapatan</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($weeklyRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Laporan Bulanan</h2>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('F Y') }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-calendar-alt text-xl text-blue-500"></i>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Pesanan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $monthlyOrders }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pendapatan</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
            <i class="fas fa-cookie-bite text-3xl text-pink-400 mb-4"></i>
            <h2 class="text-lg font-semibold text-gray-700">Total Produk</h2>
            <p class="text-2xl font-bold mt-2 text-gray-800">{{ $totalProduk }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
            <i class="fas fa-shopping-basket text-3xl text-purple-400 mb-4"></i>
            <h2 class="text-lg font-semibold text-gray-700">Total Pesanan</h2>
            <p class="text-2xl font-bold mt-2 text-gray-800">{{ $totalPesanan }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
            <i class="fas fa-users text-3xl text-blue-400 mb-4"></i>
            <h2 class="text-lg font-semibold text-gray-700">Pelanggan</h2>
            <p class="text-2xl font-bold mt-2 text-gray-800">{{ $totalPelanggan }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
            <i class="fas fa-chart-pie text-3xl text-green-400 mb-4"></i>
            <h2 class="text-lg font-semibold text-gray-700">Konversi</h2>
            <p class="text-2xl font-bold mt-2 text-gray-800">{{ $totalPesanan > 0 ? round(($monthlyOrders / $totalPesanan) * 100) : 0 }}%</p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Grafik Penjualan 7 Hari Terakhir</h2>
        <canvas id="salesChart" class="w-full" style="height: 300px;"></canvas>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Pesanan Terbaru</h2>
            <a href="#" class="text-pink-500 hover:text-pink-600 text-sm font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">No</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">Nama Pelanggan</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">Produk</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">Total</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesananTerbaru as $pesanan)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4">{{ $pesanan->nama_user}}</td>
                            <td class="py-3 px-4">
                                @if($pesanan->produk->count() > 0)
                                    @foreach($pesanan->produk as $item)
                                        <div class="mb-1">
                                            <span class="font-medium text-gray-700">{{ $item->nama_produk }}</span>
                                            <span class="text-sm text-gray-500">{{ $item->ukuran ? '('.$item->ukuran.')' : '' }} x{{ $item->jumlah }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-gray-500">Tidak ada item</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-medium">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($pesanan->status == 'selesai' || $pesanan->status == 'delivered') 
                                        bg-green-100 text-green-800
                                    @elseif($pesanan->status == 'diproses' || $pesanan->status == 'paid')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($pesanan->status == 'menunggu')
                                        bg-blue-100 text-blue-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const salesData = @json($dailySales);
    
    const dates = salesData.map(item => item.date);
    const revenues = salesData.map(item => item.revenue);
    const orders = salesData.map(item => item.orders);

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: revenues,
                    borderColor: 'rgb(249, 115, 22)',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Jumlah Pesanan',
                    data: orders,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Pendapatan (Rp)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Jumlah Pesanan'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection