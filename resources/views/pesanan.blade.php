@extends('layouts.app-user')

@section('title', 'Keranjang Belanja')
@section('content')
    <!-- Konten Pembayaran -->
    <main class="flex-grow max-w-5xl mx-auto py-10 px-4 sm:px-6 w-full">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
            <h2 class="text-3xl font-bold text-primary flex items-center gap-3 select-none">
                <i class="fas fa-money-check-alt text-primary"></i>
                Pesanan
            </h2>
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
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Terjadi kesalahan:</strong>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                    <input type="text" name="nama" class="w-full border border-gray-300 px-4 py-2 rounded-lg"
                        placeholder="Nama Penerima"
                        value="{{ old('nama', $user->nama) }}">
                </div>


                <!-- Alamat Pengiriman -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Pengiriman</label>

                    <!-- Jalan -->
                    <input type="text" name="jalan" class="w-full border border-gray-300 px-4 py-2 rounded-lg mb-2"
                        placeholder="Nama Jalan"
                        value="{{ old('jalan', $user->alamat->jalan ?? '') }}">

                    <!-- Kelurahan -->
                    <input type="text" name="kelurahan" class="w-full border border-gray-300 px-4 py-2 rounded-lg mb-2"
                        placeholder="Kelurahan"
                        value="{{ old('kelurahan', $user->alamat->kelurahan ?? '') }}">

                    <!-- Kecamatan -->
                    <input type="text" name="kecamatan" class="w-full border border-gray-300 px-4 py-2 rounded-lg"
                        placeholder="Kecamatan"
                        value="{{ old('kecamatan', $user->alamat->kecamatan ?? '') }}">
                </div>


                <!-- Metode Pengiriman -->
                <section>
                    <label for="metode_pengiriman" class="block text-sm font-semibold text-gray-700 mb-2">Metode
                        Pengiriman <span class="text-red-600">*</span></label>
                    <select id="metode_pengiriman" name="metode_pengiriman" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="" disabled {{ old('metode_pengiriman') ? '' : 'selected' }}>Pilih metode
                            pengiriman
                        </option>
                        <option value="kurir" {{ old('metode_pengiriman') == 'kurir' ? 'selected' : '' }}>Kurir
                        </option>
                        <option value="ambil ditempat"
                            {{ old('metode_pengiriman') == 'ambil ditempat' ? 'selected' : '' }}>
                            Ambil di Tempat</option>
                    </select>
                </section>

                <!-- Metode Pembayaran -->
                <section>
                    <label for="metode_pembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Metode
                        Pembayaran <span class="text-red-600">*</span></label>
                    <select id="metode_pembayaran" name="metode_pembayaran" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="" disabled {{ old('metode_pembayaran') ? '' : 'selected' }}>Pilih metode
                            pembayaran</option>
                        <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                            Transfer Bank</option>
                        <option value="bayar ditempat" {{ old('metode_pembayaran') == 'bayar ditempat' ? 'selected' : '' }}>Bayar di
                            Tempat (COD)</option>
                    </select>
                    @error('metode_pembayaran')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </section>

                {{-- <!-- Info Bank (hanya muncul jika memilih transfer) -->
                <section id="info-bank" class="hidden">
                    <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
                        <h4 class="font-semibold text-green-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-university"></i>
                            Informasi Transfer
                        </h4>
                        <div class="space-y-1 text-sm text-green-700">
                            <p><span class="font-semibold">Bank:</span> BCA</p>
                            <p><span class="font-semibold">No. Rekening:</span> 123456</p>
                            <p><span class="font-semibold">Atas Nama:</span> Toko IniKue</p>
                        </div>
                    </div>
                </section> --}}

                <!-- Catatan -->
                <section>
                    <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-2">Catatan
                        (Opsional)</label>
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
document.addEventListener('DOMContentLoaded', function () {
    const metodePengiriman = document.getElementById('metode_pengiriman');
    const metodePembayaran = document.getElementById('metode_pembayaran');
    const infoBank = document.getElementById('info-bank');

    const optionCODValue = 'bayar ditempat';

    function updateMetodePembayaran() {
        const selectedPengiriman = metodePengiriman.value;

        // Cek apakah opsi COD sudah ada
        let optionCOD = Array.from(metodePembayaran.options).find(opt => opt.value === optionCODValue);

        if (selectedPengiriman === 'kurir') {
            // Hapus opsi bayar di tempat
            if (optionCOD) {
                optionCOD.remove();
            }

            // Jika yang sedang terpilih adalah "bayar ditempat", ubah ke transfer
            if (metodePembayaran.value === optionCODValue) {
                metodePembayaran.value = 'transfer';
            }
        } else {
            // Tambahkan kembali opsi bayar di tempat jika belum ada
            const exists = Array.from(metodePembayaran.options).some(opt => opt.value === optionCODValue);
            if (!exists) {
                const newOption = new Option("Bayar di Tempat", optionCODValue);
                metodePembayaran.add(newOption);
            }
        }
    }

    function toggleInfoBank() {
        if (metodePembayaran.value === 'transfer') {
            infoBank?.classList.remove('hidden');
        } else {
            infoBank?.classList.add('hidden');
        }
    }

    // Event listeners
    metodePengiriman.addEventListener('change', () => {
        updateMetodePembayaran();
    });

    metodePembayaran.addEventListener('change', () => {
        toggleInfoBank();
    });

    // Jalankan saat awal
    updateMetodePembayaran();
    toggleInfoBank();
});
</script>

@endsection
