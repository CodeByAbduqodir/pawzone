@extends('layouts.app')

@section('title', 'PawZone - Uy hayvonlari katalogi')

@section('content')
<div class="container my-5">
    <div class="glass-container">

        @if(session('success'))
            <x-alert type="success" :msg="session('success')" />
        @endif

        <div class="mb-4 text-center">
            <h1 class="display-4 fw-bold mb-2">🐾 PawZone</h1>
            <p class="lead text-muted">Uy hayvonlari katalogi</p>
        </div>

        {{-- Поисковая строка --}}
        <form method="GET" action="{{ route('pets.index') }}" id="filterForm">
            <div class="mb-4">
                <div class="input-group input-group-lg shadow-sm">
                    <span class="input-group-text bg-white border-end-0" style="border-color:#dee2e6;">
                        🔍
                    </span>
                    <input
                        type="text"
                        name="search"
                        class="form-control border-start-0 ps-0"
                        placeholder="Hayvon nomi yoki xususiyatlari bo'yicha qidiring..."
                        value="{{ request('search') }}"
                        style="border-color:#dee2e6;"
                    >
                    @if(request('search') || request('category') || request('status') || request('sort'))
                        <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
                            ✕ Tozalash
                        </a>
                    @endif
                    <button type="submit" class="btn btn-gradient px-4">Qidirish</button>
                </div>
            </div>

            {{-- Категории --}}
            <div class="mb-4">
                <div class="row g-2 justify-content-center">
                    <div class="col-auto">
                        <a href="{{ route('pets.index', array_filter(['search' => request('search'), 'status' => request('status'), 'sort' => request('sort')])) }}"
                            class="text-decoration-none">
                            <div class="category-filter-card px-3 py-2 {{ !request('category') ? 'active' : '' }}"
                                style="display:inline-flex; align-items:center; gap:6px; min-width:unset; border-radius:0;">
                                <span>📦</span>
                                <span class="category-name">Barchasi</span>
                            </div>
                        </a>
                    </div>
                    @foreach($categories as $category)
                        <div class="col-auto">
                            <a href="{{ route('pets.index', array_filter(['category' => $category->slug, 'search' => request('search'), 'status' => request('status'), 'sort' => request('sort')])) }}"
                                class="text-decoration-none">
                                <div class="category-filter-card px-3 py-2 {{ request('category') === $category->slug ? 'active' : '' }}"
                                    style="display:inline-flex; align-items:center; gap:6px; min-width:unset; border-radius:0;">
                                    <span>
                                        @if($category->slug === 'mushuklar') 🐱
                                        @elseif($category->slug === 'itlar') 🐶
                                        @elseif($category->slug === 'qushlar') 🐦
                                        @elseif($category->slug === 'baliqlar') 🐟
                                        @else 🐾
                                        @endif
                                    </span>
                                    <span class="category-name">{{ $category->name }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Фильтры: тип + статус + сортировка --}}
            <div class="d-flex flex-wrap align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #e9ecef;">
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-semibold text-muted small mb-0">E'lon turi:</label>
                    <select name="type" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Barchasi</option>
                        <option value="lost"  {{ request('type') === 'lost'  ? 'selected' : '' }}>😢 Yo'qoldi</option>
                        <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>🎉 Topildi</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-semibold text-muted small mb-0">Holat:</label>
                    <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Barchasi</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>✅ Faol</option>
                        <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>⏳ Jarayonda</option>
                        <option value="sold"      {{ request('status') === 'sold'      ? 'selected' : '' }}>✔️ Yopilgan</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-semibold text-muted small mb-0">Saralash:</label>
                    <select name="sort" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value=""              {{ !request('sort')                    ? 'selected' : '' }}>Yangi → Eski</option>
                        <option value="oldest"        {{ request('sort') === 'oldest'        ? 'selected' : '' }}>Eski → Yangi</option>
                        <option value="incident_desc" {{ request('sort') === 'incident_desc' ? 'selected' : '' }}>Sana bo'yicha</option>
                    </select>
                </div>

                {{-- Скрытые поля чтобы не терять другие фильтры --}}
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <span class="ms-auto text-muted small">
                    {{ $pets->count() }} ta hayvon topildi
                </span>
            </div>
        </form>

        {{-- Результаты --}}
        @if($pets->count() > 0)
            <div class="row g-4">
                @foreach($pets as $pet)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="position-relative overflow-hidden">
                                @if($pet->image)
                                    <img src="{{ asset('storage/' . $pet->image) }}"
                                        class="card-img-top" alt="{{ $pet->name }}"
                                        style="height:220px; object-fit:cover;">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center"
                                        style="background:linear-gradient(135deg,#667eea,#764ba2); height:220px;">
                                        <span class="display-3 text-white">🐾</span>
                                    </div>
                                @endif
                                {{-- Статус бейдж --}}
                                <span class="position-absolute top-0 end-0 m-2 badge
                                    {{ $pet->status === 'available' ? 'bg-success' : ($pet->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ $pet->status === 'available' ? '✅ Mavjud' : ($pet->status === 'pending' ? '⏳ Band' : '❌ Sotilgan') }}
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                {{-- Тип объявления --}}
                                <div class="mb-2">
                                    @if($pet->type === 'lost')
                                        <span class="badge" style="background:#f5576c;">😢 Yo'qoldi</span>
                                    @else
                                        <span class="badge" style="background:#43e97b; color:#1a1a2e;">🎉 Topildi</span>
                                    @endif
                                    <span class="badge bg-info bg-opacity-75 ms-1">
                                        @if($pet->category->slug === 'mushuklar') 🐱
                                        @elseif($pet->category->slug === 'itlar') 🐶
                                        @elseif($pet->category->slug === 'qushlar') 🐦
                                        @elseif($pet->category->slug === 'baliqlar') 🐟
                                        @else 🐾
                                        @endif
                                        {{ $pet->category->name }}
                                    </span>
                                </div>
                                <h5 class="card-title fw-bold mb-1">{{ $pet->name }}</h5>
                                @if($pet->location)
                                    <div class="text-muted small mb-2">📍 {{ $pet->location }}</div>
                                @endif
                                @if($pet->description)
                                    <p class="text-muted small mb-2" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                        {{ $pet->description }}
                                    </p>
                                @endif
                                @if($pet->incident_date)
                                    <div class="text-muted small mb-2">📅 {{ $pet->incident_date->format('d.m.Y') }}</div>
                                @endif
                                <div class="mt-auto d-grid">
                                    <a href="{{ route('pets.show', $pet) }}" class="btn btn-primary w-100"
                                        style="background-color:#6f79dc; border-color:#6f79dc;">
                                        📖 Batafsil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="display-1 mb-4">😔</div>
                <h3 class="mb-2">Hayvonlar topilmadi</h3>
                @if(request('search') || request('category') || request('status'))
                    <p class="text-muted mb-4">Boshqa so'z bilan qidirib ko'ring yoki filtrlarni olib tashlang.</p>
                    <a href="{{ route('pets.index') }}" class="btn btn-gradient px-4">Barchasini ko'rish</a>
                @endif
            </div>
        @endif

    </div>
</div>

<style>
    .card { transition: none !important; }
    .card:hover { transform: none !important; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important; }
    .card-img-top { transition: none !important; }
    .card:hover .card-img-top { transform: none !important; }
    .category-filter-card { padding: 10px 16px !important; }
</style>
@endsection
