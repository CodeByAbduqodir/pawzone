@extends('layouts.app')

@section('title', 'PawZone — Bosh sahifa')

@section('content')
<div class="container-xl">
    <div class="hero-surface">
        <div class="hero-grid">
            <div>
                <span class="hero-kicker">Bosh sahifa</span>
                <h1 class="hero-title">PawZone'ga xush kelibsiz</h1>
                <p class="hero-subtitle">
                    Ushbu loyiha endi yo'qolgan va topilgan hayvonlar uchun birlashtirilgan katalog sifatida ishlaydi.
                    Asosiy ish oqimi <strong>E'lonlar</strong> sahifasida.
                </p>
                <div class="hero-badges">
                    <span class="chip chip-soft">Katalog</span>
                    <span class="chip chip-success">Dashboard</span>
                    <span class="chip">Admin panel</span>
                </div>
            </div>
            <div class="hero-panel">
                <h5 class="mb-2">Keyingi qadamlar</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('pets.index') }}" class="btn btn-gradient">E'lonlarni ko'rish</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Kirish</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
