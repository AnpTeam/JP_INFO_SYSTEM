<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 12 Basic CRUD by devbanban.com 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
        .logo-img {
            height: 60px;
            width: auto;
            max-height: 60px;
        }

        .navbar-brand {
            font-family: 'Roboto', sans-serif;
            font-weight: 800;
            /* or 500 for slightly bolder */
        }

        .nav-link {
            font-family: 'Roboto', sans-serif;
        }

        .hero {
            height: 100vh;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .hero-overlay {
            background: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .hero-content {
            z-index: 2;
            text-align: center;
            width: 100%;
        }

        #topAttraction {}

        .card-overlay-center {
            top: -50%;
            /* adjust this to control how much it overlaps */
            left: 50%;
            transform: translateX(-50%);
            width: auto;
            height: 300px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            z-index: 10;
            width: auto;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .card-overlay-center .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .location-icon {
            font-size: 24px;
            /* Increased size */
            margin-bottom: 8px;
            color: #ffffffff;
        }

        .caption-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            background: rgba(0, 0, 0, 0.0);
            padding: 10px 20px;
            border-radius: 8px;
        }

        .card-title {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .card-text {
            font-size: 16px;
            margin: 4px 0 0;
        }

        .search-bar {
            background: #fff;
            padding: 10px;
            border-radius: 50px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .search-bar input,
        .search-bar select {
            border: none;
            outline: none;
            box-shadow: none;
        }

        .search-bar button {
            border-radius: 50px;
        }
    </style>
    @yield('css_before')
</head>

<body>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{asset('/storage/resource/logo-white.png')}}" alt="logo" class="logo-img">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="text-light nav-link active" href="/">Home</a></li>
                    <li class="nav-item"><a class="text-light nav-link" href="#">Listings</a></li>
                    <li class="nav-item"><a class="text-light nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="text-light nav-link" href="/detail">Blog</a></li>
                    <li class="nav-item"><a class="text-light nav-link" href="/dashboard">Back office</a></li>
                    <li class="nav-item">
                        @if (Auth::check())
                        <a href="#" class="nav-link text-light"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log out
                        </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        @else
                        <a href="{{ route('login') }}" class="bg-primary text-light nav-link">Log in</a>
                        @endif

                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('navbar')

    @yield('imgSlide')
    @yield('showAttractions')




    <footer class="mt-5 mb-2">
        <p class="text-center">by devbanban.com @2025</p>
    </footer>
    @yield('footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js_before')

    <!-- Import JS SweetALert -->
    @include('sweetalert::alert')
</body>

</html>