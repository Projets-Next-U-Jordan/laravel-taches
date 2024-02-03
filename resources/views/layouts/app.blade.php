<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">    
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    @yield('additionalHeader')

    <title>@yield('title')</title>
    @livewireStyles
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex" id="navbarNav">
                <a class="navbar-brand" href="{{ route('home.index') }}">Tâches</a>
                <ul class="navbar-nav">
                    @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs("home.index") ? 'active' : '' }}" href="{{ route('home.index') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs("task.index") ? 'active' : '' }}" href="{{ route('task.index') }}">Tâches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs("category.index") ? 'active' : '' }}" href="{{ route('category.index') }}">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs("task.calendar") ? 'active' : '' }}" href="{{ route('task.calendar') }}">Calendrier</a>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="d-flex" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(auth()->check())
                        <li class="nav-item">
                            <a class="nav-link">{{ auth()->user()->name }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs("login") ? 'active' : '' }}" href="{{ route('login') }}">
                                {{__('Login')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs("register") ? 'active' : '' }}" href="{{ route('register') }}">
                                {{__('Signup')}}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="p-4 pt-0">
        @yield('content')
    </main>

    <!-- JS -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @livewireScripts
</body>
</html>
