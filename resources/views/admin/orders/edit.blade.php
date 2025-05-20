@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Edit Pesanan</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="status" class="block mb-2 font-medium">Status</label>
            <select name="status" id="status" class="w-full border p-2 rounded">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="metode_pembayaran" class="block mb-2 font-medium">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="w-full border p-2 rounded">
                <option value="transfer" selected>Transfer</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="bank_tujuan" class="block mb-2 font-medium">Bank Tujuan</label>
            <select name="bank_tujuan" id="bank_tujuan" class="w-full border p-2 rounded">
                <option value="BCA" {{ $order->bank_tujuan == 'BCA' ? 'selected' : '' }}>BCA</option>
                <option value="BRI" {{ $order->bank_tujuan == 'BRI' ? 'selected' : '' }}>BRI</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="pengiriman" class="block mb-2 font-medium">Metode Pengiriman</label>
            <select name="pengiriman" id="pengiriman" class="w-full border p-2 rounded">
                <option value="gojek" {{ $order->pengiriman == 'gojek' ? 'selected' : '' }}>Gojek</option>
                <option value="ambil ditempat" {{ $order->pengiriman == 'ambil ditempat' ? 'selected' : '' }}>Ambil di Tempat</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="alamat_pengiriman" class="block mb-2 font-medium">Alamat Pengiriman</label>
            <textarea name="alamat_pengiriman" id="alamat_pengiriman" class="w-full border p-2 rounded" rows="3">{{ old('alamat_pengiriman', $order->alamat_pengiriman) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Total Harga</label>
            <input type="text" value="Rp{{ number_format($order->total_harga, 0, ',', '.') }}" class="w-full border p-2 rounded bg-gray-100" disabled>
        </div>

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Update Pesanan</button>
    </form>
</div>
@endsection
