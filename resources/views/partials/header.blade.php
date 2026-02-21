@php
    $categories = \App\Models\Category::all();
@endphp

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('pets.index') }}">
            🐾 PawZone
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pets.index') ? 'active' : '' }}"
                        href="{{ route('pets.index') }}">
                        🏠 Bosh sahifa
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        📂 Kategoriyalar
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('pets.index') }}">
                                📦 Barchasi
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('pets.index') }}?category={{ $category->slug }}">
                                    @if($category->slug === 'mushuklar') 🐱
                                    @elseif($category->slug === 'itlar') 🐶
                                    @elseif($category->slug === 'qushlar') 🐦
                                    @elseif($category->slug === 'baliqlar') 🐟
                                    @endif
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    {{-- Кнопка добавить объявление — для всех авторизованных --}}
                    <li class="nav-item">
                        <a class="nav-link btn btn-gradient-success text-white px-3 me-2 {{ request()->routeIs('pets.create') ? 'active' : '' }}"
                            href="{{ route('pets.create') }}">
                            ➕ E'lon joylash
                        </a>
                    </li>

                    {{-- User dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span style="background:rgba(255,255,255,0.2); border-radius:50%; width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; font-size:1rem;">
                                {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            {{ auth()->user()->name }}
                            @if(auth()->user()->isAdmin())
                                <span class="badge" style="background:rgba(255,255,255,0.25); font-size:0.7rem; padding:2px 8px;">Admin</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <span class="dropdown-item-text text-muted small px-3">
                                    {{ auth()->user()->email }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(auth()->user()->isAdmin())
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('admin.*') ? 'fw-bold' : '' }}"
                                        href="{{ route('admin.dashboard') }}">
                                        🛡️ Admin Panel
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('dashboard') ? 'fw-bold' : '' }}"
                                    href="{{ route('dashboard') }}">
                                    📊 Dashboard
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        🚪 Chiqish
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Kirish</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-gradient text-white px-3" href="{{ route('register') }}">
                            Ro'yxatdan o'tish
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
