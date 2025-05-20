<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Produk - {{ $produk->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />

    <style>
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            10%,
            90% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .animate-fade-in-out {
            animation: fadeInOut 3s ease-in-out forwards;
        }
    </style>
</head>

<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans">

    <!-- Notifikasi -->
    @if (session('success'))
        <div id="notif-success"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-pink-400 text-white px-6 py-3 rounded shadow-lg z-50 text-center animate-fade-in-out">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Navbar -->
    <header class="bg-pink-200 shadow p-4 flex justify-between items-center mt-16 md:mt-0">
        <h1 class="text-2xl font-bold">IniKue</h1>
        <nav class="space-x-4 text-sm">
            <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium">Beranda</a>
            <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium">Produk</a>
            <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium">Keranjang</a>
            <a href="#" class="hover:text-pink-700 font-medium">Akun</a>
            <a href="#" class="text-red-500 hover:text-red-700 font-medium"><i class="fas fa-sign-out-alt"></i>
                Logout</a>
        </nav>
    </header>

    <!-- Detail Produk -->
    <section class="px-6 py-10 max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-white p-6 rounded-lg shadow">
            <!-- Gambar Produk -->
            <div>
                <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                    class="rounded mb-2 w-full h-80 object-cover" />
            </div>

            <!-- Informasi Produk -->
            <div>
                <h2 class="text-3xl font-bold mb-2">{{ $produk->nama }}</h2>
                <p class="text-sm text-gray-500 mb-4">{{ $produk->deskripsi }}</p>

                <!-- Harga dan Varian -->
                @if ($produk->variants->count() > 0)
                    <label class="block text-sm font-medium mb-1">Pilih Ukuran:</label>
                    <select id="ukuran" onchange="updateHarga()" class="w-full border rounded p-2 mb-4">
                        @foreach ($produk->variants as $variant)
                            <option value="{{ $variant->harga }}" data-id="{{ $variant->id }}">
                                {{ $variant->ukuran }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xl font-semibold text-pink-600 mb-4" id="harga">
                        Rp{{ number_format($produk->variants->first()->harga, 0, ',', '.') }}
                    </p>
                @else
                    <p class="text-xl font-semibold text-pink-600 mb-4" id="harga">
                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                    </p>
                @endif

                <!-- Form Pesanan -->
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_produk" value="{{ $produk->id }}">

                    @if ($produk->variants->count() > 0)
                        <input type="hidden" name="id_varian" id="id_varian"
                            value="{{ $produk->variants->first()->id }}">
                    @endif

                    <input type="number" name="jumlah" value="1" min="1"
                        class="w-full border rounded p-2 mb-4" />

                    <div class="flex gap-3">
                        <a href="{{ url('/produk') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded text-sm">← Kembali</a>
                        <button type="submit"
                            class="bg-pink-500 hover:bg-pink-600 text-white py-2 px-4 rounded text-sm">Tambah
                            Keranjang</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4 text-sm text-gray-600 bg-pink-100">
        &copy; 2025 IniKue. Semua Hak Dilindungi.
    </footer>

    <!-- Script untuk update harga dan id varian -->
    <script>
        function updateHarga() {
            const select = document.getElementById('ukuran');
            const harga = parseInt(select.value);
            const hargaEl = document.getElementById('harga');
            hargaEl.textContent = 'Rp' + harga.toLocaleString('id-ID');

            // Update ID varian
            const selectedOption = select.options[select.selectedIndex];
            const variantId = selectedOption.getAttribute('data-id');
            const idVarianInput = document.getElementById('id_varian');
            if (idVarianInput) {
                idVarianInput.value = variantId;
            }
        }
    </script>

</body>

</html>
