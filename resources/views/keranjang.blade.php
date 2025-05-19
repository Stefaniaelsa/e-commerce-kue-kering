<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Keranjang Belanja</title>
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
      <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium">Keranjang</a>
      <a href="#" class="hover:text-pink-700 font-medium">Akun</a>
      <a href="#" class="text-red-500 hover:text-red-700 font-medium"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </header>

<<<<<<< HEAD
  <!-- Konten Keranjang -->
  <section class="max-w-5xl mx-auto py-10 px-6">
    <h2 class="text-2xl font-bold mb-6">Keranjang Belanja</h2>

    @if ($cartItems->isEmpty())
      <p class="text-gray-600">Keranjang kamu kosong.</p>
    @else
      <div class="overflow-x-auto">
        <table class="w-full table-auto text-left bg-white shadow rounded-lg overflow-hidden">
          <thead class="bg-pink-100 text-pink-700 text-sm uppercase">
            <tr>
              <th class="px-6 py-4">Produk</th>
              <th class="px-6 py-4">Jumlah</th>
              <th class="px-6 py-4">Harga Satuan</th>
              <th class="px-6 py-4">Subtotal</th>
              <th class="px-6 py-4">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-pink-100">
            @foreach ($cartItems as $item)
              <tr>
                <td class="px-6 py-4 font-medium">{{ $item->produk->nama }}</td>
                <td class="px-6 py-4">
  <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
    @csrf
    @method('PUT')
    <button name="action" value="decrease" class="px-2 py-1 bg-pink-300 hover:bg-pink-400 rounded text-white">-</button>
    <span class="px-2">{{ $item->jumlah }}</span>
    <button name="action" value="increase" class="px-2 py-1 bg-pink-500 hover:bg-pink-600 rounded text-white">+</button>
  </form>
</td>


                <td class="px-6 py-4">Rp{{ number_format($item->harga / $item->jumlah, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-pink-600 font-semibold">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                  <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 text-sm">
                      <i class="fas fa-trash"></i> Hapus
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

     <div class="text-right mt-6">
  <p class="text-xl font-bold">Total: Rp{{ number_format($cartItems->sum('harga'), 0, ',', '.') }}</p>
  <a href="{{ route('checkout.index') }}" class="mt-4 inline-block bg-pink-500 hover:bg-pink-600 text-white py-2 px-6 rounded text-sm">
    Lanjut ke Pembayaran
  </a>
</div>

=======
  <section class="max-w-4xl mx-auto py-10 px-6">
    <h2 class="text-2xl font-bold mb-6">Keranjang Belanja</h2>

    @if (session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if ($cartItems->isEmpty())
      <p class="text-gray-600">Keranjang kamu kosong.</p>
    @else
      <form method="POST" action="{{ route('order.store') }}">
        @csrf
        <div class="space-y-6">
          @foreach ($cartItems as $item)
            <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow">
              <div class="flex items-start space-x-4">
                <img src="{{ asset('images/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama }}" class="w-24 h-24 object-cover rounded">

                <div>
                  <p class="font-semibold text-lg">{{ $item->produk->nama }}</p>

                  @if ($item->variant)
                    <p class="text-sm text-gray-500">Ukuran: {{ $item->variant->ukuran }}</p>
                    <p class="text-pink-600 text-sm font-medium">Harga Satuan: Rp{{ number_format($item->variant->harga, 0, ',', '.') }}</p>
                  @else
                    <p class="text-pink-600 text-sm font-medium">Harga Satuan: Rp{{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</p>
                  @endif

                  <p class="text-sm mt-2">Subtotal: <span class="font-medium">Rp{{ number_format($item->harga, 0, ',', '.') }}</span></p>
                </div>
              </div>

              <div class="flex flex-col items-end space-y-2">
                <input type="checkbox" name="items[]" value="{{ $item->id }}" class="w-4 h-4">

                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="text-red-500 hover:text-red-700 text-sm">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-6 text-right">
          <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-2 rounded-lg shadow">
            <i class="fas fa-shopping-cart mr-1"></i> Pesan
          </button>
        </div>
      </form>
>>>>>>> 9ca95c3cd02cd77791052b91d70f3349401682b7
    @endif
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-sm text-gray-600 bg-pink-100">
    &copy; 2025 IniKue. Semua Hak Dilindungi.
  </footer>

</body>
</html>
