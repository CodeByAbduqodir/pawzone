@extends('layouts.app')

@section('title', "Yangi e'lon — PawZone")

@section('content')
<div class="container-xl">
    <div class="hero-surface mb-4">
        <span class="hero-kicker">Yangi e'lon</span>
        <h1 class="hero-title">Hayvon haqida e'lon joylash</h1>
        <p class="hero-subtitle mb-0">
            Qisqa, aniq va foydalanuvchiga tushunarli forma. Ma'lumotlar keyinroq osongina tahrirlanadi.
        </p>
    </div>

    <div class="section-card">
        <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">E'lon turi *</label>
                        <div class="d-flex flex-wrap gap-3">
                            <label class="chip">
                                <input type="radio" name="type" value="lost" class="form-check-input me-2" {{ old('type', 'lost') === 'lost' ? 'checked' : '' }}>
                                Hayvon yo'qoldi
                            </label>
                            <label class="chip">
                                <input type="radio" name="type" value="found" class="form-check-input me-2" {{ old('type') === 'found' ? 'checked' : '' }}>
                                Hayvon topildi
                            </label>
                        </div>
                        @error('type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-input name="name" label="Hayvon nomi" value="{{ old('name') }}" />

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategoriya *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">— Kategoriyani tanlang —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-input name="phone" label="Aloqa telefoni" type="tel" value="{{ old('phone') }}" />

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Telegram username</label>
                        <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input type="text" name="telegram" class="form-control @error('telegram') is-invalid @enderror" value="{{ old('telegram', auth()->user()->telegram ? ltrim(auth()->user()->telegram, '@') : '') }}" placeholder="username">
                        </div>
                        <div class="form-text">Username ni @ belgisiz yozing.</div>
                        @error('telegram')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-input name="location" label="Joylashuv" value="{{ old('location') }}" />

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sana</label>
                        <input type="date" name="incident_date" class="form-control @error('incident_date') is-invalid @enderror" value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}">
                        @error('incident_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tavsif</label>
                        <textarea name="description" rows="10" class="form-control @error('description') is-invalid @enderror" placeholder="Rang, belgi, qayerda yo'qoldi yoki topildi...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="support-note mb-3">
                        <div class="fw-semibold mb-1">Rasm qo'shish</div>
                        <div class="small text-muted mb-3">JPG, PNG yoki GIF. Maksimal 2MB.</div>
                        <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">Bekor qilish</a>
                <button type="submit" class="btn btn-gradient-success px-5">E'lonni joylash</button>
            </div>
        </form>
    </div>
</div>
@endsection
