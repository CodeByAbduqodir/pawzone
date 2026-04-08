@extends('layouts.app')

@section('title', 'Kirish — PawZone')

@section('content')
<div class="container-xl">
    <div class="hero-surface">
        <div class="hero-grid">
            <div>
                <span class="hero-kicker">Kirish</span>
                <h1 class="hero-title">Hisobingizga xavfsiz kirish</h1>
                <p class="hero-subtitle">
                    E'lonlaringizni boshqaring, buyurtmalarni kuzating va foydalanuvchi kabinetidan tez foydalaning.
                </p>

                <div class="hero-badges">
                    <span class="chip chip-soft">Tezkor kirish</span>
                    <span class="chip chip-success">Kabinet</span>
                    <span class="chip">Admin nazorati</span>
                </div>
            </div>

            <div class="auth-card">
                @if(session('error'))
                    <x-alert type="danger" :msg="session('error')" />
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <x-form-input name="email" label="Email" type="email" value="{{ old('email') }}" />

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parol</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Meni eslab qol</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gradient w-100 py-2">Kirish</button>
                </form>

                <div class="support-note mt-4">
                    <div class="fw-semibold mb-1">Hisobingiz yo'qmi?</div>
                    <div class="small text-muted mb-3">Bir necha qadamda ro'yxatdan o'tib, e'lon joylashingiz mumkin.</div>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100">Ro'yxatdan o'tish</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
