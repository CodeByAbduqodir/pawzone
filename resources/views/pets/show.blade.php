@extends('layouts.app')

@section('title', $pet->name . ' — PawZone')

@section('content')
<div class="container-xl">
    <div class="hero-surface mb-4">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('pets.index') }}" class="text-decoration-none">E'lonlar</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('pets.index', ['category' => $pet->category->slug]) }}" class="text-decoration-none">
                        {{ $pet->category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ $pet->name }}</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <span class="hero-kicker">Tafsilot</span>
                <h1 class="hero-title">{{ $pet->name }}</h1>
                <p class="hero-subtitle mb-0">
                    E'lon ma'lumotlari, aloqa va shunga o'xshash e'lonlar bir joyda.
                </p>
            </div>

            <div class="d-flex flex-column align-items-start gap-2">
                <span class="badge rounded-pill text-bg-light border px-3 py-2">
                    {{ $pet->typeLabel() }}
                </span>
                <span class="badge rounded-pill {{ $pet->statusBadgeClass() }} px-3 py-2">
                    {{ $pet->statusLabel() }}
                </span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success" :msg="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="danger" :msg="session('error')" />
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="section-card h-100">
                @if($pet->image_url)
                    <img src="{{ $pet->image_url }}" alt="{{ $pet->name }}" class="img-fluid w-100" style="border-radius: 18px; object-fit: cover; max-height: 460px;">
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 420px; border-radius: 18px; background: linear-gradient(135deg, rgba(59,130,246,.90), rgba(16,185,129,.85));">
                        <span class="display-3 text-white">🐾</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-7">
            <div class="section-card mb-4">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge rounded-pill text-bg-light border">{{ $pet->category->name }}</span>
                    @if($pet->location)
                        <span class="badge rounded-pill text-bg-light border">📍 {{ $pet->location }}</span>
                    @endif
                    @if($pet->incident_date)
                        <span class="badge rounded-pill text-bg-light border">📅 {{ $pet->incident_date->format('d.m.Y') }}</span>
                    @endif
                </div>

                @if($pet->description)
                    <p class="lead text-muted mb-4">{{ $pet->description }}</p>
                @endif

                <div class="meta-grid mb-4">
                    <div class="meta-item">
                        <div class="small text-muted mb-1">E'lon sanasi</div>
                        <div class="fw-semibold">{{ $pet->created_at->format('d.m.Y') }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="small text-muted mb-1">Holat</div>
                        <div class="fw-semibold">{{ $pet->statusLabel() }}</div>
                    </div>
                </div>

                @if($pet->status !== 'resolved')
                    <div class="support-note mb-4">
                        <div class="fw-semibold mb-2">Muallif bilan bog'lanish</div>
                        <a href="tel:{{ $pet->phone }}" class="btn btn-gradient w-100 mb-2">
                            {{ $pet->phone }}
                        </a>
                        @if($pet->telegram)
                            <a href="https://t.me/{{ ltrim($pet->telegram, '@') }}" class="btn btn-outline-secondary w-100" target="_blank" rel="noopener noreferrer">
                                Telegram: &#64;{{ ltrim($pet->telegram, '@') }}
                            </a>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info mb-4">
                        Bu e'lon yopiq. Hayvon topilgan yoki qaytarilgan.
                    </div>
                @endif

                @auth
                    @if(auth()->user()->isAdmin() || $pet->user_id === auth()->id())
                        <div class="page-actions">
                            <a href="{{ route('pets.edit', $pet) }}" class="btn btn-outline-primary">Tahrirlash</a>
                        </div>
                    @endif
                @endauth
            </div>

            <div class="section-card">
                <h4 class="mb-3">O'xshash e'lonlar</h4>

                @php
                    $similar = \App\Models\Pet::with('category')
                        ->where('category_id', $pet->category_id)
                        ->where('id', '!=', $pet->id)
                        ->where('status', 'available')
                        ->latest()
                        ->limit(4)
                        ->get();
                @endphp

                @if($similar->count() > 0)
                    <div class="row g-3">
                        @foreach($similar as $s)
                            <div class="col-md-6">
                                <div class="card h-100">
                                    @if($s->image_url)
                                        <img src="{{ $s->image_url }}" class="card-img-top" alt="{{ $s->name }}" style="height: 160px;">
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 160px; background: linear-gradient(135deg, rgba(59,130,246,.90), rgba(124,58,237,.90));">
                                            <span class="fs-1 text-white">🐾</span>
                                        </div>
                                    @endif

                                    <div class="card-body">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge rounded-pill text-bg-light border">{{ $s->typeLabel() }}</span>
                                            <span class="badge rounded-pill text-bg-light border">{{ $s->category->name }}</span>
                                        </div>
                                        <h6 class="mb-2">{{ $s->name }}</h6>
                                        @if($s->location)
                                            <div class="text-muted small mb-3">📍 {{ $s->location }}</div>
                                        @endif
                                        <a href="{{ route('pets.show', $s) }}" class="btn btn-gradient btn-sm w-100">Ko'rish</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state py-4">
                        <div class="emoji">🐾</div>
                        <p class="mb-0">Hozircha o'xshash e'lonlar yo'q.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
