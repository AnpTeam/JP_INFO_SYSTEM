<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Japan Information System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            padding-top: 80px; /* fix navbar overlap */
        }

        .logo-img {
            height: 50px;
            width: auto;
            max-height: 50px;
        }

        .navbar-brand {
            font-weight: 700;
        }

        footer {
            margin-top: 80px;
        }
    </style>

    @yield('css_before')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('/storage/resource/logo-white.png') }}" alt="logo" class="logo-img">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('search', ['%']) }}">Attractions</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="{{ route('searchRegion', ['%']) }}">Regions</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/user">Back Office</a></li>

                    <li class="nav-item ms-4">
                        @if (Auth::check())
                            <a href="#" class="nav-link text-light"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Log out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="nav-link text-light fw-bold">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Log in
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container">
        @yield('showLogin')
    </main>

    <!-- Footer -->
    <footer class="text-center py-3 bg-light mt-auto">
        <p class="mb-0">by devbanban.com @2025</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js_before')
    
    <!-- Import JS SweetALert -->
    @include('sweetalert::alert')
</body>

</html>
