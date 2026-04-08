@extends('layouts.app')

@section('title', 'PawZone — Do\'kon')

@section('content')
<div class="container-xl">
    <div class="hero-surface">
        <div class="hero-grid">
            <div>
                <span class="hero-kicker">Do'kon</span>
                <h1 class="hero-title">Katalogning yangi ko'rinishi</h1>
                <p class="hero-subtitle">
                    Eski do'kon sahifasi endi yagona katalog oqimiga moslashtirildi. Zamonaviy, sodda va funksional.
                </p>
                <div class="hero-badges">
                    <span class="chip chip-soft">Filtrlar</span>
                    <span class="chip chip-success">Qidiruv</span>
                    <span class="chip">Listinglar</span>
                </div>
            </div>

            <div class="hero-panel">
                <h5 class="mb-2">Katalogga o'tish</h5>
                <p class="text-muted small mb-3">Barcha mavjud e'lonlar va filtrlar `pets.index` sahifasida.</p>
                <a href="{{ route('pets.index') }}" class="btn btn-gradient w-100">E'lonlarga o'tish</a>
            </div>
        </div>
    </div>
</div>
@endsection
