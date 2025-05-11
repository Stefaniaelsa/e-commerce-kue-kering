<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda - IniKue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
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

    <!-- Hero Banner -->
    <section class="bg-pink-100 text-center py-12 px-4">
      <h2 class="text-3xl font-bold mb-2">Selamat Datang di IniKue</h2>
      <p class="text-md mb-4">Temukan berbagai pilihan kue kering favoritmu di sini!</p>
      <a href="#" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded text-sm font-medium">Lihat Katalog</a>
    </section>

    <!-- Kategori -->
    <section class="py-8 px-6">
      <h3 class="text-xl font-semibold mb-4">Kategori Kue</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white shadow rounded p-4 text-center hover:shadow-lg transition">
          <i class="fas fa-star text-3xl text-pink-400 mb-2"></i>
          <p class="font-semibold">Premium</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center hover:shadow-lg transition">
          <i class="fas fa-heart text-3xl text-pink-400 mb-2"></i>
          <p class="font-semibold">Favorit</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center hover:shadow-lg transition">
          <i class="fas fa-gift text-3xl text-pink-400 mb-2"></i>
          <p class="font-semibold">Paket Spesial</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center hover:shadow-lg transition">
          <i class="fas fa-cookie text-3xl text-pink-400 mb-2"></i>
          <p class="font-semibold">Semua Kue</p>
        </div>
      </div>
    </section>

    <!-- Produk Unggulan -->
    <section class="py-8 px-6 bg-pink-50">
      <h3 class="text-xl font-semibold mb-4">Produk Unggulan</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <!-- Produk Card -->
        <div class="bg-white rounded shadow p-4 hover:shadow-lg transition">
          <img src="https://via.placeholder.com/200" alt="Nastar" class="w-full rounded mb-2" />
          <h4 class="font-bold text-lg">Nastar ORI</h4>
          <p class="text-sm text-gray-500">Rp 75.000</p>
          <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
        </div>
        <div class="bg-white rounded shadow p-4 hover:shadow-lg transition">
          <img src="https://via.placeholder.com/200" alt="Kastengel" class="w-full rounded mb-2" />
          <h4 class="font-bold text-lg">Kastengel</h4>
          <p class="text-sm text-gray-500">Rp 65.000</p>
          <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
        </div>
        <div class="bg-white rounded shadow p-4 hover:shadow-lg transition">
          <img src="https://via.placeholder.com/200" alt="Putri Salju" class="w-full rounded mb-2" />
          <h4 class="font-bold text-lg">Putri Salju</h4>
          <p class="text-sm text-gray-500">Rp 60.000</p>
          <button class="mt-2 bg-pink-500 hover:bg-pink-600 text-white py-1 px-4 rounded text-sm">Pesan</button>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4 text-sm text-gray-600 bg-pink-100 mt-8">
      &copy; 2025 IniKue. Semua Hak Dilindungi.
    </footer>
  </body>
</html>
