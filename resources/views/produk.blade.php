@extends('layouts.app-user')

@section('title', 'Produk Kue Kering')

@section('content')
    <!-- Judul Halaman -->
    <section class="text-center py-8 px-4">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Produk Kue Kering</h2>
        <p class="text-sm text-gray-500">Pilih kue favoritmu dan pesan sekarang!</p>
    </section>

    <!-- Input Live Search -->
    <section class="px-4 sm:px-6 pb-6">
        <div class="max-w-xl mx-auto">
            <input type="text" id="liveSearchInput" placeholder="Cari produk kue..."
                class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm" />
        </div>
    </section>

    <!-- Daftar Produk -->
    <section class="px-4 sm:px-6 pb-16">
        <div id="produkGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($produks as $produk)
                <div class="produk-item bg-white rounded-lg shadow-md hover:shadow-lg transition-all p-4 flex flex-col"
                    data-nama="{{ strtolower($produk->nama) }} {{ strtolower($produk->deskripsi ?? '') }}">
                    <div class="w-full h-48 mb-3 overflow-hidden rounded">
                        <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                            class="w-full h-full object-cover object-center" />
                    </div>
                    <h4 class="font-bold text-base sm:text-lg mb-1">{{ $produk->nama }}</h4>
                    <a href="{{ route('produk.detail', ['id' => $produk->id]) }}"
                        class="mt-auto block text-center bg-pink-500 hover:bg-pink-600 text-white py-2 px-4 rounded text-sm">
                        Lihat Produk
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Jika tidak ada hasil -->
        <div id="noResults" class="text-center text-gray-500 mt-8 hidden">
            <p>Produk tidak ditemukan.</p>
            <a href="{{ route('produk.index') }}" class="text-pink-500 underline hover:text-pink-700 mt-2 block">
                Kembali ke semua produk
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-pink-500 to-pink-300 text-white py-6 mt-10">
        <div class="container mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>

    <!-- Script Live Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('liveSearchInput');
            const produkItems = document.querySelectorAll('.produk-item');
            const noResults = document.getElementById('noResults');

            input.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();
                let visibleCount = 0;

                produkItems.forEach(item => {
                    const data = item.getAttribute('data-nama');
                    if (data.includes(keyword)) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                // Tampilkan atau sembunyikan pesan "tidak ditemukan"
                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
