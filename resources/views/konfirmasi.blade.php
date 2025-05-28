<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk Kue - IniKue</title>
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
            <a href="{{ url('/keranjang') }}" class="hover:text-pink-700 font-medium">Keranjang</a>
            <a href="{{ url('/profil') }}" class="hover:text-pink-700 font-medium">Akun</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </header>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Kirim Bukti Transfer</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('konfirmasi.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf
        
        <div class="mb-4">
            <label for="order_id" class="block font-medium mb-1">Order ID</label>
            <input type="text" id="order_id" name="order_id" value="{{ old('order_id') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
        </div>

        <div class="mb-4">
            <label for="metode" class="block font-medium mb-1">Metode Pembayaran</label>
            <select id="metode" name="metode" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400">
                <option value="" disabled selected>Pilih metode pembayaran</option>
                <option value="transfer">Transfer Bank</option>
                <option value="ewallet">E-Wallet</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="bukti_transfer" class="block font-medium mb-1">Upload Bukti Transfer</label>
            <input type="file" id="bukti_transfer" name="bukti_transfer" accept="image/*,application/pdf" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF. Maksimal 2MB.</p>
        </div>

        <button type="submit"
            class="bg-gradient-to-r from-primary to-pink-400 hover:from-accent hover:to-pink-500 text-white py-3 px-6 rounded-full text-sm font-medium shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
            Kirim Bukti Transfer
        </button>
    </form>
</div>
@endsection
