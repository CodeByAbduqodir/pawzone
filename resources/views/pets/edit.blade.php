@extends('layouts.app')

@section('title', "E'lonni tahrirlash — PawZone")

@section('content')
<div class="container-xl">
    <div class="hero-surface mb-4">
        <span class="hero-kicker">Tahrirlash</span>
        <h1 class="hero-title">{{ $pet->name }}</h1>
        <p class="hero-subtitle mb-0">
            E'lon ma'lumotlarini yangilang, holatni o'zgartiring yoki rasmni almashtiring.
        </p>
    </div>

    <div class="section-card">
        <form action="{{ route('pets.update', $pet) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">E'lon turi *</label>
                        <div class="d-flex flex-wrap gap-3">
                            <label class="chip">
                                <input type="radio" name="type" value="lost" class="form-check-input me-2" {{ old('type', $pet->type) === 'lost' ? 'checked' : '' }}>
                                Hayvon yo'qoldi
                            </label>
                            <label class="chip">
                                <input type="radio" name="type" value="found" class="form-check-input me-2" {{ old('type', $pet->type) === 'found' ? 'checked' : '' }}>
                                Hayvon topildi
                            </label>
                        </div>
                        @error('type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-input name="name" label="Hayvon nomi" value="{{ old('name', $pet->name) }}" />

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategoriya *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $pet->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-input name="phone" label="Aloqa telefoni" type="tel" value="{{ old('phone', $pet->phone) }}" />

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Telegram username</label>
                        <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input type="text" name="telegram" class="form-control @error('telegram') is-invalid @enderror" value="{{ old('telegram', $pet->telegram) }}" placeholder="username">
                        </div>
                        @error('telegram')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-input name="location" label="Joylashuv" value="{{ old('location', $pet->location) }}" />

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sana</label>
                        <input type="date" name="incident_date" class="form-control @error('incident_date') is-invalid @enderror" value="{{ old('incident_date', $pet->incident_date?->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}">
                        @error('incident_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Holat *</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="available" {{ old('status', $pet->status) === 'available' ? 'selected' : '' }}>Faol</option>
                            <option value="pending" {{ old('status', $pet->status) === 'pending' ? 'selected' : '' }}>Jarayonda</option>
                            <option value="resolved" {{ old('status', $pet->status) === 'resolved' ? 'selected' : '' }}>Hal qilingan</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tavsif</label>
                        <textarea name="description" rows="10" class="form-control @error('description') is-invalid @enderror">{{ old('description', $pet->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($pet->image)
                        <div class="support-note mb-3">
                            <div class="fw-semibold mb-2">Joriy rasm</div>
                            <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->name }}" class="img-fluid" style="max-width: 220px; border-radius: 18px;">
                        </div>
                    @endif

                    <div class="support-note mb-3">
                        <div class="fw-semibold mb-1">{{ $pet->image ? 'Rasmni almashtirish' : 'Rasm yuklash' }}</div>
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
                <div class="d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-gradient px-5">Saqlash</button>
                </div>
            </div>
        </form>

        <div class="support-note mt-4">
            <form action="{{ route('pets.destroy', $pet) }}" method="POST" onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                @csrf
                @method('DELETE')
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="fw-semibold">E'lonni o'chirish</div>
                        <div class="small text-muted">Bu amal qaytarilmaydi.</div>
                    </div>
                    <button type="submit" class="btn btn-outline-danger">O'chirish</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
