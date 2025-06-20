<!-- resources/views/components/sidebar.blade.php -->
<div x-data="{ open: window.innerWidth >= 640 }" @resize.window="open = window.innerWidth >= 640" class="relative">
  <!-- Toggle Button (Mobile Only) -->
  <button @click="open = !open"
          class="sm:hidden fixed top-4 left-4 z-50 bg-pink-500 text-white p-2 rounded-full shadow-lg">
    <i :class="open ? 'fas fa-times' : 'fas fa-bars'"></i>
  </button>

  <!-- Sidebar -->
  <aside
    class="bg-pink-200 p-6 flex flex-col w-64 h-screen fixed sm:relative z-40 transition-transform duration-300 transform sm:translate-x-0"
    :class="{ '-translate-x-full': !open && window.innerWidth < 640, 'translate-x-0': open || window.innerWidth >= 640 }">

    <!-- Logo -->
    <h2 class="text-2xl font-bold mb-8 text-center text-[#4e3d3a]">IniKue</h2>

    <!-- Foto Profil -->
    <div class="flex flex-col items-center mb-8">
      <img src="{{ asset('images/admin.jpeg') }}" alt="Foto Profil" class="w-20 h-20 rounded-full mb-2 shadow">
      <p class="text-sm font-medium text-[#4e3d3a]">Admin</p>
    </div>

    <!-- Navigasi -->
    <nav class="space-y-4">
      @php
        $navItems = [
          ['route' => 'admin.dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
          ['route' => 'admin.products.index', 'icon' => 'fas fa-cookie', 'label' => 'Produk Kue'],
          ['route' => 'admin.orders.index', 'icon' => 'fas fa-shopping-cart', 'label' => 'Pesanan'],
          ['route' => 'admin.pembayarans.index', 'icon' => 'fas fa-money-check-alt', 'label' => 'Pembayaran'],
          ['route' => 'admin.users.index', 'icon' => 'fas fa-users', 'label' => 'Pelanggan'],
          ['route' => 'admin.admins.index', 'icon' => 'fas fa-user-shield', 'label' => 'Admin'],
        ];
      @endphp

      @foreach ($navItems as $item)
        <a href="{{ route($item['route']) }}"
           class="flex items-center text-[#4e3d3a] hover:text-pink-700 transition-colors {{ request()->routeIs($item['route']) ? 'font-semibold text-pink-700' : '' }}"
           @click="if (window.innerWidth < 640) open = false">
          <i class="{{ $item['icon'] }} mr-2"></i> {{ $item['label'] }}
        </a>
      @endforeach

      <!-- Logout -->
      <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit"
                class="flex items-center text-[#4e3d3a] hover:text-pink-700 w-full text-left transition-colors">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
      </form>
    </nav>
  </aside>

  <!-- Overlay untuk HP -->
  <div 
    class="fixed inset-0 bg-black bg-opacity-40 z-30 sm:hidden"
    x-show="open && window.innerWidth < 640"
    @click="open = false"
    x-transition.opacity
  ></div>
</div>
