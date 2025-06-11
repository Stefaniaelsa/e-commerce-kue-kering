@extends('layouts.app-user')

@section('title', 'Keranjang Belanja')
@section('content')
    <!-- Judul Halaman -->
    <section class="text-center py-8 px-4">
        <h2 class="text-3xl font-bold mb-2">Produk Kue Kering</h2>
        <p class="text-sm text-gray-500">Pilih kue favoritmu dan pesan sekarang!</p>
    </section>

    <!-- Daftar Produk -->
    <section class="px-6 pb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach ($produks as $produk)
                <!-- Kartu Produk -->
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                    <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                        class="rounded mb-2 w-full h-40 object-cover" />
                    <h4 class="font-bold text-lg">{{ $produk->nama }}</h4>
                    {{-- Harga disembunyikan --}}
                    {{-- <p class="text-sm text-gray-500">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p> --}}
                    <a href="{{ route('produk.detail', ['id' => $produk->id]) }}"
                        class="mt-2 block text-center bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">
                        Lihat Produk
                    </a>
                </div>
            @endforeach

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-pink-500 to-pink-300 text-white py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>

@endsection