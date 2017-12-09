<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/pickadate/default.css') }}" rel="stylesheet">
        <link href="{{ asset('css/pickadate/default.date.css') }}" rel="stylesheet">
        <link href="{{ asset('css/pickadate/default.time.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <div class="container">
                



            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded my-2 mb-5">
              <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>

              <!-- Collapsed Hamburger -->
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse justify-content-md-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                          </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                @endguest
                  </li>
                </ul>
              </div>
            </nav>





          

            @yield('content')
        
            </div>

        </div><!-- DIV.APP -->
    <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/pickadate/picker.js') }}"></script>
        <script src="{{ asset('js/pickadate/pickfr.js') }}"></script>
        <script src="{{ asset('js/pickadate/picker.date.js') }}"></script>
        <script src="{{ asset('js/pickadate/picker.time.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>
    </body>
</html>
