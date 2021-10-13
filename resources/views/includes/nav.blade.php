<nav class="navbar navbar-top navbar-expand-md navbar-light bg-glass sticky-top bg-transparent border-bottom shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <div><img src="{{ asset('/svg/laragram.svg') }}" class="laragram-logo-svg"
                    alt="{{ config('app.name') }}"></div>
            {{--<div class="laragram-logo pl-3">{{ config('app.name') }}</div>--}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    {{-- Search bar --}}
                    <form class="form-inline my-2 my-md-0" action="{{ route('users.index') }}" method="get">
                        <input class="form-control mr-sm-2"
                               type="text"
                               name="q"
                               placeholder="{{ __('Search') }}"
                               value="{{ $query ?? '' }}">
                    </form>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto align-items-md-center">
                {{-- Language Switcher --}}
                <li class="nav-item dropdown">
                    <button class="btn btn-outline-primary btn-block dropdown-toggle"
                            type="button"
                            id="dropdownMenuButton"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        @switch(session('language') ?? 'en')
                            @case('bn')
                            Bengali
                            @break

                            @case('hi')
                            Hindi
                            @break

                            @default
                            English
                        @endswitch
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item"
                           href="{{ route('change_language', ['language' => 'en']) }}">English</a>
                        <a class="dropdown-item"
                           href="{{ route('change_language', ['language' => 'bn']) }}">Bengali</a>
                        <a class="dropdown-item"
                           href="{{ route('change_language', ['language' => 'hi']) }}">Hindi</a>
                    </div>
                </li>
                {{-- Authentication Links --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item @if(request()->routeIs('posts.index')) active @endif">
                        <a href="{{ route('posts.index') }}" class="nav-link d-flex align-items-center"><i
                                class="@if(request()->routeIs('posts.index')) fas @else fal @endif fa-home text-xl mr-md-0 mr-2"></i>
                            <span class="d-md-none"> Home </span></a>
                    </li>
                    <li class="nav-item">
                        <a href="/messages" class="nav-link d-flex align-items-center"><i
                                class="fal fa-comment text-xl mr-md-0 mr-2"></i> <span class="d-md-none"> Messages
                            </span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('posts.explore') }}"
                           class="nav-link d-flex align-items-center @if(request()->routeIs('posts.explore')) active @endif"><i
                                class="@if(request()->routeIs('posts.explore')) fas @else fal @endif fa-compass text-xl mr-md-0 mr-2"></i>
                            <span class="d-md-none"> Explore
                            </span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('notifications.index') }}"
                           class="nav-link d-flex align-items-center @if(request()->routeIs('notifications.index')) active @endif"><i
                                class="@if(request()->routeIs('notifications.index')) fas @else fal @endif fa-heart text-xl mr-md-0 mr-2"></i>
                            <span class="d-md-none"> Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                                class="nav-avatar">
                            <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">
                                {{ __('My Profile') }}
                            </a>

                            @can('browse_admin')
                                <a class="dropdown-item" href="{{ url('/admin') }}">
                                    {{ __('Admin Panel') }}
                                </a>
                            @endcan

                            <a class="dropdown-item" href="{{ route('posts.create') }}">
                                {{ __('Add New Post') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
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
