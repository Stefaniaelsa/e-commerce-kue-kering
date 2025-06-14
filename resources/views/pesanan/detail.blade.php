@extends('layouts.app-user')

@section('title', 'Detail Pesanan')
@section('content')
    <main class="max-w-4xl mx-auto py-8 px-4">
        <!-- Header Pesanan -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-pink-600">
                    Detail Pesanan #{{ $order->id }}
                </h1>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($order->status == 'selesai') bg-green-100 text-green-800
                    @elseif($order->status == 'diproses') bg-blue-100 text-blue-800
                    @elseif($order->status == 'menunggu') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                <div>
                    <p class="text-gray-600 mb-1">Tanggal Pesanan</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Metode Pembayaran</p>
                    <p class="font-medium">{{ ucfirst($order->metode_pembayaran) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Metode Pengiriman</p>
                    <p class="font-medium">{{ ucfirst($order->pengiriman) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Alamat Pengiriman</p>
                    <p class="font-medium">{{ $order->alamat_pengiriman }}</p>
                </div>
            </div>

            @if($order->catatan)
                <div class="mt-4 bg-gray-50 p-3 rounded-lg">
                    <p class="text-gray-600 text-sm mb-1">Catatan:</p>
                    <p class="text-sm">{{ $order->catatan }}</p>
                </div>
            @endif
        </div>

        <!-- Daftar Produk -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Daftar Produk</h2>
            
            <div class="divide-y">
                @foreach($order->orderItems as $item)
                    <div class="py-4 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            @if($item->variant->produk->gambar)
                                <img src="{{ asset('images/' . $item->variant->produk->gambar) }}" 
                                     alt="{{ $item->variant->produk->nama }}"
                                     class="w-16 h-16 object-cover rounded-lg">
                            @endif
                            <div>
                                <h3 class="font-medium">{{ $item->variant->produk->nama }}</h3>
                                @if($item->variant->ukuran)
                                    <p class="text-sm text-gray-500">Ukuran: {{ $item->variant->ukuran }}</p>
                                @endif
                                <p class="text-sm text-pink-600">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }} x {{ $item->jumlah }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">
                                Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Ringkasan Biaya -->
            <div class="border-t mt-6 pt-4">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span>Rp {{ number_format($order->total_harga - ($order->pengiriman == 'gojek' ? 10000 : 0), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->pengiriman == 'gojek' ? 10000 : 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-semibold text-lg text-pink-600 mt-4">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-between">
            <a href="{{ route('profil') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Profil
            </a>

            @if($order->status == 'menunggu' && $order->metode_pembayaran == 'transfer')
                <a href="{{ route('pembayaran') }}" 
                   class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
                    <i class="fas fa-credit-card mr-2"></i>
                    Bayar Sekarang
                </a>
            @endif
        </div>

        @if($order->status == 'menunggu' && $order->metode_pembayaran == 'transfer')
            <div class="mt-4 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-clock text-yellow-600"></i>
                    <h3 class="font-semibold text-yellow-800">Batas Waktu Pembayaran:</h3>
                </div>
                <div id="countdown" class="text-yellow-700" data-deadline="{{ $order->getDeadlineTime() }}">
                    Menghitung...
                </div>
            </div>

            <script>
                function updateCountdown() {
                    const countdownEl = document.getElementById('countdown');
                    const deadline = new Date(countdownEl.dataset.deadline).getTime();
                    const now = new Date().getTime();
                    const distance = deadline - now;

                    if (distance < 0) {
                        countdownEl.innerHTML = `<span class="text-red-600 font-semibold">Waktu pembayaran telah habis</span>`;
                        // Reload halaman setelah 3 detik untuk memperbarui status
                        setTimeout(() => window.location.reload(), 3000);
                        return;
                    }

                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    countdownEl.innerHTML = `
                        <span class="font-semibold">Tersisa: </span>
                        <span class="font-bold">${hours}</span> jam 
                        <span class="font-bold">${minutes}</span> menit 
                        <span class="font-bold">${seconds}</span> detik
                    `;
                }

                // Update setiap detik
                setInterval(updateCountdown, 1000);
                updateCountdown(); // Panggil sekali di awal
            </script>
        @endif
    </main>
@endsection
