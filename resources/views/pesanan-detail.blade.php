<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Detail Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans">

    <!-- Navbar -->
    <header class="bg-pink-200 shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">IniKue</h1>
        <nav class="space-x-4 text-sm">
            <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium">Beranda</a>
            <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium">Produk</a>
            <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium">Keranjang</a>
            <a href="#" class="hover:text-pink-700 font-medium">Akun</a>
            <a href="#" class="text-red-500 hover:text-red-700 font-medium"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>

    <!-- Daftar Pesanan -->
    @extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto py-10">
  <h1 class="text-2xl font-bold mb-6">Detail Pesanan #{{ $order->id }}</h1>

  <p><strong>Status:</strong> {{ $order->status }}</p>
  <p><strong>Total:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
  <p><strong>Tanggal:</strong> {{ $order->tanggal_pesanan }}</p>

  <hr class="my-4"/>

  <h2 class="text-xl font-semibold mb-3">Item Pesanan:</h2>
  <ul class="space-y-4">
    @foreach ($order->orderDetails as $item)
      <li class="border p-4 rounded-lg">
        <p><strong>Produk:</strong> {{ $item->variant->product->nama }}</p>
        <p><strong>Ukuran:</strong> {{ $item->variant->ukuran }}</p>
        <p><strong>Jumlah:</strong> {{ $item->jumlah }}</p>
        <p><strong>Subtotal:</strong> Rp{{ number_format($item->sub_total, 0, ',', '.') }}</p>
      </li>
    @endforeach
  </ul>
</section>
@endsection


    <!-- Footer -->
    <footer class="text-center py-4 text-sm text-gray-600 bg-pink-100">
        &copy; 2025 IniKue. Semua Hak Dilindungi.
    </footer>

</body>
</html>
