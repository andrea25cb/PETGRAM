<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PETGRAM</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" type="image/jpg" href="{{ asset('images/petgram_logo.png') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('vendor/laravel-scroll-pagination/scroll-pagination.css') }}"> --}}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('vendor/laravel-scroll-pagination/scroll-pagination.js') }}"></script> --}}
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-custom bg-success">
            <div class="container">

                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/petgram_logo.png') }}" width="30" height="30"
                        class="d-inline-block align-top">
                    PETGRAM
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('adopt') }}">{{ __('Adopt') }}</a>
                            </li>
                        @endguest
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posts') }}">{{ __('Posts') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('search') }}">{{ __('Search') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('myprofile') }}">{{ __('My Profile') }}</a>
                            </li>

                            @if (Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('pets.index') }}">{{ __('Pets') }}</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="#" role="button" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>

                            <li class="nav-item">

                                <a class="btn btn-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </li>
                        @endauth

                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>

        <footer class="bg-success py-1 fixed-bottom text-white">
            <div class="container">
                <div class="row" style="margin-top: 10px">
                    <div class="col-md-6">
                        <p>&copy; {{ date('Y') }} Petgram. Todos los derechos reservados.</p>
                    </div>
                    <div class="col-md-6 text-md-end ">
                        Andrea Cordón Barrionuevo
                    </div>
                </div>
            </div>
        </footer>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-/+M3oq8wvZnZZQyNH7oQ2sNVfy8vruy1p0d+TJpggrxW8qPGt/b0krCgYic7J2mW" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Kjsd5bdzvSZF21I6ZGzodC/3QXsUJ4T5+diAXNl5t2Dgqtm8P2bj5J7nqYLk0StR" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>


</body>

</html>
