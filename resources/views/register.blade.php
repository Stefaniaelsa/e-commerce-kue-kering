<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Toko Kue Kering</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            pinkCustom: '#ff69b4',
            pinkHover: '#ff4fa1',
            lightBrown: '#4e3d3a',
            bgCream: '#fff7f4'
          }
        }
      }
    }
  </script>
</head>
<body class="bg-bgCream text-lightBrown font-sans">

  <div class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col md:flex-row shadow-lg bg-white rounded-2xl overflow-hidden max-w-4xl w-full">
      
      <!-- Gambar -->
      <div class="hidden md:block md:w-1/2">
        <img src="{{ asset('images/logo.jpg') }}" alt="Kue Kering" class="object-cover w-full h-full" />
      </div>

      <!-- Form -->
      <div class="w-full md:w-1/2 p-8">
        <h3 class="text-center text-2xl font-bold text-gray-800 mb-2">Daftar di IniKue</h3>
        <p class="text-center text-sm text-gray-500 mb-6">
          Buat akun untuk mulai memesan kue kering favoritmu!
        </p>

         <!-- Menampilkan pesan error jika ada -->
         @if ($errors->any())
         <div class="bg-red-200 text-red-800 p-4 mb-4">
           <ul>
             @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
             @endforeach
           </ul>
         </div>
       @endif
       
        <form action="{{ route('register.process') }}" method="POST">
            @csrf        
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <div class="flex items-center border rounded-lg overflow-hidden">
              <span class="px-3 text-gray-500"><i class="fas fa-user"></i></span>
              <input type="text" name="name" id="name" placeholder="Nama lengkap" required
                class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pinkCustom" />
            </div>
          </div>

          <div class="mb-4">
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <div class="flex items-center border rounded-lg overflow-hidden">
              <span class="px-3 text-gray-500"><i class="fas fa-envelope"></i></span>
              <input type="email" name="email" id="email" placeholder="you@example.com" required
                class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pinkCustom" />
            </div>
          </div>

          <!-- Tambahkan ini setelah field Konfirmasi Password -->
            <div class="mb-4">
                <label for="nomor_telepon" class="block text-sm font-medium mb-1">Nomor Telepon</label>
                <div class="flex items-center border rounded-lg overflow-hidden">
                <span class="px-3 text-gray-500"><i class="fas fa-phone"></i></span>
                <input type="text" name="nomor_telepon" id="nomor_telepon" placeholder="08XXXXXXXXXX"
                    class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pinkCustom" />
                </div>
            </div>
            
            <div class="mb-6">
                <label for="alamat" class="block text-sm font-medium mb-1">Alamat</label>
                <div class="flex border rounded-lg overflow-hidden">
                <span class="px-3 pt-2 text-gray-500"><i class="fas fa-map-marker-alt"></i></span>
                <textarea name="alamat" id="alamat" rows="2" placeholder="Masukkan alamat lengkap"
                    class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pinkCustom resize-none"></textarea>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <div class="flex items-center border rounded-lg overflow-hidden">
                    <span class="px-3 text-gray-500"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" placeholder="••••••••" required
                           class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pinkCustom" />
                </div>
            </div>
            
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                <div class="flex items-center border rounded-lg overflow-hidden">
                    <span class="px-3 text-gray-500"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required
                           class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pinkCustom" />
                </div>
            </div>
            

          <button type="submit" class="w-full py-2 bg-pinkCustom hover:bg-pinkHover text-white font-semibold rounded-lg transition">
            Daftar
          </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="text-pinkCustom hover:text-pinkHover font-medium">Login di sini</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>
