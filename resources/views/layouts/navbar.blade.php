{{-- <header class="bg-pink-200 shadow p-4 flex justify-between items-center mt-16 md:mt-0">
    <h1 class="text-2xl font-bold">IniKue</h1>
    <nav class="space-x-4 text-sm">
        <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium">Beranda</a>
        <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium">Produk</a>
        <div class="relative inline-block">
            <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium">
                Keranjang
            </a>
            <span class="absolute -top-2 -right-3 bg-red-400 text-white rounded-full px-2 py-0.5 text-xs font-bold">
                {{ session('total_produk') }}
            </span>
        </div>
        <a href="{{ url('/profil') }}" class="hover:text-pink-700 font-medium">Akun</a>
        <a href="#" class="text-red-500 hover:text-red-700 font-medium"><i class="fas fa-sign-out-alt"></i>
            Logout</a>
    </nav>
</header> --}}

<!-- Navbar -->
<header class="bg-pink-200 shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold">IniKue</h1>
    <nav class="space-x-4 text-sm flex items-center">
        <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium">Beranda</a>
        <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium">Produk</a>
        <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium relative flex items-center">
            Keranjang
            @if (session('total-produk') > 0)
                <span
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    {{ session('total-produk') > 99 ? '99+' : session('total-produk') }}
                </span>
            @endif
            {{-- <i class="fas fa-shopping-cart mr-1"></i> --}}
        </a>
        <a href="{{ url('/profil') }}" class="hover:text-pink-700 font-medium">Akun</a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </nav>
</header>
