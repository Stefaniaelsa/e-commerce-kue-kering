<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Keranjang Belanja</title>
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

<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans">

    <!-- Navbar -->
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


    <!-- Konten Keranjang -->
    <main class="flex-grow">
        <section class="max-w-5xl mx-auto py-10 px-4 sm:px-6">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-primary flex items-center">
                    <i class="fas fa-shopping-cart mr-3"></i> Keranjang Belanja
                </h2>
                <div class="bg-secondary px-4 py-2 rounded-full text-primary font-medium">
                    <i class="fas fa-coins mr-2"></i> Total:
                    Rp{{ number_format($cartItems->sum('harga'), 0, ',', '.') }}
                </div>
            </div>

            @if ($cartItems->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-pink-100">
                    <i class="fas fa-cart-shopping text-5xl text-primary mb-4 opacity-50"></i>
                    <h3 class="text-xl font-medium text-gray-600 mb-2">Keranjang kamu kosong</h3>
                    <p class="text-gray-500 mb-6">Yuk, temukan kue lezat untuk diisi ke keranjang!</p>
                    <a href="{{ url('/produk') }}"
                        class="inline-block bg-primary hover:bg-accent text-white py-2 px-6 rounded-full text-sm font-medium transition transform hover:-translate-y-1 shadow-md hover:shadow-lg">
                        <i class="fas fa-birthday-cake mr-2"></i> Belanja Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($cartItems as $item)
                        <div
                            class="bg-white rounded-xl shadow-sm overflow-hidden border border-pink-100 hover:shadow-md transition">
                            <div class="flex flex-col sm:flex-row">
                                <div class="sm:w-1/4 bg-secondary flex items-center justify-center p-4">
                                    <img src="{{ asset('images/' . $item->produk->gambar) }}"
                                        alt="{{ $item->produk->nama }}" class="w-full h-auto object-cover rounded-lg">
                                </div>
                                <div class="sm:w-3/4 p-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                        <div class="mb-4 sm:mb-0">
                                            <h3 class="text-xl font-bold text-primary">{{ $item->produk->nama }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">
                                                {{ $item->produk->deskripsi ?? 'Kue lezat dengan cita rasa istimewa' }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Ukuran: <span
                                                    class="font-semibold">{{ $item->varian->ukuran ?? 'Tidak ada varian' }}</span>
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-primary">
                                                Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                                            <p class="text-sm text-gray-500">@
                                                Rp{{ number_format($item->harga / $item->jumlah, 0, ',', '.') }}/pcs
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between">
                                        <div class="flex items-center mb-4 sm:mb-0">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                class="flex items-center space-x-2">
                                                @csrf
                                                @method('PUT')
                                                <button name="action" value="decrease"
                                                    class="w-8 h-8 flex items-center justify-center bg-primary hover:bg-accent text-white rounded-full transition">
                                                    <i class="fas fa-minus text-xs"></i>
                                                </button>
                                                <span
                                                    class="px-4 py-1 bg-secondary rounded-full font-medium">{{ $item->jumlah }}</span>
                                                <button name="action" value="increase"
                                                    class="w-8 h-8 flex items-center justify-center bg-primary hover:bg-accent text-white rounded-full transition">
                                                    <i class="fas fa-plus text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="text-red-500 hover:text-accent text-sm font-medium transition flex items-center">
                                                    <i class="fas fa-trash-alt mr-2"></i> Hapus Item
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 bg-white rounded-xl shadow-sm p-6 border border-pink-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="text-lg font-bold text-gray-700">Ringkasan Belanja</h3>
                            <p class="text-sm text-gray-500">{{ $cartItems->count() }} item dalam keranjang</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 mb-1">Subtotal:
                                Rp{{ number_format($cartItems->sum('harga'), 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600 mb-1">Ongkos Kirim: Rp10.000</p>
                            <div class="border-t border-gray-200 my-2"></div>
                            <p class="text-xl font-bold text-primary">Total:
                                Rp{{ number_format($cartItems->sum('harga') + 10000, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ url('/produk') }}"
                            class="bg-white border border-primary text-primary hover:bg-secondary py-3 px-6 rounded-full text-sm font-medium text-center transition">
                            <i class="fas fa-arrow-left mr-2"></i> Lanjut Belanja
                        </a>
                        <form action="{{ route('order.store') }}" method="POST">
                            @csrf
                            @foreach ($cartItems as $item)
                                <input type="hidden" name="items[]" value="{{ $item->id }}">
                            @endforeach
                            <button type="submit"
                                class="bg-gradient-to-r from-primary to-pink-400 hover:from-accent hover:to-pink-500 text-white py-3 px-6 rounded-full text-sm font-medium text-center shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                                <i class="fas fa-paper-plane mr-2"></i> Pesan
                            </button>

                        </form>

                    </div>
                </div>
            @endif
        </section>
    </main>

    <footer class="bg-gradient-to-r from-primary to-pink-300 text-white py-6 mt-12">
        <div class="max-w-5xl mx-auto px-4 text-sm text-center opacity-80">
            &copy; 2025 IniKue. Semua Hak Dilindungi.
        </div>
    </footer>
</body>

</html>
