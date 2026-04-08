@extends('layouts.app')

@section('title', "Ro'yxatdan o'tish — PawZone")

@section('content')
<div class="container-xl">
    <div class="hero-surface">
        <div class="hero-grid">
            <div>
                <span class="hero-kicker">Ro'yxat</span>
                <h1 class="hero-title">Yangi akkaunt yarating</h1>
                <p class="hero-subtitle">
                    Owner yoki finder sifatida kirib, yo'qolgan va topilgan hayvonlar bo'yicha e'lonlarni tez boshqaring.
                </p>

                <div class="hero-badges">
                    <span class="chip chip-soft">Owner</span>
                    <span class="chip chip-success">Finder</span>
                    <span class="chip">Shaxsiy kabinet</span>
                </div>
            </div>

            <div class="auth-card">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <x-form-input name="name" label="Ism" value="{{ old('name') }}" />
                    <x-form-input name="email" label="Email" type="email" value="{{ old('email') }}" />

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rol</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">— Rolni tanlang —</option>
                            <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }}>
                                Hayvon egasi
                            </option>
                            <option value="finder" {{ old('role') === 'finder' ? 'selected' : '' }}>
                                Topuvchi
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parol</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Kamida 8 ta belgi" required>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Parolni tasdiqlang</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Parolni qaytaring" required>
                    </div>

                    <button type="submit" class="btn btn-gradient-success w-100 py-2">Ro'yxatdan o'tish</button>
                </form>

                <div class="support-note mt-4">
                    <div class="fw-semibold mb-1">Allaqachon hisobingiz bormi?</div>
                    <div class="small text-muted mb-3">Kirish orqali mavjud e'lonlaringiz va buyurtmalaringizga o'ting.</div>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">Kirish</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
