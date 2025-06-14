<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - IniKue</title>
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

<body class="bg-pink-50 text-gray-800 font-sans">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl w-full">

            <!-- Image -->
            <div class="md:w-1/2 hidden md:block">
                <img src="{{ asset('images/logo.jpg') }}" alt="Kue Kering" class="object-cover w-full h-full" />
            </div>

            <!-- Form -->
            <div class="md:w-1/2 w-full p-8">
                <h2 class="text-2xl font-bold text-center text-pink-600 mb-2">Selamat Datang di IniKue</h2>
                <p class="text-center text-sm text-gray-500 mb-6">Silakan masuk untuk mulai memesan kue kering
                    favoritmu!</p>

                @if (session('success'))
                    <div class="bg-green-500 text-white p-2 mb-4 rounded">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="bg-red-500 text-white p-2 mb-4 rounded">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login.proses') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i
                                    class="fas fa-envelope"></i></span>
                            <input type="email" name="email"
                                class="pl-10 w-full py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400"
                                placeholder="you@example.com" required />
                        </div>
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i
                                    class="fas fa-lock"></i></span>
                            <input type="password" name="password"
                                class="pl-10 w-full py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400"
                                placeholder="••••••••" required />
                        </div>
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2" name="remember"> Ingat saya
                        </label>
                        <a href="#" class="text-pink-500 hover:underline">Lupa Password?</a>
                    </div>

                    <button type="submit"
                        class="btn-pink w-full py-2 text-white font-semibold rounded-md transition">Login</button>

                    <p class="text-center text-sm mt-4">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-pink-500 font-semibold hover:underline">Daftar</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
