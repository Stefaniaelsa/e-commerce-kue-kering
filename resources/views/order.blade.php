<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#fb7185',
                        secondary: '#fecdd3',
                        accent: '#e11d48',
                    }
                }
            }
        }
    </script>
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
        </nav>
    </header>

    <!-- Form Pemesanan -->
    <main class="max-w-3xl mx-auto py-10 px-4 sm:px-6">
        <h2 class="text-3xl font-bold text-primary mb-8">Formulir Pemesanan</h2>

        <form action="{{ route('order.confirm') }}" method="POST"
            class="bg-white p-6 rounded-xl shadow-sm border border-pink-100 space-y-6">
            @csrf

            <div>
                <label for="alamat_pengiriman" class="block font-medium mb-2">Alamat Pengiriman</label>
                <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="4" required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
            </div>

            <div>
                <label for="metode_pembayaran" class="block font-medium mb-2">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="transfer_bank">Transfer Bank</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            <div>
                <label for="bank_tujuan" class="block font-medium mb-2">Bank Tujuan (jika transfer)</label>
                <input type="text" name="bank_tujuan" id="bank_tujuan" placeholder="Contoh: BCA"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary" />
            </div>

            <div>
                <label for="no_rekening" class="block font-medium mb-2">No. Rekening Pengirim (jika transfer)</label>
                <input type="text" name="no_rekening" id="no_rekening" placeholder="Contoh: 1234567890"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary" />
            </div>

            <input type="hidden" name="total_harga" value="{{ $totalHarga }}">

            @foreach ($cartItems as $item)
                <input type="hidden" name="items[]" value="{{ $item->id }}">
            @endforeach

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-primary hover:bg-accent text-white font-semibold px-6 py-3 rounded-full transition transform hover:-translate-y-1 shadow-md">
                    <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pesanan
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
