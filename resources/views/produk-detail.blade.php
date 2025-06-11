@extends('layouts.app-user')

@section('title', 'Keranjang Belanja')
@section('content')
    <!-- Notifikasi -->
    @if (session('success'))
        <div id="notif-success"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-pink-400 text-white px-6 py-3 rounded shadow-lg z-50 text-center animate-fade-in-out">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

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
                            <option value="{{ $variant->harga }}" data-id="{{ $variant->id }}"
                                data-stok="{{ $variant->stok }}">
                                {{ $variant->ukuran }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-xl font-semibold text-pink-600 mb-2" id="harga">
                        Rp{{ number_format($produk->variants->first()->harga, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-600 mb-4" id="stok">
                        Sisa stok: {{ $produk->variants->first()->stok }}
                    </p>
                @else
                    <p class="text-xl font-semibold text-pink-600 mb-2" id="harga">
                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-600 mb-4">Sisa stok: {{ $produk->stok }}</p>
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
    <footer class="bg-gradient-to-r from-pink-500 to-pink-300 text-white py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>

    <!-- Script untuk update harga dan stok -->
    <script>
        function updateHarga() {
            const select = document.getElementById('ukuran');
            const harga = parseInt(select.value);
            const selectedOption = select.options[select.selectedIndex];
            const variantId = selectedOption.getAttribute('data-id');
            const stok = selectedOption.getAttribute('data-stok');

            // Update harga
            const hargaEl = document.getElementById('harga');
            hargaEl.textContent = 'Rp' + harga.toLocaleString('id-ID');

            // Update ID varian
            const idVarianInput = document.getElementById('id_varian');
            if (idVarianInput) {
                idVarianInput.value = variantId;
            }

            // Update stok
            const stokEl = document.getElementById('stok');
            if (stokEl) {
                stokEl.textContent = 'Sisa stok: ' + stok;
            }
        }
    </script>
@endsection