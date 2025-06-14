@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('content')
<!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">Dashboard</h1>
        <div class="text-sm text-gray-600">Selamat datang, Admin!</div>
    </div>

    <!-- Card Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <i class="fas fa-cookie-bite text-3xl text-pink-400 mb-4"></i>
            <h2 class="text-lg font-semibold">Total Produk</h2>
            <p class="text-2xl font-bold mt-2">{{ $totalProduk }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <i class="fas fa-shopping-basket text-3xl text-pink-400 mb-4"></i>
            <h2 class="text-lg font-semibold">Total Pesanan</h2>
            <p class="text-2xl font-bold mt-2">{{ $totalPesanan }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <i class="fas fa-users text-3xl text-pink-400 mb-4"></i>
            <h2 class="text-lg font-semibold">Pelanggan</h2>
            <p class="text-2xl font-bold mt-2">{{ $totalPelanggan }}</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Pesanan Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr>
                        <th class="py-2 border-b">No</th>
                        <th class="py-2 border-b">Nama Pelanggan</th>
                        <th class="py-2 border-b">Produk</th>
                        <th class="py-2 border-b">Total</th>
                        <th class="py-2 border-b">Status</th>
                        <th class="py-2 border-b">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesananTerbaru as $pesanan)
                        <tr>
                            <td class="py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="py-2 border-b">{{ $pesanan->nama_user}}</td>
                            <td class="py-2 border-b">
                                @if($pesanan->produk->count() > 0)
                                    @foreach($pesanan->produk as $item)
                                        <div class="mb-1">
                                            <span class="font-medium">{{ $item->nama_produk }}</span>
                                            <span class="text-sm text-gray-600">{{ $item->ukuran ? '('.$item->ukuran.')' : '' }} x{{ $item->jumlah }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-gray-500">Tidak ada item</span>
                                @endif
                            </td>
                            <td class="py-2 border-b">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td class="py-2 border-b">
                                <span class="px-2 py-1 rounded text-xs font-medium
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
                            <td class="py-2 border-b text-sm">
                                {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection