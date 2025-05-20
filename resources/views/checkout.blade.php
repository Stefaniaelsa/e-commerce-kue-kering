<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-[#fff7f4] text-[#4e3d3a]">

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

    <main class="max-w-3xl mx-auto py-10 px-4">
        <h2 class="text-3xl font-bold text-primary mb-6"><i class="fas fa-credit-card mr-2"></i> Pembayaran</h2>

        <form action="{{ route('checkout.simpan') }}" method="POST"
            class="bg-white shadow-md rounded-lg p-6 space-y-6 border border-pink-100">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700">Nama Penerima</label>
                <input type="text" name="nama_penerima" required
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-primary focus:outline-none" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700">Alamat Pengiriman</label>
                <textarea name="alamat_pengiriman" rows="3" required
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-primary focus:outline-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700">Metode Pembayaran</label>
                <select name="metode_pembayaran"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-primary focus:outline-none">
                    <option value="transfer_bank">Transfer Bank</option>
                    <option value="cod">Bayar di Tempat (COD)</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            <div id="form-bank" class="hidden">
                <label class="block text-sm font-medium mb-1 text-gray-700">Pilih Bank</label>
                <select name="bank_tujuan"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:ring-primary focus:outline-none">
                    <option value="BCA">BCA - 1234567890</option>
                    <option value="BRI">BRI - 9876543210</option>
                    <option value="BNI">BNI - 5432167890</option>
                </select>
            </div>

            <div class="text-right mt-6">
                <button type="submit"
                    class="bg-gradient-to-r from-primary to-pink-400 hover:from-accent hover:to-pink-500 text-white py-3 px-6 rounded-full text-sm font-medium shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    <i class="fas fa-check-circle mr-2"></i> Konfirmasi & Bayar
                </button>
            </div>
        </form>
    </main>

    <script>
        // Tampilkan form bank jika pilih "transfer_bank"
        const metodePembayaran = document.querySelector('select[name="metode_pembayaran"]');
        const formBank = document.getElementById('form-bank');

        metodePembayaran.addEventListener('change', function() {
            formBank.classList.toggle('hidden', this.value !== 'transfer_bank');
        });
    </script>

    <footer class="bg-gradient-to-r from-pink-500 to-pink-300 text-white py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>
</body>

</html>
