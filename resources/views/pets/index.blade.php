@extends('layouts.app')

@section('title', 'PawZone - Uy hayvonlari katalogi')

@section('content')
<div class="container-xl">
    <div class="hero-surface mb-4">
        <div class="hero-grid">
            <div>
                <span class="hero-kicker">Katalog</span>
                <h1 class="hero-title">Yo'qolgan va topilgan hayvonlar bir joyda</h1>
                <p class="hero-subtitle">
                    Kategoriyalar, statuslar, joylashuv va qidiruv bo'yicha tez filtrlang. Dizayn sodda, o'qilishi oson va zamonaviy.
                </p>

                <div class="hero-badges">
                    <span class="chip chip-soft">{{ $pets->count() }} ta e'lon</span>
                    <span class="chip chip-success">{{ $categories->count() }} ta kategoriya</span>
                    <span class="chip">Tezkor qidiruv</span>
                </div>
            </div>

            <div class="hero-panel">
                <div class="fw-semibold mb-2">Bugun nima qilish mumkin?</div>
                <div class="text-muted small mb-3">
                    Yangi e'lon joylash, mavjudlarini filtr qilish yoki batafsil ko'rib chiqish.
                </div>
                <div class="page-actions">
                    @auth
                        <a href="{{ route('pets.create') }}" class="btn btn-gradient-success px-4">+ E'lon joylash</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-gradient px-4">Kirish</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4">Ro'yxatdan o'tish</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="section-card mb-4">
        @if(session('success'))
            <x-alert type="success" :msg="session('success')" />
        @endif

        <form method="GET" action="{{ route('pets.index') }}" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="form-label">Qidiruv</label>
                    <div class="input-group">
                        <span class="input-group-text">🔍</span>
                        <input type="text" name="search" class="form-control" placeholder="Nomi yoki tavsifi bo'yicha..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Turi</label>
                    <select name="type" class="form-select" onchange="this.form.submit()">
                        <option value="">Barchasi</option>
                        <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>Yo'qoldi</option>
                        <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>Topildi</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Holat</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Barchasi</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Faol</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Jarayonda</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Hal qilingan</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Joy</label>
                    <select name="location" class="form-select" onchange="this.form.submit()">
                        <option value="">Barchasi</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc }}" {{ request('location') === $loc ? 'selected' : '' }}>
                                {{ $loc }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Saralash</label>
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="" {{ !request('sort') ? 'selected' : '' }}>Yangi → Eski</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Eski → Yangi</option>
                        <option value="incident_desc" {{ request('sort') === 'incident_desc' ? 'selected' : '' }}>Sana bo'yicha</option>
                        <option value="location_asc" {{ request('sort') === 'location_asc' ? 'selected' : '' }}>Joy A → Z</option>
                        <option value="location_desc" {{ request('sort') === 'location_desc' ? 'selected' : '' }}>Joy Z → A</option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 align-items-center mt-4">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('pets.index', array_filter(['search' => request('search'), 'status' => request('status'), 'sort' => request('sort'), 'type' => request('type'), 'location' => request('location')])) }}"
                        class="text-decoration-none">
                        <span class="category-filter-card {{ !request('category') ? 'active' : '' }}">
                            <span class="category-icon">📦</span>
                            <span class="category-name">Barchasi</span>
                        </span>
                    </a>

                    @foreach($categories as $category)
                        <a href="{{ route('pets.index', array_filter(['category' => $category->slug, 'search' => request('search'), 'status' => request('status'), 'sort' => request('sort'), 'type' => request('type'), 'location' => request('location')])) }}"
                            class="text-decoration-none">
                            <span class="category-filter-card {{ request('category') === $category->slug ? 'active' : '' }}">
                                <span class="category-icon">
                                    @if($category->slug === 'mushuklar') 🐱
                                    @elseif($category->slug === 'itlar') 🐶
                                    @elseif($category->slug === 'qushlar') 🐦
                                    @elseif($category->slug === 'baliqlar') 🐟
                                    @else 🐾
                                    @endif
                                </span>
                                <span class="category-name">{{ $category->name }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>

                <div class="ms-auto d-flex align-items-center gap-2">
                    @if(request()->filled('search') || request()->filled('category') || request()->filled('status') || request()->filled('type') || request()->filled('location') || request()->filled('sort'))
                        <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary btn-sm px-3">Tozalash</a>
                    @endif
                    <button type="submit" class="btn btn-gradient btn-sm px-4">Filtrlash</button>
                </div>
            </div>
        </form>
    </div>

    @if($pets->count() > 0)
        <div class="row g-4">
            @foreach($pets as $pet)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 overflow-hidden">
                        <div class="position-relative">
                            @if($pet->image)
                                <img src="{{ asset('storage/' . $pet->image) }}" class="card-img-top" alt="{{ $pet->name }}" style="height: 220px;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 220px; background: linear-gradient(135deg, rgba(59,130,246,.90), rgba(124,58,237,.90));">
                                    <span class="display-5 text-white">🐾</span>
                                </div>
                            @endif

                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge badge-modern {{ $pet->status === 'available' ? 'bg-success' : ($pet->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                    {{ $pet->status === 'available' ? 'Faol' : ($pet->status === 'pending' ? 'Jarayonda' : 'Hal qilingan') }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <div class="mb-2 d-flex flex-wrap gap-2">
                                <span class="badge rounded-pill text-bg-light border">
                                    {{ $pet->type === 'lost' ? 'Yo\'qoldi' : 'Topildi' }}
                                </span>
                                <span class="badge rounded-pill text-bg-light border">
                                    {{ $pet->category->name }}
                                </span>
                            </div>

                            <h5 class="card-title mb-2">{{ $pet->name }}</h5>

                            @if($pet->location)
                                <div class="text-muted small mb-2">📍 {{ $pet->location }}</div>
                            @endif

                            @if($pet->description)
                                <p class="text-muted small mb-3 flex-grow-1" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $pet->description }}
                                </p>
                            @endif

                            @if($pet->incident_date)
                                <div class="text-muted small mb-3">📅 {{ $pet->incident_date->format('d.m.Y') }}</div>
                            @endif

                            <a href="{{ route('pets.show', $pet) }}" class="btn btn-gradient w-100 mt-auto">
                                Batafsil
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="section-card empty-state">
            <div class="emoji">😔</div>
            <h3 class="mb-2">Hayvonlar topilmadi</h3>
            <p class="mb-4">Boshqa so'z bilan qidirib ko'ring yoki filtrlarni olib tashlang.</p>
            <a href="{{ route('pets.index') }}" class="btn btn-gradient px-4">Barchasini ko'rish</a>
        </div>
    @endif
</div>
@endsection
