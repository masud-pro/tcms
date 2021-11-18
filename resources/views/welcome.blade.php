<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CE CMS</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset("assets/frontpage/bootstrap.min.css") }}" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="{{ asset("assets/frontpage/cover.css") }}" rel="stylesheet">
  </head>
  <body style="background: url('{{ asset("images/frontpage/bg.jpg") }}'); background-size:cover; background-position: center center" class="d-flex h-100 text-center text-dark bg-light">
    
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="mb-auto">
    <div>
      <!-- <h3 class="float-md-start mb-0">CE CMS</h3>
      <nav class="nav nav-masthead justify-content-center float-md-end">
        <a class="nav-link active" aria-current="page" href="#">Login</a>
        <a class="nav-link" href="#">Register</a>
        <a class="nav-link" href="#">Contact</a>
      </nav> -->
    </div>
  </header>

  <main class="px-3">
    <h1 class="font-weight-bold">Welcome</h1>
    <p class="lead">Enjoy every course and learning. To enroll to courses you have to register first. After that you can enroll to courses. If you're already erolled please login.</p>
    <p class="lead">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-lg fw-bold text-light">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-lg fw-bold text-light">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-lg fw-bold text-light ms-3">Register</a>
                @endif
            @endif
        @endif
    </p>
  </main>

  <footer class="mt-auto text-dark-50">
    <!-- <p>Copyright <a href="https://codecstasy.com" class="text-dark">Code Ecstasy</a>, All Rights Reserved.</p> -->
  </footer>
</div>


    
  </body>
</html>

                
<html >

                    