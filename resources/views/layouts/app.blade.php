<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">    
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    @yield('additionalHeader')

    <title>@yield('title')</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home.index') }}">Tâches</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs("home.index") ? 'active' : '' }}" href="{{ route('home.index') }}">Accueil</a>
                    </li>                
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs("task.index") ? 'active' : '' }}" href="{{ route('task.index') }}">Calendrier</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="p-4">
        @yield('content')
    </main>

    <!-- JS -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>