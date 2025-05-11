<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pesan Produk - {{ $produk->nama }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans">

  <!-- Navbar -->
  <header class="bg-pink-200 shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold">IniKue</h1>
    <nav class="space-x-4 text-sm">
      <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium">Beranda</a>
      <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium">Produk</a>
      <a href="{{ url('/pesanan') }}" class="hover:text-pink-700 font-medium">Pesanan</a>
      <a href="#" class="hover:text-pink-700 font-medium">Akun</a>
      <a href="#" class="text-red-500 hover:text-red-700 font-medium"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </header>

  <!-- Detail Pesanan -->
  <section class="px-6 py-10 max-w-6xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-white p-6 rounded-lg shadow">

      <!-- Gambar Produk -->
      <div>
        <img src="{{ $produk->gambar_url ?? 'https://via.placeholder.com/400' }}" alt="{{ $produk->nama }}"
             class="rounded-lg w-full h-72 object-cover"/>
      </div>

      <!-- Informasi Produk -->
      <div>
        <h2 class="text-3xl font-bold mb-2">{{ $produk->nama }}</h2>
        <p class="text-sm text-gray-500 mb-4">{{ $produk->deskripsi }}</p>

        <!-- Harga dinamis -->
        <p class="text-xl font-semibold text-pink-600 mb-4" id="harga">
          Rp{{ number_format($produk->harga, 0, ',', '.') }}
        </p>

        <!-- Pilihan Ukuran -->
        <div class="mb-6">
          <label class="block text-sm font-medium mb-1">Ukuran:</label>
          <select id="ukuran" name="ukuran" onchange="updateHarga()" class="w-full border rounded p-2">
            @foreach ($produk->variants as $variant)
              <option value="{{ $variant->harga_tambahan }}" data-ukuran="{{ $variant->ukuran }}">
                {{ $variant->ukuran }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Jumlah Pesanan -->
        <div class="mb-6">
          <label class="block text-sm font-medium mb-1">Jumlah:</label>
          <input id="jumlah" name="jumlah" type="number" value="1" min="1" class="w-full border rounded p-2" onchange="updateHarga()">
        </div>

        <!-- Total Harga -->
        <div class="mb-6">
          <p class="text-lg font-semibold text-pink-600" id="total-harga">
            Total: Rp{{ number_format($produk->harga, 0, ',', '.') }}
          </p>
        </div>

        <!-- Form Pesanan -->
        <form action="{{ route('order.store') }}" method="POST">
          @csrf
          <input type="hidden" name="product_id" value="{{ $produk->id }}">
          <input type="hidden" name="variant_id" id="variant_id">
          <input type="hidden" name="quantity" id="quantity" value="1">

          <div class="flex gap-3">
            <a href="{{ url('/produk') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded text-sm">
              ← Kembali
            </a>
            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white py-2 px-4 rounded text-sm">
              Pesan Sekarang
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-sm text-gray-600 bg-pink-100">
    &copy; 2025 IniKue. Semua Hak Dilindungi.
  </footer>

  <!-- Script untuk mengubah harga -->
  <script>
    const baseHarga = {{ $produk->harga }};
    const hargaElement = document.getElementById('harga');
    const ukuranSelect = document.getElementById('ukuran');
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaElement = document.getElementById('total-harga');
    const variantIdInput = document.getElementById('variant_id');
    const quantityInput = document.getElementById('quantity');

    function updateHarga() {
      const tambahan = parseInt(ukuranSelect.value);
      const jumlah = parseInt(jumlahInput.value);
      const hargaBaru = (baseHarga + tambahan) * jumlah;
      hargaElement.textContent = 'Rp' + (baseHarga + tambahan).toLocaleString('id-ID');
      totalHargaElement.textContent = 'Total: Rp' + hargaBaru.toLocaleString('id-ID');

      // Update variant_id dan quantity
      variantIdInput.value = ukuranSelect.selectedOptions[0].dataset.ukuran; // bisa diganti dengan id atau informasi lainnya yang sesuai
      quantityInput.value = jumlah;
    }

    // Jalankan updateHarga saat pertama kali load
    updateHarga();
  </script>

</body>
</html>
