<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') - IniKue</title>
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

    <style>
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            10%,
            90% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .animate-fade-in-out {
            animation: fadeInOut 3s ease-in-out forwards;
        }
    </style>
</head>

<body class="bg-[#fff7f4] text-[#4e3d3a] font-sans">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Notifikasi -->
    @if (session('success'))
        <div id="notif-success"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-pink-400 text-white px-6 py-3 rounded shadow-lg z-50 text-center animate-fade-in-out">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>

</body>

</html>
