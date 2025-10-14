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
                        Accedi
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-dark btn-sm">
                            Iscriviti
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div class="d-flex justify-content-center w-100">
        <main class="container d-flex flex-column flex-lg-row align-items-center gap-5">
            <div class="card p-4 w-100 w-lg-75 bg-white text-dark shadow-sm">
                <div class="header-welcome-list text-center">
                    <h1 class="mb-2">Piattaforma Esami di Romiltec</h1>
                    <p class="mb-3 text-muted">Benvenuti Nella nostra piattaforma gestionale per i vostri
                        esami!
                    </p>
                </div>

                <div class="mb-4">
                    <form action="{{ route('exams.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="title" class="form-control" placeholder="Cerca per titolo">
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-dark w-100">Filtra</button>
                            </div>
                        </div>
                    </form>
                </div>

                <h2 class="text-center mb-4">Esplora la nostra banca dati</h2>

                @if (count($esami) > 0)
                    <table class="table table-bordered table-hover table-striped mb-4">
                        <thead>
                            <tr>
                                <th>Titolo Esame</th>
                                <th>Data Esame</th>
                                <th>Voto Assegnato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($esami as $esame)
                                <tr>
                                    <td><strong>{{ $esame->title }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}</td>
                                    <td>{{ $esame->vote ?? "Non Assegnato" }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Non ci sono esami disponibili al momento.</p>
                @endif
            </div>
        </main>
    </div>

    @if (Route::has('login'))
        <div class="h-4"></div>
    @endif

</body>

</html>
