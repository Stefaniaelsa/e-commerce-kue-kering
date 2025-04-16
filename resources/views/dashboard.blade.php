<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Link ke Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo center">Dashboard</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('login') }}">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Konten Dashboard -->
    <div class="container">
        <h4>Welcome, {{ Auth::user()->name }}</h4>
        <p>Ini adalah dashboard Anda. Anda dapat menambahkan lebih banyak fitur di sini.</p>
        
        <!-- Card -->
        <div class="row">
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-image">
                        <img src="https://via.placeholder.com/150" alt="Image">
                        <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                        <p>Some content for the card.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
