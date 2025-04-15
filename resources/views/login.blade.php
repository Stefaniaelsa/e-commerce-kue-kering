<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Toko Kue Kering</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />

    <!-- CSS Internal (Optional, for specific styling) -->
    <style>
        /* Custom Tailwind Styles */
        .btn-pink {
            background-color: #ff69b4;
            border: none;
        }

        .btn-pink:hover {
            background-color: #ff4fa1;
        }
    </style>
  </head>
  <body class="bg-[#fff7f4] font-sans text-[#4e3d3a]">
    <div class="container mx-auto flex justify-center items-center min-h-screen">
      <div class="flex flex-col md:flex-row w-full max-w-4xl shadow-lg rounded-lg overflow-hidden bg-white">
        <!-- Gambar -->
        <div class="md:w-1/2 hidden md:block">
          <img src="../assets/image/logo.png" alt="Kue Kering" class="object-cover w-full h-full" />
        </div>

        <!-- Form Login -->
        <div class="md:w-1/2 p-8">
          <h3 class="text-center text-2xl font-semibold text-dark mb-2">Selamat Datang di IniKue</h3>
          <p class="text-center text-sm text-muted mb-4">Silakan masuk untuk mulai memesan kue kering favoritmu!</p>

          <?php
            // Tangani pengiriman form
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST['email'];
                $password = $_POST['password'];

                // Contoh validasi sederhana
                if ($email === "admin@inikue.com" && $password === "password123") {
                    echo '<div class="alert alert-success bg-green-500 text-white p-2 mb-4 rounded">Login berhasil!</div>';
                    // Redirect atau set session bisa dilakukan di sini
                } else {
                    echo '<div class="alert alert-danger bg-red-500 text-white p-2 mb-4 rounded">Email atau password salah!</div>';
                }
            }
          ?>

          <form method="POST" action="">
            <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                  <i class="fas fa-envelope"></i>
                </span>
                <input type="email" class="form-control w-full px-10 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-pink-500" id="email" name="email" placeholder="you@example.com" required />
              </div>
            </div>

            <div class="mb-4">
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                  <i class="fas fa-lock"></i>
                </span>
                <input type="password" class="form-control w-full px-10 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-pink-500" id="password" name="password" placeholder="••••••••" required />
              </div>
            </div>

            <div class="mb-4 flex justify-between items-center">
              <div class="flex items-center">
                <input type="checkbox" class="mr-2" id="remember" />
                <label for="remember" class="text-sm text-gray-700">Remember me</label>
              </div>
              <a href="#" class="text-sm text-red-500">Forgot Password?</a>
            </div>

            <div class="mb-4">
              <button type="submit" class="btn-pink w-full py-2 rounded-md text-white">Login</button>
            </div>

            <p class="mt-4 text-center text-sm text-muted">
              Belum punya akun? <a href="../pages/register.php" class="text-red-500">Daftar</a>
            </p>
          </form>
        </div>
      </div>
    </div>

  </body>
</html>
