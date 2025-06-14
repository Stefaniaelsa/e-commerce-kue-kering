@extends('layouts.app')

@section('content')
<div class="p-4 md:p-8 max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
        <h1 class="text-2xl font-bold mb-4">Detail Pesanan <span class="text-blue-600">#{{ $order->id }}</span></h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div><strong>Nama User:</strong> {{ $order->user->nama ?? '-' }}</div>
            <div><strong>Email:</strong> {{ $order->user->email ?? '-' }}</div>
            <div><strong>Status:</strong> 
                <span class="inline-block px-2 py-1 rounded 
                    @if($order->status == 'selesai') bg-green-100 text-green-700 
                    @elseif($order->status == 'proses') bg-yellow-100 text-yellow-700 
                    @else bg-gray-100 text-gray-700 
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div><strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
            <div><strong>Alamat Pengiriman:</strong> {{ $order->alamat_pengiriman }}</div>
            <div><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran }}</div>
            <div><strong>Pengiriman:</strong> {{ $order->pengiriman }}</div>
            <div><strong>Tanggal:</strong> {{ $order->tanggal_pesanan }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Item Pesanan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-200 text-sm">
                <thead class="bg-blue-100 text-gray-700">
                    <tr>
                        <th class="p-3 border text-left">Produk</th>
                        <th class="p-3 border text-left">Ukuran</th>
                        <th class="p-3 border text-left">Jumlah</th>
                        <th class="p-3 border text-left">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $detail)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $detail->variant->product->nama ?? '-' }}</td>
                            <td class="p-3 border">{{ $detail->variant->ukuran ?? '-' }}</td>
                            <td class="p-3 border">{{ $detail->jumlah }}</td>
                            <td class="p-3 border">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('admin.orders.index') }}" 
           class="inline-block bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600 transition">
            Kembali ke Daftar Pesanan
        </a>
    </div>
</div>
@endsection
