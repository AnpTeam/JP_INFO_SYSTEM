<!doctype html>
<html lang="en">
  <!-- HEAD -->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 12 Basic CRUD by devbanban.com 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    @yield('css_before')
  </head>
  
  <!-- BODY -->
  <body>
    <!-- .container START  -->
    <div class="container">
      <!-- .row START  -->
      <div class="row">
        <!-- .col START  -->
        <div class="col">
          <!-- .alert START  -->
          <div class="alert alert-dark text-center" role="alert">
            <h4>Back Office || Laravel 12 || ยินดีต้อนรับคุณ Admin</h4>
          </div>
          <!-- .alert END  -->    
          </div>
        <!-- .col END  -->          
      </div>
      <!-- .row END  -->
    </div>
    <!-- .container END  -->

    @yield('header')

    <!-- .container START  -->
    <div class="container">
      <!-- .row START  -->
      <div class="row">
        <!-- .col-md-3 START  -->
        <div class="col-md-3">
          <!-- .list-group START  -->
          <div class="list-group">
            <a href="/" class="list-group-item list-group-item-action active bg-danger border-danger" aria-current="true">
              Home
            </a>
            <!-- SIDE VIEW -->
            <a href="/dashboard" class="list-group-item list-group-item-action">  - DASHBOARD </a>
            <a href="/user" class="list-group-item list-group-item-action">  - USER CRUD </a>
            <a href="/attraction" class="list-group-item list-group-item-action">  - ATTRACTIONS CRUD </a>
            <a href="/region" class="list-group-item list-group-item-action">  - REGION CRUD </a>
            <a href="/comment" class="list-group-item list-group-item-action">  - COMMENT CRUD </a>
            <!-- SIDE VIEW END -->
          </div>
          <!-- .list-group END  -->
          @yield('sidebarMenu')
        </div>
        <!-- .col-md-3 END  -->

        <!-- .col-md-9 START  -->
        <div class="col-md-9">
          @yield('content')
        </div>
        <!-- .col-md-9 END  -->
      </div>
      <!-- .row END  -->
    </div>
    <!-- .container END  -->

    <!-- Footer START  -->
    <footer class="mt-5 mb-2">
      <p class="text-center">by devbanban.com @2025</p>
    </footer>
    <!-- Footer END  -->
    @yield('footer')


    <!-- Import JS Boostraps -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    @yield('js_before')
    
    <!-- Import JS SweetALert -->
    {{-- >>>>>>> ตรงนี้สำคัญ <<<<<<< --}}
    @include('sweetalert::alert')
  </body>
</html>
