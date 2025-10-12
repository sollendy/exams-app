<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif
</head>

<body>
    <header class="container d-flex justify-content-end my-3">
        @if (Route::has('login'))
            <nav class="d-flex gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark btn-sm">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-dark btn-sm">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div class="d-flex justify-content-center w-100">
        <main class="container d-flex flex-column flex-lg-row align-items-center gap-5">
            <div class="card p-4 w-100 w-lg-75 bg-white text-dark shadow-sm">
                <h1 class="mb-2 text-center">Piattaforma Esami di Romiltec</h1>
                <p class="mb-3 text-muted text-center">Benvenuti Nella nostra piattaforma gestionale per i vostri esami!
                </p>

                <ul class="list-unstyled mb-4">
                    <li class="d-flex align-items-center gap-3 py-2">
                        <span class="circle-icon"></span>
                        <span>
                            Read the
                            <a href="https://laravel.com/docs" target="_blank"
                                class="text-danger text-decoration-underline">
                                Documentation
                            </a>
                        </span>
                    </li>
                    <li class="d-flex align-items-center gap-3 py-2">
                        <span class="circle-icon"></span>
                        <span>
                            Watch video tutorials at
                            <a href="https://laracasts.com" target="_blank"
                                class="text-danger text-decoration-underline">
                                Laracasts
                            </a>
                        </span>
                    </li>
                </ul>
                <ul class="list-unstyled d-flex gap-3">
                    <li>
                        <a href="https://cloud.laravel.com" target="_blank" class="btn btn-dark text-white">
                            Deploy now
                        </a>
                    </li>
                </ul>
            </div>
        </main>
    </div>

    @if (Route::has('login'))
        <div class="h-4"></div>
    @endif

</body>

</html>
