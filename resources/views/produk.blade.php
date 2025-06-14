@extends('layouts.app-user')

@section('title', 'Keranjang Belanja')
@section('content')
    <!-- Judul Halaman -->
    <section class="text-center py-8 px-4">
        <h2 class="text-3xl font-bold mb-2">Produk Kue Kering</h2>
        <p class="text-sm text-gray-500">Pilih kue favoritmu dan pesan sekarang!</p>
    </section>

    <!-- Form Pencarian -->
    <section class="px-6 pb-4">
        <form method="GET" action="{{ route('produk.search') }}"
            class="flex flex-col sm:flex-row items-center justify-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk kue..."
                class="w-full sm:w-1/2 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400" />
            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">
                Cari
            </button>
        </form>
    </section>


    <!-- Daftar Produk -->
    <section class="px-6 pb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @if ($produks->isEmpty())
                <div class="col-span-full text-center text-gray-500">
                    Produk tidak ditemukan.<br>
                    <a href="{{ route('produk.index') }}" class="text-pink-500 underline hover:text-pink-700">
                        Kembali ke semua produk
                    </a>
                </div>
            @endif


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
