<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Documentos') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    />

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css" >
    
    <!-- <script src="https://cdn.tailwindcss.com" defer></script> -->
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo" src="{{asset('storage/event_logos/Placeholder.jpg')}}" alt="Website logo" height="48"/>
                    <!-- {{ config('app.name', 'Documentos') }} -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                        <li class="nav-item my-auto">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <x-nav-menu/>
                    @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
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
                        @else
                            @role(['event moderator', 'reviewer', 'user'])  
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ "Meus eventos" }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end scrollable-dropdown-menu" aria-labelledby="navbarDropdown">
                                    @can('events.subscribe')
                                        @php
                                            $events = Auth::user()->events()->get();
                                        @endphp
                                        @if($events->isEmpty())
                                            <div class="dropdown-item rounded-0 disabled">
                                                Não há eventos inscritos
                                            </div>
                                        @else
                                            @foreach ($events as $event)
                                                <a class="dropdown-item btn rounded-0 truncate-cell" href="{{ route('showEvent', $event)}}">
                                                    {{$event->name}}
                                                </a>
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $events = Auth::user()->eventsmoderated()->get();
                                        @endphp
                                        @if($events->isEmpty())
                                            <div class="dropdown-item rounded-0 disabled">
                                                Não há eventos
                                            </div>
                                        @else
                                            @foreach ($events as $event)
                                                <a class="dropdown-item btn rounded-0" href="{{ route('showEvent', $event)}}">
                                                    {{$event->name}}
                                                </a>
                                            @endforeach
                                        @endif
                                    @endcan
                                </div>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->user_name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @can('switch roles')
                                        @role('reviewer')
                                            <a class="dropdown-item btn rounded-0" href="{{route('switchRoles', Auth::user())}}">
                                                Entrar como usuário
                                            </a>
                                        @elserole('user')
                                            <a class="dropdown-item btn rounded-0" href="{{route('switchRoles', Auth::user())}}">
                                                Entrar como avaliador
                                            </a>
                                        @endif
                                    @endif
                                    <a class="dropdown-item btn rounded-0" href="{{route('showUser', Auth::user())}}">
                                        Minha conta
                                    </a>

                                    <a class="dropdown-item btn rounded-0" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Sair') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>

            </div>
        </nav>
        <x-flash-message />
        <main class="py-4">
            @yield('content')
            @yield('page-script')
        </main>
    </div>
</body>
</html>
