@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-6">Detail Pesanan #{{ $order->id }}</h1>

    <div class="mb-4">
        <strong>Nama User:</strong> {{ $order->user->nama ?? '-' }}<br>
        <strong>Email:</strong> {{ $order->user->email ?? '-' }}<br>
        <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
        <strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}<br>
        <strong>Alamat Pengiriman:</strong> {{ $order->alamat_pengiriman }}<br>
        <strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran }}<br>
        <strong>Bank Tujuan:</strong> {{ $order->bank_tujuan }}<br>
        <strong>No Rekening:</strong> {{ $order->no_rekening }}<br>
        <strong>Pengiriman:</strong> {{ $order->pengiriman }}<br>
        <strong>Tanggal:</strong> {{ $order->tanggal_pesanan }}
    </div>

    <h2 class="text-xl font-semibold mb-3">Item Pesanan</h2>
    <table class="w-full table-auto border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Produk</th>
                <th class="p-2 border">Ukuran</th>
                <th class="p-2 border">Jumlah</th>
                <th class="p-2 border">Harga</th>
                <th class="p-2 border">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $detail)
                <tr>
                    <td class="p-2 border">{{ $detail->variant->product->nama ?? '-' }}</td>
                    <td class="p-2 border">{{ $detail->variant->ukuran ?? '-' }}</td>
                    <td class="p-2 border">{{ $detail->jumlah }}</td>
                    <td class="p-2 border">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td class="p-2 border">Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.orders.index') }}" class="mt-6 inline-block text-blue-500 hover:underline">Kembali</a>
</div>
@endsection
