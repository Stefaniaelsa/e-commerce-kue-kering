<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#fb7185',
                        secondary: '#fecdd3',
                        accent: '#e11d48',
                    },
                    animation: {
                        'bounce-slow': 'bounce 1.5s infinite',
                        'pulse-slow': 'pulse 2s infinite',
                    }
                }
            }
        }
    </script>
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

    <!-- Konten Pembayaran -->
    <main class="max-w-5xl mx-auto py-10 px-4 sm:px-6">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-primary flex items-center">
                <i class="fas fa-money-check-alt mr-3"></i> Pembayaran
            </h2>
            <div class="bg-secondary px-4 py-2 rounded-full text-primary font-medium">
                <i class="fas fa-coins mr-2"></i> Total:
                Rp{{ number_format($cartItems->sum('harga') + 10000, 0, ',', '.') }}
            </div>
        </div>

        @if ($cartItems->isEmpty())
            <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-pink-100">
                <i class="fas fa-cart-shopping text-5xl text-primary mb-4 opacity-50"></i>
                <h3 class="text-xl font-medium text-gray-600 mb-2">Tidak ada item untuk dibayar</h3>
                <p class="text-gray-500 mb-6">Silakan pilih produk terlebih dahulu.</p>
                <a href="{{ url('/produk') }}"
                    class="inline-block bg-primary hover:bg-accent text-white py-2 px-6 rounded-full text-sm font-medium transition transform hover:-translate-y-1 shadow-md hover:shadow-lg">
                    <i class="fas fa-store mr-2"></i> Belanja Sekarang
                </a>
            </div>
        @else
            <form action="{{ route('order.process') }}" method="POST"
                class="space-y-6 max-w-xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-pink-100">
                @csrf

                <!-- Daftar Produk -->
                <section>
                    <h2 class="text-lg font-bold mb-4 text-gray-700">Daftar Produk</h2>
                    <hr class="mb-4">

                    @foreach ($cartItems as $item)
                        <div class="flex justify-between mb-3 text-sm sm:text-base">
                            <div class="text-gray-800">
                                {{ $item->produk->nama }}
                                @if ($item->varian)
                                    ({{ $item->varian->ukuran }})
                                @endif
                                × {{ $item->jumlah }}
                            </div>
                            <div class="text-gray-800 font-medium">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach

                    <hr class="my-4">

                    <!-- Ringkasan Harga -->
                    <div class="space-y-2 text-base text-gray-900">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($cartItems->sum('harga'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkos Kirim</span>
                            <span>Rp 10.000</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between font-semibold">
                            <span>Total</span>
                            <span>Rp {{ number_format($cartItems->sum('harga') + 10000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </section>

                <!-- Alamat Pengiriman -->
                <section>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                    <textarea id="alamat" name="alamat" required class="w-full p-3 border border-gray-300 rounded-lg resize-none"
                        rows="3" placeholder="Masukkan alamat lengkap..."></textarea>
                </section>

                <!-- Metode Pembayaran -->
                <section>
                    <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Metode
                        Pembayaran</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" required
                        class="w-full p-3 border border-gray-300 rounded-lg">
                        <option value="" disabled selected>Pilih metode</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="cod">Bayar di Tempat</option>
                    </select>
                </section>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ url('/keranjang') }}"
                        class="bg-white border border-primary text-primary hover:bg-secondary py-3 px-6 rounded-full text-sm font-medium text-center transition">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Keranjang
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-primary to-pink-400 hover:from-accent hover:to-pink-500 text-white py-3 px-6 rounded-full text-sm font-medium text-center shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                        <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-primary to-pink-300 text-white py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>
</body>

</html>
