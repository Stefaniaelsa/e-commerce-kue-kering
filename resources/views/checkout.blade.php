<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order</title>
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
            <a href="#" class="hover:text-pink-700 font-medium">Akun</a>
            <a href="#" class="text-red-500 hover:text-red-700 font-medium"><i class="fas fa-sign-out-alt"></i>
                Logout</a>
        </nav>
    </header>

    <main class="max-w-4xl mx-auto py-10 px-4">
        <h2 class="text-3xl font-bold text-primary mb-6">Checkout</h2>

        <form action="{{ route('order.store') }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md border border-pink-100">
            @csrf

            <!-- Input item terpilih -->
            @foreach ($items as $item)
                <input type="hidden" name="items[]" value="{{ $item->id }}">
            @endforeach

            <div class="mb-4">
                <label for="nama" class="block font-medium mb-1">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required class="w-full border px-4 py-2 rounded">
            </div>

            <div class="mb-4">
                <label for="alamat" class="block font-medium mb-1">Alamat Pengiriman</label>
                <textarea id="alamat" name="alamat" required class="w-full border px-4 py-2 rounded"></textarea>
            </div>

            <div class="mb-4">
                <label for="metode_pembayaran" class="block font-medium mb-1">Metode Pembayaran</label>
                <select id="metode_pembayaran" name="metode_pembayaran" required
                    class="w-full border px-4 py-2 rounded">
                    <option value="">-- Pilih --</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="cod">Bayar di Tempat</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="catatan" class="block font-medium mb-1">Catatan Tambahan</label>
                <textarea id="catatan" name="catatan" class="w-full border px-4 py-2 rounded"></textarea>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ url('/keranjang') }}" class="text-sm text-pink-600 hover:underline">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Keranjang
                </a>
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded shadow">
                    <i class="fas fa-credit-card mr-2"></i> Lanjut Pembayaran
                </button>
            </div>
        </form>

    </main>

    <footer class="bg-pink-300 text-white py-6 mt-10">
        <div class="text-center text-sm">&copy; 2025 IniKue. Semua Hak Dilindungi.</div>
    </footer>

</body>

</html>
