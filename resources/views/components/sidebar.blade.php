<!-- resources/views/components/sidebar.blade.php -->
<aside class="w-64 bg-pink-200 p-6 flex flex-col">
    <h2 class="text-2xl font-bold mb-8 text-center">IniKue</h2>
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
        <a href="#" class="flex items-center text-[#4e3d3a] hover:text-pink-700">
            <i class="fas fa-shopping-cart mr-2"></i> Pesanan
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center text-[#4e3d3a] hover:text-pink-700">
            <i class="fas fa-users mr-2"></i> Pelanggan
        </a>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="flex items-center text-[#4e3d3a] hover:text-pink-700">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>
</aside>
