<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm main_navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item "><a class="nav-link {{ active_class(if_route('repositories.index')) }}"
                        href="{{ route('repositories.index') }}">仓库</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('tutorials.index')}}">教程</a>
                <li class="nav-item"><a class="nav-link" href="{{route('suggestions.index')}}">建议</a>
                </li>
            </ul>

            <form class="d-flex" action="/search" method="GET">
                <input class="form-control me-2" name="q" type="search" placeholder="Search" aria-label="Search">
              </form>

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
                    {{-- new repo --}}
                    <li class="nav-item">
                        <a class="nav-link mt-1 " href="{{ route('repositories.create') }}">
                            <i class="fa-solid fa-plus "></i>
                        </a>
                    </li>
                    {{-- notification count --}}
                    <li class="nav-item notification-badge">
                        {{-- <a class="nav-link ms-3 me-3 badge bg-secondary rounded-pill badge-{{ auth()->user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white" --}}
                        <a class="tw-no-underline sm:tw-ml-2 me-2 badge bg-secondary rounded-pill badge-{{ auth()->user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white"
                            href="{{ route('notifications.index') }}">
                            {{auth()->user()->notification_count }}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ Auth::user()->avatar }}" class="float-start me-1 img-fluid rounded-circle"
                                style="width:30px;height:30px;" />
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">个人中心</a>
                            <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">编辑资料</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
