@php
    $categories = \App\Models\Category::all();
@endphp

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-xl">
        <a class="navbar-brand" href="{{ route('pets.index') }}">
            <span class="brand-mark">🐾</span>
            <span>PawZone</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto align-items-lg-center gap-lg-1 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pets.index') ? 'active' : '' }}"
                        href="{{ route('pets.index') }}">
                        E'lonlar
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->filled('category') ? 'active' : '' }}" href="#"
                        id="navbarCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategoriyalar
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarCategories">
                        <li>
                            <a class="dropdown-item" href="{{ route('pets.index') }}">
                                Barchasi
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('pets.index', array_filter(['category' => $category->slug])) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                Admin Panel
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <div class="d-flex flex-wrap align-items-center gap-2 ms-lg-auto mt-3 mt-lg-0">
                @auth
                    <a href="{{ route('pets.create') }}" class="btn btn-gradient px-3">
                        + E'lon joylash
                    </a>

                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-inline-flex align-items-center gap-2 px-3 py-2" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="profile-avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <span class="dropdown-item-text text-muted small">
                                    {{ auth()->user()->email }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Chiqish
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary px-3">
                        Kirish
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-gradient px-3">
                        Ro'yxatdan o'tish
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
