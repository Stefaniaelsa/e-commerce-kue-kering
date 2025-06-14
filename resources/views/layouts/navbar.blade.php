<!-- Navbar -->
<header class="bg-pink-200 shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold">IniKue</h1>
    <nav class="space-x-4 text-sm flex items-center">
        <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium text-base">Beranda</a>
        <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium text-base">Produk</a>

        <!-- Keranjang dengan Icon -->
        <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium relative flex items-center p-2">
            <i class="fas fa-shopping-cart text-base"></i>
            @if (session('total-produk') > 0)
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    {{ session('total-produk') > 99 ? '99+' : session('total-produk') }}
                </span>
            @endif
        </a>

        <!-- Akun dengan Dropdown -->
        <div class="relative group">
            <button class="hover:text-pink-700 font-medium flex items-center p-2">
                <i class="fas fa-user text-base"></i>
            </button>

            <!-- Dropdown Menu -->
            <div
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <a href="{{ url('/profil') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700">
                        <i class="fas fa-user-circle mr-2"></i>Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Alert Error -->
@if (session('error'))
    <div class="max-w-5xl mx-auto px-4 mt-4">
        <div class="bg-pink-100 border border-pink-400 text-pink-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Maaf!</strong>
            <span class="block sm:inline">Jumlah produk yang ingin kamu tambahkan melebihi stok yang tersedia.</span>
        </div>
    </div>
@endif
