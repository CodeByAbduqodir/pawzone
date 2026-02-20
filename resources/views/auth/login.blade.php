@extends('layouts.app')

@section('title', 'Kirish — PawZone')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="glass-container mt-5">
                <h2 class="text-center mb-1" style="font-family:'Poppins',sans-serif; font-weight:700;">
                    🐾 Kirish
                </h2>
                <p class="text-center text-muted mb-4">Hisobingizga kiring</p>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="email@example.com"
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parol</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            placeholder="••••••••"
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Meni eslab qol</label>
                    </div>

                    <button type="submit" class="btn btn-gradient w-100 py-2 fw-semibold">
                        Kirish →
                    </button>
                </form>

                <hr class="my-4">

                <p class="text-center mb-0">
                    Hisobingiz yo'qmi?
                    <a href="{{ route('register') }}" class="fw-semibold" style="color:#667eea;">
                        Ro'yxatdan o'ting
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
