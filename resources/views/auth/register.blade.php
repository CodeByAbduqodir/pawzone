@extends('layouts.app')

@section('title', "Ro'yxatdan o'tish — PawZone")

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="glass-container mt-5">
                <h2 class="text-center mb-1" style="font-family:'Poppins',sans-serif; font-weight:700;">
                    🐾 Ro'yxatdan o'tish
                </h2>
                <p class="text-center text-muted mb-4">Yangi hisob yarating</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ism</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            placeholder="Ismingiz"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                            placeholder="email@example.com"
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rol</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">— Rolni tanlang —</option>
                            <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }}>
                                🏠 Hayvon egasi (yo'qolgan hayvon e'lon qilish)
                            </option>
                            <option value="finder" {{ old('role') === 'finder' ? 'selected' : '' }}>
                                🔍 Topuvchi (hayvon topdim deb e'lon qilish)
                            </option>
                        </select>
                        @error('role')
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
                            placeholder="Kamida 8 ta belgi"
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Parolni tasdiqlang</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required
                            placeholder="Parolni qaytaring"
                        >
                    </div>

                    <button type="submit" class="btn btn-gradient w-100 py-2 fw-semibold">
                        Ro'yxatdan o'tish →
                    </button>
                </form>

                <hr class="my-4">

                <p class="text-center mb-0">
                    Hisobingiz bormi?
                    <a href="{{ route('login') }}" class="fw-semibold" style="color:#667eea;">
                        Kirish
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
