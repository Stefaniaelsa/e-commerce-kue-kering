@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-6">Daftar Pesanan</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 bg-white">
            <thead class="bg-pink-100">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Nama Pembeli</th>
                    <th class="p-2 border">Total Harga</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Metode</th>
                    <th class="p-2 border">Pengiriman</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border">{{ $orders->firstItem() + $loop->index }}</td>
                        <td class="p-2 border">{{ $order->user->name ?? '-' }}</td>
                        <td class="p-2 border">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td class="p-2 border">
                            <span class="px-2 py-1 rounded text-sm 
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status == 'paid') bg-blue-100 text-blue-700
                                @elseif($order->status == 'delivered') bg-green-100 text-green-700
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="p-2 border">{{ $order->tanggal_pesanan }}</td>
                        <td class="p-2 border">{{ ucfirst($order->metode_pembayaran) }} ({{ $order->bank_tujuan }})</td>
                        <td class="p-2 border">{{ ucfirst($order->pengiriman) }}</td>
                        <td class="p-2 border space-x-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline">Detail</a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-4 text-center text-gray-500">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
