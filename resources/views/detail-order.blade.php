<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans">

    <!-- Navbar -->
    <header class="bg-pink-200 shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">IniKue</h1>
        <nav class="space-x-4 text-sm">
            <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium">Beranda</a>
            <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium">Produk</a>
            <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium">Keranjang</a>
        </nav>
    </header>

    <!-- Form Pembayaran -->
    <main class="max-w-3xl mx-auto py-10 px-4">
        <h2 class="text-3xl font-bold text-primary mb-8">Informasi Pembayaran</h2>

        <form action="{{ route('order.store') }}" method="POST"
            class="space-y-6 bg-white p-6 rounded-xl shadow-md border border-pink-100">
            @csrf

            <!-- Alamat Pengiriman -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman</label>
                <textarea name="alamat_pengiriman" rows="3" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300"></textarea>
            </div>

            <!-- Metode Pembayaran -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select name="metode_pembayaran" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300">
                    <option value="">Pilih Metode</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="COD">Bayar di Tempat (COD)</option>
                    <option value="E-Wallet">E-Wallet (OVO, DANA, dsb)</option>
                </select>
            </div>

            <!-- Info Rekening / E-wallet -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening / E-wallet</label>
                <input type="text" name="no_rekening" placeholder="Contoh: 1234567890" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300">
            </div>

            <!-- Rangkuman Total -->
            <div class="bg-pink-50 border border-pink-100 p-4 rounded-lg">
                <p class="text-gray-700">Total Belanja: <span
                        class="font-bold">Rp{{ number_format($totalHarga, 0, ',', '.') }}</span></p>
                <p class="text-gray-700">Ongkir: <span class="font-bold">Rp10.000</span></p>
                <p class="text-xl font-bold text-primary mt-2">Total Bayar:
                    Rp{{ number_format($totalHarga + 10000, 0, ',', '.') }}</p>
            </div>

            <!-- Tombol Submit -->
            <div class="text-right">
                <button type="submit"
                    class="bg-primary hover:bg-accent text-white px-6 py-3 rounded-full font-medium transition">
                    <i class="fas fa-credit-card mr-2"></i> Konfirmasi & Bayar
                </button>
            </div>
        </form>
    </main>

    <footer class="bg-gradient-to-r from-primary to-pink-300 text-white py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>

</body>

</html>
