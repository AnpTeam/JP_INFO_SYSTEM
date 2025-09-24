<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Japan Infomation System</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <!-- Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Font -->
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/backend.css') }}">
  @yield('css_before')
</head>

<body>
  <div class="d-flex">
    <!-- Sidebar: Always visible on lg+, Offcanvas on mobile -->
    <div class="offcanvas-lg offcanvas-start bg-danger text-white p-3 sidebar" tabindex="-1" id="sidebarMenu">
      <div class="offcanvas-header d-lg-none">
        <img src="{{asset('/storage/resource/logo-white.png')}}" alt="logo" class="logo-img offcanvas-title">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
          data-bs-target="#sidebarMenu"></button>
      </div>

      <!-- Logo -->
      <div>
        <img src="{{asset('/storage/resource/logo-white.png')}}" alt="logo" class="logo-img mb-4 d-none d-lg-block">
      </div>
      <!-- Navigation Bar -->
      <div>
        <ul class="nav flex-column">

          <!-- Home Page -->
          <li class="nav-item">
            <a href="/" class="nav-link text-white mb-2 d-flex align-items-center">
              <i class="fa-solid fa-house" style="width: 20px;"></i>
              <span class="ms-2">Return Homepage</span>
            </a>
          </li>

          <!-- Dashboard -->
          <li class="nav-item">
            <a href="#dashboardMenu"
              class="nav-link text-white mb-2 dropdown-toggle {{ request()->is('dashboard') ? 'active' : '' }}"
              data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="dashboardMenu">
              <i class="fa fa-chart-line" style="width: 20px;"></i>
              <span class="ms-2">Analytics</span>
            </a>

            <!-- Sub Drop Down -->
            <div class="collapse" id="dashboardMenu">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-4">
                <li>
                  <a href="{{ route('dashboard.table', ['table_name' => 'tbl_attraction']) }}"
                    class="nav-link text-white d-flex align-items-center">
                    <i class="fa-solid fa-location-dot" style="width: 20px;"></i>
                    <span class="ms-2">Attraction Table</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('dashboard.table', ['table_name' => 'tbl_user']) }}"
                    class="nav-link text-white d-flex align-items-center">
                    <i class="fa fa-user" style="width: 20px;"></i>
                    <span class="ms-2">User Table</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <!-- User Management -->
          <li class="nav-item">
            <a href="/user"
              class="nav-link text-white mb-2 d-flex align-items-center {{ request()->is('user*') ? 'active' : '' }}">
              <i class="fa fa-user" style="width: 20px;"></i>
              <span class="ms-2">User Management</span>
            </a>
          </li>

          <!-- Attraction Management -->
          <li class="nav-item">
            <a href="/attraction"
              class="nav-link text-white mb-2 d-flex align-items-center {{ request()->is('attraction*') ? 'active' : '' }}">
              <i class="fa-solid fa-location-dot" style="width: 20px;"></i>
              <span class="ms-2">Attraction Management</span>
            </a>
          </li>

          <!-- Region Management -->
          <li class="nav-item">
            <a href="/region"
              class="nav-link text-white mb-2 d-flex align-items-center {{ request()->is('region*') ? 'active' : '' }}">
              <i class="fa-solid fa-map-location-dot" style="width: 20px;"></i>
              <span class="ms-2">Region Management</span>
            </a>
          </li>

          <!-- Comment Management -->
          <li class="nav-item">
            <a href="/comment"
              class="nav-link text-white mb-2 d-flex align-items-center {{ request()->is('comment*') ? 'active' : '' }}">
              <i class="fa-solid fa-comments" style="width: 20px;"></i>
              <span class="ms-2">Comment Management</span>
            </a>
          </li>

          <!-- City Management -->
          <li class="nav-item">
            <a href="/city"
              class="nav-link text-white mb-2 d-flex align-items-center {{ request()->is('city*') ? 'active' : '' }}">
              <i class="fa-solid fa-city" style="width: 20px;"></i>
              <span class="ms-2">City Management</span>
            </a>
          </li>

          <!-- Category Management -->
          <li class="nav-item">
            <a href="/category"
              class="nav-link text-white mb-2 d-flex align-items-center {{ request()->is('category*') ? 'active' : '' }}">
              <i class="fa-solid fa-layer-group" style="width: 20px;"></i>
              <span class="ms-2">Category Management</span>
            </a>
          </li>

          <!-- Log Out -->
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link text-white d-flex align-items-center"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fa-solid fa-right-from-bracket" style="width: 20px;"></i>
              <span class="ms-2">Log Out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>

        </ul>
      </div>

      @yield('sidebar')
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-2">
      <!-- Mobile Toggle Button -->
      <button class="btn btn-danger d-lg-none mb-3" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
        <i class="fa fa-bars"></i> Menu
      </button>

      <div>
        <p class="mb-1 text-danger fs-2 text-end " style="font-weight: 900;">
          Backend Management System
        </p>
        <div class="d-flex flex-row-reverse">
                  <p class="text-muted ms-1 inline text-end">
          ({{session('user_email') }})
        </p> 
               <p class="fw-light fs-6 inline ms-1 text-end">
          You are logged in as {{ session('user_name') }}
        </p>
  
        </div>
      </div>

      <div class="container-fluid">
        <!-- Content Refenrence each views -->
        @yield('content')
      </div>

      <!-- Footer -->
      <footer class="mt-5 mb-2">
        <p class="text-center">by devbanban.com @2025</p>
      </footer>
      @yield('footer')
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @yield('js_before')

  <!-- Import JS SweetALert -->
  @include('sweetalert::alert')
</body>

</html>