@extends('layouts.app')

@section('title', $pet->name . ' — PawZone')

@section('content')
<div class="container my-5">
    <div class="glass-container">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('pets.index') }}" class="text-decoration-none">Bosh sahifa</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('pets.index', ['category' => $pet->category->slug]) }}" class="text-decoration-none">
                        {{ $pet->category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ $pet->name }}</li>
            </ol>
        </nav>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Тип объявления --}}
        <div class="mb-3">
            @if($pet->type === 'lost')
                <span class="badge fs-6 px-3 py-2" style="background:linear-gradient(135deg,#f093fb,#f5576c); color:white;">
                    😢 Hayvon yo'qoldi
                </span>
            @else
                <span class="badge fs-6 px-3 py-2" style="background:linear-gradient(135deg,#43e97b,#38f9d7); color:white;">
                    🎉 Hayvon topildi
                </span>
            @endif
            @if($pet->status === 'resolved')
                <span class="badge bg-secondary fs-6 px-3 py-2 ms-2">✔️ Hal Qilindi</span>
            @endif
        </div>

        <div class="row g-5">
            {{-- Фото --}}
            <div class="col-lg-5">
                @if($pet->image)
                    <img src="{{ asset('storage/' . $pet->image) }}"
                        alt="{{ $pet->name }}"
                        class="img-fluid w-100"
                        style="border-radius:12px; object-fit:cover; max-height:420px;">
                @else
                    <div class="d-flex align-items-center justify-content-center"
                        style="background:linear-gradient(135deg,#667eea,#764ba2); height:360px; border-radius:12px;">
                        <span style="font-size:6rem;">🐾</span>
                    </div>
                @endif
            </div>

            {{-- Детали --}}
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold mb-2">{{ $pet->name }}</h1>

                <div class="mb-3">
                    <span class="badge bg-info bg-opacity-75 me-2">
                        @if($pet->category->slug === 'mushuklar') 🐱
                        @elseif($pet->category->slug === 'itlar') 🐶
                        @elseif($pet->category->slug === 'qushlar') 🐦
                        @elseif($pet->category->slug === 'baliqlar') 🐟
                        @else 🐾
                        @endif
                        {{ $pet->category->name }}
                    </span>
                </div>

                @if($pet->description)
                    <p class="text-muted fs-5 lh-lg mb-4">{{ $pet->description }}</p>
                @endif

                {{-- Информационный блок --}}
                <div class="p-3 mb-4" style="background:#f8f9fa; border-radius:10px; border-left:4px solid #667eea;">
                    <div class="row g-2">
                        @if($pet->location)
                            <div class="col-sm-6">
                                <div class="text-muted small">📍 Joy</div>
                                <div class="fw-semibold">{{ $pet->location }}</div>
                            </div>
                        @endif
                        @if($pet->incident_date)
                            <div class="col-sm-6">
                                <div class="text-muted small">📅 Sana</div>
                                <div class="fw-semibold">{{ $pet->incident_date->format('d.m.Y') }}</div>
                            </div>
                        @endif
                        <div class="col-sm-6">
                            <div class="text-muted small">📂 Kategoriya</div>
                            <div class="fw-semibold">{{ $pet->category->name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">🗓 E'lon sanasi</div>
                            <div class="fw-semibold">{{ $pet->created_at->format('d.m.Y') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Блок контакта --}}
                @if($pet->status !== 'resolved')
                    <div class="p-4 mb-4" style="background:linear-gradient(135deg,#667eea11,#764ba211); border-radius:12px; border:1px solid #667eea33;">
                        <h5 class="fw-bold mb-3">📞 Muallif bilan bog'lanish</h5>
                        <a href="tel:{{ $pet->phone }}"
                            class="btn btn-gradient btn-lg fw-semibold w-100 mb-2">
                            📞 {{ $pet->phone }}
                        </a>
                        @if($pet->telegram)
                        <a href="https://t.me/{{ ltrim($pet->telegram, '@') }}"
                            class="btn btn-outline-secondary w-100" target="_blank">
                            ✈️ Telegram: @{{ ltrim($pet->telegram, '@') }}
                        </a>
                        @endif
                    </div>
                @else
                    <div class="alert alert-secondary">
                        ✔️ Bu e'lon yopilgan — hayvon topildi yoki qaytarildi.
                    </div>
                @endif

                {{-- Кнопки владельца/admin --}}
                @auth
                    @if(auth()->user()->isAdmin() || $pet->user_id === auth()->id())
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('pets.edit', $pet) }}" class="btn btn-outline-primary">
                                ✏️ Tahrirlash
                            </a>
                        </div>
                    @endif
                @endauth

                <div class="mt-3">
                    <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
                        ← Orqaga
                    </a>
                </div>
            </div>
        </div>

        {{-- Похожие объявления --}}
        @php
            $similar = \App\Models\Pet::where('category_id', $pet->category_id)
                ->where('id', '!=', $pet->id)
                ->where('status', 'available')
                ->limit(4)->get();
        @endphp

        @if($similar->count() > 0)
            <hr class="my-5">
            <h4 class="fw-bold mb-4">O'xshash e'lonlar</h4>
            <div class="row g-3">
                @foreach($similar as $s)
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            @if($s->image)
                                <img src="{{ asset('storage/' . $s->image) }}"
                                    class="card-img-top" alt="{{ $s->name }}"
                                    style="height:160px; object-fit:cover;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center"
                                    style="height:160px; background:linear-gradient(135deg,#667eea,#764ba2);">
                                    <span class="fs-1">🐾</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="mb-1">
                                    @if($s->type === 'lost')
                                        <span class="badge" style="background:#f5576c; font-size:0.7rem;">😢 Yo'qoldi</span>
                                    @else
                                        <span class="badge" style="background:#43e97b; font-size:0.7rem;">🎉 Topildi</span>
                                    @endif
                                </div>
                                <h6 class="fw-bold mb-1">{{ $s->name }}</h6>
                                @if($s->location)
                                    <div class="text-muted small mb-2">📍 {{ $s->location }}</div>
                                @endif
                                <a href="{{ route('pets.show', $s) }}" class="btn btn-gradient btn-sm w-100">
                                    Ko'rish →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

<style>
    .card { transition: none !important; }
    .card:hover { transform: none !important; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important; }
</style>
@endsection
