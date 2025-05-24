@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-20 text-center">
        <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Berhasil!</h2>
        <p class="text-gray-600 mb-6">Terima kasih telah memesan. Kami sedang menyiapkan pesananmu 🎉</p>
        <a href="{{ url('/produk') }}"
            class="bg-primary text-white py-3 px-6 rounded-full font-medium hover:bg-accent transition">
            Lanjut Belanja
        </a>
    </div>
@endsection
