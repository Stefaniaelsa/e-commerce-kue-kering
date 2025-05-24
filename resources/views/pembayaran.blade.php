<!-- resources/views/pembayaran.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans">

    <header class="bg-pink-200 shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">IniKue</h1>
        <nav class="space-x-4 text-sm">
            <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium">Beranda</a>
            <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium">Produk</a>
            <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium">Keranjang</a>
        </nav>
    </header>

    <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6">
        <h2 class="text-3xl font-bold text-primary mb-6"><i class="fas fa-credit-card mr-3"></i> Pembayaran</h2>

        <form action="{{ route('order.process') }}" method="POST"
            class="space-y-6 bg-white p-6 rounded-xl shadow-md border border-pink-100">
            @csrf

            <div>
                <h3 class="text-lg font-bold mb-2">Alamat Pengiriman</h3>
                <textarea name="alamat_pengiriman" rows="3" required
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring focus:outline-none">{{ old('alamat_pengiriman') }}</textarea>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-2">Metode Pembayaran</h3>
                <select name="metode_pembayaran" required
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring focus:outline-none">
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="COD">Cash on Delivery</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-2">Bank Tujuan (jika transfer)</h3>
                <input type="text" name="bank_tujuan"
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring focus:outline-none"
                    placeholder="Contoh: BCA, Mandiri, BRI">
            </div>

            <div>
                <h3 class="text-lg font-bold mb-2">Nomor Rekening Anda</h3>
                <input type="text" name="no_rekening"
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring focus:outline-none"
                    placeholder="Nomor rekening pengirim (jika perlu)">
            </div>

            <div class="bg-secondary text-primary font-medium p-4 rounded-lg">
                <p>Total Pembayaran: <span
                        class="text-xl font-bold">Rp{{ number_format($total + 10000, 0, ',', '.') }}</span></p>
                <p class="text-sm text-gray-600">Subtotal: Rp{{ number_format($total, 0, ',', '.') }} + Ongkir: Rp10.000
                </p>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-gradient-to-r from-primary to-pink-400 hover:from-accent hover:to-pink-500 text-white py-3 px-6 rounded-full text-sm font-medium shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    <i class="fas fa-check-circle mr-2"></i> Proses Pembayaran
                </button>
            </div>
        </form>
    </main>

    <footer class="bg-gradient-to-r from-primary to-pink-300 text-white py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
</body>

</html>
