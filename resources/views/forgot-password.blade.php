<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - IniKue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 font-sans text-gray-800">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4 text-pink-600">Reset Password</h2>

            @if (session('status'))
                <div class="bg-green-100 p-3 rounded mb-4">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 p-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" required class="w-full border px-3 py-2 rounded mb-4"/>

                <button class="w-full bg-pink-500 text-white py-2 rounded hover:bg-pink-600">
                    Kirim Link Reset
                </button>
            </form>

            <div class="text-center mt-4 text-sm">
                <a href="{{ route('login') }}" class="text-pink-500 hover:underline">← Kembali ke Login</a>
            </div>
        </div>
    </div>
</body>
</html>
