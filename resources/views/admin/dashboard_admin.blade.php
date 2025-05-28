<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Toko Kue Kering</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
  </head>
  <body class="bg-[#fff7f4] font-sans text-[#4e3d3a]">
    <div class="flex h-screen">

      <!-- Sidebar -->
  <aside class="w-64 bg-pink-200 p-6 flex flex-col">
    <h2 class="text-2xl font-bold mb-8 text-center">IniKue</h2>
    <!-- Foto Profil -->
    <div class="flex flex-col items-center mb-8">
      <img src="{{ asset('images/admin.jpeg') }}" alt="Foto Profil" class="w-20 h-20 rounded-full mb-2 shadow">
      <p class="text-sm font-medium">Admin</p>
    </div>
    <nav class="space-y-4">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center text-[#4e3d3a] hover:text-pink-700">
        <i class="fas fa-home mr-2"></i> Dashboard
      </a>
      <a href="{{ route('admin.products.index') }}" class="flex items-center text-[#4e3d3a] hover:text-pink-700">
        <i class="fas fa-cookie mr-2"></i> Produk Kue
      </a>
      <a href="{{ route('admin.orders.index') }}" class="flex items-center text-[#4e3d3a] hover:text-pink-700">
        <i class="fas fa-shopping-cart mr-2"></i> Pesanan
      </a>
      <a href="{{ route('admin.users.index') }}" class="flex items-center text-[#4e3d3a] hover:text-pink-700">
        <i class="fas fa-users mr-2"></i> Pelanggan
      </a>
      <!-- Tambah menu Admin di sini -->
      <a href="{{ route('admin.admins.index') }}" class="flex items-center text-[#4e3d3a] hover:text-pink-700">
        <i class="fas fa-user-shield mr-2"></i> Admin
      </a>
      <a href="{{ route('logout') }}" class="flex items-center text-[#4e3d3a] hover:text-pink-700">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
      </a>
    </nav>
  </aside>

      <!-- Main Content -->
      <main class="flex-1 p-8 overflow-y-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-3xl font-semibold">Dashboard</h1>
          <div class="text-sm text-gray-600">Selamat datang, Admin!</div>
        </div>

        <!-- Card Section -->
        <!-- Card Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white p-6 rounded-lg shadow text-center">
            <i class="fas fa-cookie-bite text-3xl text-pink-400 mb-4"></i>
            <h2 class="text-lg font-semibold">Total Produk</h2>
            <p class="text-2xl font-bold mt-2">{{ $totalProduk }}</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow text-center">
            <i class="fas fa-shopping-basket text-3xl text-pink-400 mb-4"></i>
            <h2 class="text-lg font-semibold">Total Pesanan</h2>
            <p class="text-2xl font-bold mt-2">{{ $totalPesanan }}</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow text-center">
            <i class="fas fa-users text-3xl text-pink-400 mb-4"></i>
            <h2 class="text-lg font-semibold">Pelanggan</h2>
            <p class="text-2xl font-bold mt-2">{{ $totalPelanggan }}</p>
          </div>
        </div>

            <!-- Table Section -->
            <div class="bg-white rounded-lg shadow p-6">
              <h2 class="text-xl font-semibold mb-4">Pesanan Terbaru</h2>
              <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                  <thead>
                    <tr>
                      <th class="py-2 border-b">No</th>
                      <th class="py-2 border-b">Nama Pelanggan</th>
                      <th class="py-2 border-b">Produk</th>
                      <th class="py-2 border-b">Total</th>
                      <th class="py-2 border-b">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($pesananTerbaru as $pesanan)
                    <tr>
                      <td class="py-2 border-b">{{ $loop->iteration }}</td>
                      <td class="py-2 border-b">{{ $pesanan->user?->nama ?? 'User tidak ditemukan' }}</td>
                      <td class="py-2 border-b">{{ $pesanan->orderItems->pluck('product.name')->join(', ') }}</td>
                      <td class="py-2 border-b">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                      <td class="py-2 border-b text-{{ $pesanan->status == 'delivered' ? 'green' : ($pesanan->status == 'paid' ? 'yellow' : 'red') }}-600">
                        {{ ucfirst($pesanan->status) }}
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </main>
        </div>
      </body>
    </html>