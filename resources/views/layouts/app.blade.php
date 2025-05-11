<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard') - Toko Kue Kering</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-[#fff7f4] font-sans text-[#4e3d3a]">
    <div class="flex h-screen">

        {{-- Sidebar Include --}}
        @include('components.sidebar')

        {{-- Konten utama --}}
        <main class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>
