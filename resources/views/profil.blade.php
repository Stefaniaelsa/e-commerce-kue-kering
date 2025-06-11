@extends('layouts.app-user')

@section('title', 'Keranjang Belanja')
@section('content')
    <main class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-12">
        <h1 class="text-3xl font-extrabold mb-6 text-pink-600 border-b-4 border-pink-300 pb-2">
            Profil Saya
        </h1>

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

        {{-- Status Pesanan Terbaru --}}
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-pink-600 border-b-4 border-pink-300 pb-2 mb-6">
                Status Pesanan Terbaru
            </h2>

            @if($latestOrder)
                <div class="border border-pink-300 rounded p-6 bg-pink-50 shadow-sm">
                    <p class="mb-2"><strong>Nomor Pesanan:</strong> #{{ $latestOrder->id }}</p>
                    <p class="mb-2"><strong>Status:</strong> 
                        <span class="font-semibold text-pink-700">{{ ucfirst($latestOrder->status) }}</span>
                    </p>
                    <p class="mb-4"><strong>Tanggal Pesanan:</strong> {{ $latestOrder->created_at ? $latestOrder->created_at->format('d M Y') : '-' }}</p>
                    <a href="{{ route('pesanan.show', $latestOrder->id) }}" 
                       class="inline-block px-5 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 transition">
                       Detail Pesanan
                    </a>
                </div>
            @else
                <p class="text-gray-500 italic">Belum ada pesanan terbaru.</p>
            @endif
        </section>

    </main>

@endsection