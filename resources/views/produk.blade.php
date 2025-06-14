@extends('layouts.app-user')

@section('title', 'Keranjang Belanja')
@section('content')
    <!-- Judul Halaman -->
    <section class="text-center py-8 px-4">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Produk Kue Kering</h2>
        <p class="text-sm text-gray-500">Pilih kue favoritmu dan pesan sekarang!</p>
    </section>

    <!-- Form Pencarian -->
    <section class="px-4 sm:px-6 pb-6">
        <form method="GET" action="{{ route('produk.search') }}"
            class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-2 max-w-xl mx-auto">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk kue..."
                class="w-full sm:w-2/3 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm" />
            <button type="submit"
                class="w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded text-sm">
                Cari
            </button>
        </form>
    </section>

    <!-- Daftar Produk -->
    <section class="px-4 sm:px-6 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @if ($produks->isEmpty())
                <div
                    class="col-span-full text-center text-gray-500 min-h-[150px] flex items-center justify-center flex-col">
                    <p>Produk tidak ditemukan.</p>
                    <a href="{{ route('produk.index') }}" class="text-pink-500 underline hover:text-pink-700 mt-2">
                        Kembali ke semua produk
                    </a>
                </div>
            @endif

            @foreach ($produks as $produk)
                <!-- Kartu Produk -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all p-4 flex flex-col">
                    <div class="aspect-[4/3] w-full mb-3">
                        <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                            class="rounded w-full h-full object-cover" />
                    </div>
                    <h4 class="font-bold text-base sm:text-lg mb-1">{{ $produk->nama }}</h4>
                    {{-- <p class="text-sm text-gray-500">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p> --}}
                    <a href="{{ route('produk.detail', ['id' => $produk->id]) }}"
                        class="mt-auto block text-center bg-pink-500 hover:bg-pink-600 text-white py-2 px-4 rounded text-sm">
                        Lihat Produk
                    </a>
                </div>
            @endforeach

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-pink-500 to-pink-300 text-white py-6 mt-10">
        <div class="container mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>
@endsection
