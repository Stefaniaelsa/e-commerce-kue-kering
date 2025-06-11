@extends('layouts.app-user')

@section('title', 'Keranjang Belanja')
@section('content')
    <!-- Hero Banner dengan Slider -->
    <section class="relative overflow-hidden aspect-[16/9] md:aspect-[16/6] bg-pink-100">
        <div id="slider" class="w-full h-full bg-center bg-cover transition-all duration-1000"></div>

        <div
            class="absolute inset-0 bg-pink-900 bg-opacity-40 flex flex-col items-center justify-center text-white text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang di IniKue</h2>
            <p class="text-md mb-4">Temukan berbagai pilihan kue kering favoritmu di sini!</p>
        </div>
    </section>

    <script>
        const slider = document.getElementById("slider");
        const images = [
            "/images/slider4.png",
            "/images/slider5.png",
            "/images/slider6.png",
        ];
        let index = 0;

        function changeBackground() {
            slider.style.backgroundImage = `url('${images[index]}')`;
            slider.style.backgroundSize = "cover";
            slider.style.backgroundPosition = "center";
            index = (index + 1) % images.length;
        }

        setInterval(changeBackground, 4000);
        changeBackground();
    </script>

    <!-- Kategori -->
    <section class="py-8 px-6">
        <h3 class="text-xl font-semibold mb-4">Kategori Kue</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="#best-seller" class="block bg-white shadow rounded p-4 text-center hover:shadow-lg transition">
                <i class="fas fa-fire text-3xl text-pink-400 mb-2"></i>
                <p class="font-semibold">Best Seller</p>
            </a>
            <a href="#favorit" class="block bg-white shadow rounded p-4 text-center hover:shadow-lg transition">
                <i class="fas fa-heart text-3xl text-pink-400 mb-2"></i>
                <p class="font-semibold">Favorit</p>
            </a>
            <a href="{{ url('/produk') }}" class="block bg-white shadow rounded p-4 text-center hover:shadow-lg transition">
                <i class="fas fa-cookie text-3xl text-pink-400 mb-2"></i>
                <p class="font-semibold">Semua Kue</p>
            </a>
        </div>
    </section>

    <!-- Best Seller Section -->
    <section id="best-seller" class="mb-8 px-6">
        <h2 class="text-xl font-semibold mb-4">Best Seller</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($bestSellerProduk as $produk)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                    <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                        class="w-full h-40 object-cover rounded mb-2" />
                    <h4 class="font-bold text-lg">{{ $produk->nama }}</h4>
                    <a href="{{ route('produk.detail', ['id' => $produk->id]) }}"
                        class="mt-2 block text-center bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Lihat
                        Produk</a>
                </div>
            @empty
                <p>Belum ada produk Best Seller.</p>
            @endforelse
        </div>
    </section>

    <!-- Favorit Section -->
    <section id="favorit" class="mb-8 px-6">
        <h2 class="text-xl font-semibold mb-4">Favorit</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($favoritProduk as $produk)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                    <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                        class="w-full h-40 object-cover rounded mb-2" />
                    <h4 class="font-bold text-lg">{{ $produk->nama }}</h4>
                    <a href="{{ route('produk.detail', ['id' => $produk->id]) }}"
                        class="mt-2 block text-center bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Lihat
                        Produk</a>
                </div>
            @empty
                <p>Belum ada produk Favorit.</p>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-pink-500 to-pink-300 text-white py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>
@endsection
