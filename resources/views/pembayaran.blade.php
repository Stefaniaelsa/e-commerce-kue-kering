<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upload Bukti Pembayaran - IniKue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#fb7185',
                        secondary: '#fecdd3',
                        accent: '#e11d48',
                    },
                    animation: {
                        'bounce-slow': 'bounce 1.5s infinite',
                        'pulse-slow': 'pulse 2s infinite',
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-pink-200 shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold select-none">IniKue</h1>
        <nav class="space-x-6 text-sm flex items-center">
            <a href="{{ url('/beranda') }}" class="hover:text-pink-700 font-medium transition">Beranda</a>
            <a href="{{ url('/produk') }}" class="hover:text-pink-700 font-medium transition">Produk</a>
            <a href="{{ url('/pesanan') }}" class="hover:text-pink-700 font-medium transition">Pesanan Saya</a>
            <a href="#" class="hover:text-pink-700 font-medium transition">Akun</a>
            <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                @csrf
                <button type="submit"
                    class="text-red-600 hover:text-red-800 font-medium flex items-center space-x-1 transition">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </header>


    @if (session('success'))
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => { show = false;
                window.location.href = '{{ route('produk.index') }}'; }, 3000)">
            <div class="bg-white rounded-xl p-6 max-w-md w-full animate-fade-in">
                <div class="flex justify-end">
                    <button @click="show = false; window.location.href = '{{ route('produk.index') }}'"
                        class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Pembayaran Berhasil!</h3>
                <p class="text-gray-600 mb-4">{{ session('success') }}</p>
                <button @click="show = false; window.location.href = '{{ route('produk.index') }}'"
                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-accent transition-colors">
                    Lanjut Belanja
                </button>
            </div>
        </div>
    @endif

    <!-- Konten Upload Bukti Pembayaran -->
    <main class="flex-grow max-w-4xl mx-auto py-10 px-4 sm:px-6 w-full">
        <!-- Header dengan Back Button -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url('/pesanan') }}" class="bg-gray-200 hover:bg-gray-300 p-2 rounded-full transition">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </a>
            <h2 class="text-3xl font-bold text-primary flex items-center gap-3 select-none">
                <i class="fas fa-receipt text-primary"></i>
                Upload Bukti Pembayaran
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Detail Pesanan -->
            <div class="bg-white rounded-xl shadow-md border border-pink-100 p-6">
                <h3 class="text-xl font-bold mb-5 text-gray-700 border-b pb-2 flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-primary"></i>
                    Detail Pesanan
                </h3>

                <!-- Order ID -->
                <div class="mb-4 bg-secondary p-3 rounded-lg">
                    <span class="text-sm text-gray-600">Order ID:</span>
                    <span class="font-bold text-primary text-lg">#{{ $order->id ?? 'ORD001' }}</span>
                </div>

                <!-- Status -->
                <div class="mb-4 flex items-center gap-2">
                    <span class="text-sm text-gray-600">Status:</span>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-1"></i>
                        Menunggu Pembayaran
                    </span>
                </div>

                <!-- Total Pembayaran -->
                <div class="mb-6">
                    <div class="bg-primary text-white p-4 rounded-lg text-center">
                        <p class="text-sm opacity-90">Total Pembayaran</p>
                        <p class="text-2xl font-bold">Rp
                            {{ number_format($order->total_harga ?? 150000, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- Info Rekening -->
                <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
                    <h4 class="font-semibold text-green-800 mb-2 flex items-center gap-2">
                        <i class="fas fa-university"></i>
                        Informasi Transfer
                    </h4>
                    <div class="space-y-1 text-sm text-green-700">
                        <p><span class="font-semibold">Bank:</span> {{ $order->bank_tujuan ?? 'BCA' }}</p>
                        <p><span class="font-semibold">No. Rekening:</span> 123456</p>
                        <p><span class="font-semibold">Atas Nama:</span> Toko IniKue</p>
                    </div>
                </div>

                <!-- Countdown Timer -->
                <div class="mt-4 bg-red-50 border border-red-200 p-3 rounded-lg text-center">
                    <p class="text-sm text-red-600 mb-1">Batas waktu pembayaran:</p>
                    <div id="countdown" class="text-lg font-bold text-red-700"></div>
                </div>
            </div>

            <!-- Form Upload Bukti -->
            <div class="bg-white rounded-xl shadow-md border border-pink-100 p-6">
                <h3 class="text-xl font-bold mb-5 text-gray-700 border-b pb-2 flex items-center gap-2">
                    <i class="fas fa-upload text-primary"></i>
                    Upload Bukti Transfer
                </h3>

                @if (session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded-lg">
                        <p class="text-red-800 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('error') }}
                        </p>
                    </div>
                @endif

                <form action="{{ route('konfirmasi.upload', $order->id ?? 1) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Bank Selection -->
                    <div>
                        <label for="bank_asal" class="block text-sm font-semibold text-gray-700 mb-2">
                            Bank Asal <span class="text-red-600">*</span>
                        </label>
                        <select id="bank_asal" name="bank_asal" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition">
                            <option value="" disabled {{ old('bank_tujuan') ? '' : 'selected' }}>
                                Pilih Bank Asal
                            </option>
                            <option value="BCA">Bank BCA</option>
                            <option value="BNI">Bank BNI</option>
                            <option value="BRI">Bank BRI</option>
                            <option value="Mandiri">Bank Mandiri</option>
                            <option value="CIMB">Bank CIMB Niaga</option>
                            <option value="Permata">Bank Permata</option>
                            <option value="BSI">Bank Syariah Indonesia</option>
                        </select>
                        @error('bank_asal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Upload File -->
                    <div>
                        <label for="bukti_transfer" class="block text-sm font-semibold text-gray-700 mb-2">
                            Bukti Transfer <span class="text-red-600">*</span>
                        </label>
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition">
                            <input type="file" id="bukti_transfer" name="bukti_transfer" accept="image/*" required
                                class="hidden" onchange="previewImage(this)">
                            <label for="bukti_transfer" class="cursor-pointer">
                                <div id="upload-area">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">Klik untuk upload gambar</p>
                                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, JPEG (Max: 2MB)</p>
                                </div>
                                <div id="preview-area" class="hidden">
                                    <img id="preview-img" class="max-w-full max-h-48 mx-auto rounded-lg mb-2">
                                    <p class="text-sm text-green-600">Gambar siap diupload</p>
                                </div>
                            </label>
                        </div>
                        @error('bukti_transfer')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Tambahkan ini -->
                        <div id="size-error" class="hidden mt-2 bg-red-50 border border-red-200 p-3 rounded-lg">
                            <p class="text-red-800 flex items-center gap-2">
                                <i class="fas fa-exclamation-circle"></i>
                                Ukuran file melebihi 2MB! Silakan pilih file yang lebih kecil
                            </p>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Petunjuk Upload
                        </h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Pastikan foto bukti transfer jelas dan dapat dibaca</li>
                            <li>• Nominal transfer harus sesuai dengan total pembayaran</li>
                            <li>• Bukti transfer akan diverifikasi dalam 1x24 jam</li>
                            <li>• Anda akan mendapat notifikasi setelah pembayaran dikonfirmasi</li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submit-btn"
                        class="w-full bg-primary text-white py-3 px-6 rounded-full font-semibold text-lg hover:bg-accent transition transform hover:scale-105 shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Bukti Pembayaran
                    </button>
                </form>

                <!-- Tombol Bantuan -->
                <div class="mt-6 text-center">
                    <a href="#" class="text-primary hover:text-accent text-sm font-medium transition">
                        <i class="fas fa-question-circle mr-1"></i>
                        Butuh Bantuan?
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Preview image function
        function previewImage(input) {
            const uploadArea = document.getElementById('upload-area');
            const previewArea = document.getElementById('preview-area');
            const previewImg = document.getElementById('preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    uploadArea.classList.add('hidden');
                    previewArea.classList.remove('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Countdown timer
        function startCountdown() {
            // Ambil waktu pesanan dari server
            const tanggalPesanan = new Date("{{ $order->tanggal_pesanan }}");
            // Set deadline 24 jam setelah waktu pesanan
            const deadline = new Date(tanggalPesanan.getTime() + 24 * 60 * 60 * 1000);

            const countdownEl = document.getElementById('countdown');

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = deadline.getTime() - now;

                if (distance < 0) {
                    countdownEl.innerHTML = "EXPIRED";
                    countdownEl.classList.add('text-red-800', 'animate-pulse');
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownEl.innerHTML =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // Start countdown when page loads
        startCountdown();

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('bukti_transfer');
            const submitBtn = document.getElementById('submit-btn');
            const errorContainer = document.getElementById('size-error');

            // Sembunyikan pesan error sebelumnya
            errorContainer.classList.add('hidden');

            if (!fileInput.files[0]) {
                e.preventDefault();
                alert('Silakan pilih file bukti transfer terlebih dahulu');
                return;
            }

            // Validasi ukuran file
            if (fileInput.files[0].size > 2097152) { // 2MB dalam bytes
                e.preventDefault();
                errorContainer.classList.remove('hidden');
                return;
            }

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            submitBtn.disabled = true;
        });
    </script>

</body>

</html>
