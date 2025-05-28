<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pesanan - IniKue</title>
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

<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-pink-200 shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold select-none">IniKue</h1>
        <nav class="space-x-6 text-sm flex items-center">
            <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium transition">Beranda</a>
            <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium transition">Produk</a>
            <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium transition">Keranjang</a>
            <a href="#" class="hover:text-pink-700 font-medium transition">Akun</a>
            <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                @csrf
                <button type="submit"
                    class="text-red-600 hover:text-red-800 font-medium flex items-center space-x-1 transition">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </header>

    <!-- Konten Pembayaran -->
    <main class="flex-grow max-w-5xl mx-auto py-10 px-4 sm:px-6 w-full">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
            <h2 class="text-3xl font-bold text-primary flex items-center gap-3 select-none">
                <i class="fas fa-money-check-alt text-primary"></i>
                Pesanan
            </h2>
            <div
                class="bg-secondary px-5 py-2 rounded-full text-primary font-semibold flex items-center gap-2 select-none shadow-md">
                <i class="fas fa-coins"></i>
                <span>Total:</span>
                <span>Rp{{ number_format($cartItems->sum('harga') + 10000, 0, ',', '.') }}</span>
            </div>
        </div>

        @if ($cartItems->isEmpty())
            <div
                class="text-center py-20 bg-white rounded-xl shadow-md border border-pink-100 flex flex-col items-center gap-4 max-w-md mx-auto">
                <i class="fas fa-cart-shopping text-6xl text-primary opacity-60"></i>
                <h3 class="text-xl font-semibold text-gray-600">Tidak ada item untuk dibayar</h3>
                <p class="text-gray-500 max-w-xs">Silakan pilih produk terlebih dahulu untuk melakukan pemesanan.
                </p>
                <a href="{{ url('/produk') }}"
                    class="inline-block bg-primary hover:bg-accent text-white py-3 px-8 rounded-full text-sm font-semibold transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-store mr-2"></i> Belanja Sekarang
                </a>
            </div>
        @else
            <form action="{{ route('order.process') }}" method="POST"
                class="space-y-8 max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md border border-pink-100">
                @csrf

                <!-- Daftar Produk -->
                <section>
                    <h3 class="text-xl font-bold mb-5 text-gray-700 border-b pb-2">Daftar Produk</h3>
                    <div class="space-y-3">
                        @foreach ($cartItems as $item)
                            <div
                                class="flex justify-between items-center text-gray-800 text-base sm:text-lg border-b border-gray-200 pb-2">
                                <div>
                                    {{ $item->varian->produk->nama }}
                                    @if ($item->varian)
                                        <span class="text-sm text-gray-500">({{ $item->varian->ukuran }})</span>
                                    @endif
                                    <span class="font-semibold">× {{ $item->jumlah }}</span>
                                </div>
                                <div class="font-semibold">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Ringkasan Harga -->
                    <div class="mt-6 space-y-3 text-gray-900 text-base sm:text-lg">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($cartItems->sum('harga'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkos Kirim</span>
                            <span>Rp 10.000</span>
                        </div>
                        <hr class="my-3 border-pink-200">
                        <div class="flex justify-between font-semibold text-primary text-lg">
                            <span>Total</span>
                            <span>Rp {{ number_format($cartItems->sum('harga') + 10000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </section>

                <!-- Nama Penerima -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Penerima
                    </label>
                    <p class="text-base text-gray-800 bg-gray-100 px-4 py-2 rounded-lg">{{ $user->nama }}</p>
                </div>

               <!-- Alamat Pengiriman -->
                    <textarea id="alamat" name="alamat" rows="3" required
                        class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="Masukkan alamat pengiriman...">{{ old('alamat', $user->alamat ?? '') }}</textarea>

                    <!-- Metode Pengiriman -->
                    <select id="metode_pengiriman" name="metode_pengiriman" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="" disabled {{ old('metode_pengiriman') ? '' : 'selected' }}>Pilih metode pengiriman</option>
                        <option value="gojek" {{ old('metode_pengiriman') == 'gojek' ? 'selected' : '' }}>Gojek</option>
                        <option value="ambil" {{ old('metode_pengiriman') == 'ambil' ? 'selected' : '' }}>Ambil di Tempat</option>
                    </select>

                    <!-- Ongkos Kirim dengan class untuk JS -->
                    <div class="flex justify-between">
                        <span>Ongkos Kirim</span>
                        <span class="ongkos-kirim">Rp 10.000</span>
                    </div>

                <!-- Metode Pembayaran -->
                <section>
                    <label for="metode_pembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Metode
                        Pembayaran <span class="text-red-600">*</span></label>
                    <select id="metode_pembayaran" name="metode_pembayaran" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="" disabled {{ old('metode_pembayaran') ? '' : 'selected' }}>Pilih metode
                        </option>
                        <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                            Transfer Bank</option>
                        <option value="cod" {{ old('metode_pembayaran') == 'cod' ? 'selected' : '' }}>Bayar di
                            Tempat
                        </option>
                    </select>
                    @error('metode_pembayaran')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror


                    <!-- Pilihan Bank -->
                    <div id="pilihan-bank"
                        class="mt-4 rounded-lg border border-gray-300 p-4 bg-white shadow-sm {{ old('metode_pembayaran') == 'transfer' ? '' : 'hidden' }}">
                        <label for="bank_tujuan" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Bank <span
                                class="text-red-600">*</span></label>
                        <select id="bank_tujuan" name="bank_tujuan"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="" disabled {{ old('bank_tujuan') ? '' : 'selected' }}>Pilih Bank
                                Tujuan
                            </option>
                            <option value="BCA" {{ old('bank_tujuan') == 'BCA' ? 'selected' : '' }}>BCA</option>
                            <option value="BNI" {{ old('bank_tujuan') == 'BNI' ? 'selected' : '' }}>BNI</option>
                            <option value="Mandiri" {{ old('bank_tujuan') == 'Mandiri' ? 'selected' : '' }}>Mandiri
                            </option>
                        </select>
                        @error('bank_tujuan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Rekening Toko -->
                    <div id="no-rekening"
                        class="mt-4 bg-green-50 p-5 rounded-xl border border-green-400 text-green-900 shadow-md select-none {{ old('metode_pembayaran') == 'transfer' ? '' : 'hidden' }}">
                        <p class="text-sm text-gray-800 mb-2 italic">Silakan transfer ke rekening tujuan berikut:</p>
                        <p class="font-medium"><span class="font-semibold">Bank:</span> BCA</p>
                        <p class="font-medium"><span class="font-semibold">No. Rekening:</span> 123456</p>
                        <p class="font-medium"><span class="font-semibold">Atas Nama:</span> Toko IniKue</p>
                    </div>
                </section>

                <!-- Catatan -->
                <section>
                    <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea id="catatan" name="catatan" rows="3"
                        class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="Tulis catatan tambahan...">{{ old('catatan') }}</textarea>
                </section>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-full font-semibold text-lg hover:bg-accent transition">
                    Pesan Sekarang
                </button>
            </form>
        @endif
    </main>

    <script>
          const metodeSelect = document.getElementById('metode_pembayaran');
    const bankSection = document.getElementById('pilihan-bank');
    const noRekening = document.getElementById('no-rekening');

    metodeSelect.addEventListener('change', () => {
        if (metodeSelect.value === 'transfer') {
            bankSection.classList.remove('hidden');
            noRekening.classList.remove('hidden');
        } else {
            bankSection.classList.add('hidden');
            noRekening.classList.add('hidden');
        }
    });

        const metodePengiriman = document.getElementById('metode_pengiriman');
        const ongkosKirimEl = document.querySelector('.ongkos-kirim');

        metodePengiriman.addEventListener('change', () => {
            if (metodePengiriman.value === 'ambil') {
                ongkosKirimEl.textContent = 'Rp 0 (Ambil di Tempat)';
            } else {
                ongkosKirimEl.textContent = 'Rp 10.000';
            }
        });

    </script>

</body>

</html>
