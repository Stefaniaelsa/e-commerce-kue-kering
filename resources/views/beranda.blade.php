<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda - IniKue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
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
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>

        </nav>
    </header>

    <!-- Hero Banner dengan Slider -->
    <section class="relative overflow-hidden aspect-[16/9] md:aspect-[16/6] bg-pink-100">
        <div id="slider" class="w-full h-full bg-center bg-cover transition-all duration-1000"></div>

        <div
            class="absolute inset-0 bg-pink-900 bg-opacity-40 flex flex-col items-center justify-center text-white text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang di IniKue</h2>
            <p class="text-md mb-4">Temukan berbagai pilihan kue kering favoritmu di sini!</p>
            <a href="#"
                class="bg-pink-300 hover:bg-pink-400 text-white px-6 py-2 rounded text-sm font-medium">Lihat Katalog</a>
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
            <a href="{{ url('/produk') }}"
                class="block bg-white shadow rounded p-4 text-center hover:shadow-lg transition">
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
    <footer class="text-center py-4 text-sm text-gray-600 bg-pink-100 mt-8">
        &copy; 2025 IniKue. Semua Hak Dilindungi.
    </footer>

</body>

</html>
