<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - IniKue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
    <style>
        .btn-pink {
            background-color: #ec4899;
        }

        .btn-pink:hover {
            background-color: #db2777;
        }
    </style>
</head>

<body class="bg-pink-50 text-gray-800 font-sans px-4">
    <div class="min-h-screen flex items-center justify-center py-10">
        <div class="flex flex-col lg:flex-row bg-white rounded-2xl shadow-lg overflow-hidden w-full max-w-5xl">
            <!-- Gambar -->
            <div class="md:w-1/2 hidden md:block">
                <img src="{{ asset('images/logo.jpg') }}" alt="Kue Kering" class="object-cover w-full h-full" />
            </div>

            <!-- Form -->
            <div class="lg:w-1/2 p-8">
                <h2 class="text-2xl font-bold text-center text-pink-600 mb-2">Daftar di IniKue</h2>
                <p class="text-sm text-center text-gray-600 mb-6">Buat akun untuk mulai memesan kue favoritmu!</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label class="block mb-1 font-medium">Nama Lengkap</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                            <i class="fas fa-user mr-2 text-gray-400"></i>
                            <input type="text" name="name" class="w-full outline-none" placeholder="Nama lengkap"
                                required>
                        </div>
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            <input type="email" name="email" class="w-full outline-none"
                                placeholder="you@example.com" required>
                        </div>
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label class="block mb-1 font-medium">Nomor Telepon</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                            <i class="fas fa-phone mr-2 text-gray-400"></i>
                            <input type="text" name="phone" class="w-full outline-none" placeholder="08XXXXXXXXXX"
                                required>
                        </div>
                        @error('phone')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block mb-1 font-medium">Alamat</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                            <input type="text" name="alamat" class="w-full outline-none"
                                placeholder="Alamat lengkap" required>
                        </div>
                        @error('alamat')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block mb-1 font-medium">Password</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password"
                                class="w-full px-10 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-pink-500"
                                placeholder="••••••••" required autocomplete="new-password" />
                        </div>
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block mb-1 font-medium">Konfirmasi Password</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>
                            <input type="password" name="password_confirmation" class="w-full outline-none" required
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit"
                        class="btn-pink w-full py-2 rounded-lg text-white font-semibold transition">Daftar</button>

                    <p class="text-center text-sm text-gray-600 mt-4">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-pink-500 font-semibold hover:underline">Login di
                            sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
