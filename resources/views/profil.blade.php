@extends('layouts.app-user')

@section('title', 'Profil Saya')
@section('content')
    <main class="max-w-6xl mx-auto py-8 px-4">
        <!-- Informasi Profil -->
        <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h1 class="text-2xl font-bold text-pink-600 border-b border-pink-300 pb-2 mb-6">
                Profil Saya
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-user text-pink-500 w-6"></i>
                        <span class="ml-3 font-semibold w-32">Nama</span>
                        <span class="text-gray-700">: {{ $user->nama }}</span>
                    </div>

                    <div class="flex items-center">
                        <i class="fas fa-envelope text-pink-500 w-6"></i>
                        <span class="ml-3 font-semibold w-32">Email</span>
                        <span class="text-gray-700">: {{ $user->email }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-pink-500 w-6"></i>
                        <span class="ml-3 font-semibold w-32">Nomor Telepon</span>
                        <span class="text-gray-700">: {{ $user->nomor_telepon ?? '-' }}</span>
                    </div>

                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-pink-500 w-6"></i>
                        <span class="ml-3 font-semibold w-32">Alamat</span>
                        <span class="text-gray-700">: {{ $user->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Daftar Pesanan -->
        <section class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-pink-600 border-b border-pink-300 pb-2 mb-6">
                Daftar Pesanan
            </h2>

            @if ($orders->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-shopping-bag text-pink-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">Belum ada pesanan</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($orders as $order)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Header Pesanan -->
                            <div class="bg-gray-50 p-4 flex justify-between items-center border-b">
                                <div>
                                    <span class="text-gray-600">No. Pesanan:</span>
                                    <span class="font-semibold">#{{ $order->id }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-pink-500"></i>
                                    <span>{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d M Y H:i') }}</span>
                                </div>
                            </div>

                            <!-- Detail Pesanan -->
                            <div class="p-4">
                                <!-- Status -->
                                <div class="flex justify-between items-center mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                            @if($order->status == 'selesai') bg-green-100 text-green-800
                                            @elseif($order->status == 'diproses') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'menunggu') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="text-lg font-semibold text-pink-600">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- Metode -->
                                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">Metode Pembayaran:</span>
                                        <span class="font-medium">{{ ucfirst($order->metode_pembayaran) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Pengiriman:</span>
                                        <span class="font-medium">{{ ucfirst($order->pengiriman) }}</span>
                                    </div>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-end gap-3 mt-4 border-t pt-4">
                                    <a href="{{ route('pesanan.show', $order->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition">
                                        <i class="fas fa-eye mr-2"></i>
                                        Detail
                                    </a>

                                    @if($order->status == 'menunggu' && $order->metode_pembayaran == 'transfer')
                                        <a href="{{ route('pembayaran') }}"
                                            class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
                                            <i class="fas fa-credit-card mr-2"></i>
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
@endsection
