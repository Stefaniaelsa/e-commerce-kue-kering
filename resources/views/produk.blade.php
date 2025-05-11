<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Produk Kue - IniKue</title>
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

  <!-- Judul Halaman -->
  <section class="text-center py-8 px-4">
    <h2 class="text-3xl font-bold mb-2">Produk Kue Kering</h2>
    <p class="text-sm text-gray-500">Pilih kue favoritmu dan pesan sekarang!</p>
  </section>

  <!--Produk -->
  <section class="px-6 pb-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

      <!-- Kartu Produk -->
      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Kue Nastar" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Nastar ORI</h4>
        <p class="text-sm text-gray-500">Rp 75.000</p>
        <a href="{{ route('produk.detail', ['id' => 1]) }}" class="mt-2 block text-center bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">
            Lihat Produk
        </a>

      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Kastengel" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Nastar Daun</h4>
        <p class="text-sm text-gray-500">Rp 65.000</p>
        <a href="{{ route('produk.detail', ['id' => 2]) }}" class="mt-2 block text-center bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">
            Lihat Produk
        </a>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Putri Salju" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Kastangel</h4>
        <p class="text-sm text-gray-500">Rp 60.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Sagu Keju</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Choco Chips</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Cokelat Mente</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Semprit</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Palm Cheese</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Lidah Kucing Coket</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Lidah Kucing Keju</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Putri Salju</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Choco Ball Springkel</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Choco Ball Almond</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Chni Kao So</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Kacang Karang</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Brownies Crispy</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
        <img src="https://via.placeholder.com/250" alt="Lidah Kucing" class="rounded mb-2 w-full h-40 object-cover" />
        <h4 class="font-bold text-lg">Cokelat Mente</h4>
        <p class="text-sm text-gray-500">Rp 70.000</p>
        <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
      </div>

      <!-- Tambahkan lebih banyak produk sesuai kebutuhan -->

    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-sm text-gray-600 bg-pink-100">
    &copy; 2025 IniKue. Semua Hak Dilindungi.
  </footer>

</body>
</html>
