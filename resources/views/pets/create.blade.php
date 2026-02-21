@extends('layouts.app')

@section('title', "E'lon joylash — PawZone")

@section('content')
<div class="container my-5">
    <div class="glass-container">
        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted small">← Dashboard</a>
            <h1 class="display-5 fw-bold mt-2 mb-1">📢 Yangi e'lon joylash</h1>
            <p class="text-muted">Hayvon haqida ma'lumot kiriting</p>
        </div>

        <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Тип объявления --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">E'lon turi *</label>
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type_lost"
                            value="lost" {{ old('type', 'lost') === 'lost' ? 'checked' : '' }} required>
                        <label class="form-check-label fw-semibold" for="type_lost">
                            😢 Hayvon yo'qoldi
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type_found"
                            value="found" {{ old('type') === 'found' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="type_found">
                            🎉 Hayvon topildi
                        </label>
                    </div>
                </div>
                @error('type')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-4">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hayvon nomi / tavsiflovchi nom *</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Masalan: Bars, Qo'ng'ir mushuk"
                            required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Turi (hayvon kategoriyasi) *</label>
                        <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">— Kategoriyani tanlang —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    @if($category->slug === 'mushuklar') 🐱
                                    @elseif($category->slug === 'itlar') 🐶
                                    @elseif($category->slug === 'qushlar') 🐦
                                    @elseif($category->slug === 'baliqlar') 🐟
                                    @else 🐾
                                    @endif
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">📞 Aloqa telefoni *</label>
                        <input type="tel" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}"
                            placeholder="+998 90 123 45 67"
                            required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">📍 Yo'qolgan / topilgan joy</label>
                        <input type="text" name="location"
                            class="form-control @error('location') is-invalid @enderror"
                            value="{{ old('location') }}"
                            placeholder="Masalan: Toshkent, Chilonzor tumani">
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">📅 Sana</label>
                        <input type="date" name="incident_date"
                            class="form-control @error('incident_date') is-invalid @enderror"
                            value="{{ old('incident_date') }}"
                            max="{{ date('Y-m-d') }}">
                        @error('incident_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">📝 Tavsif / xususiyatlar</label>
                        <textarea name="description" rows="6"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Hayvonning rangi, belgilari, maxsus xususiyatlari...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">🖼 Rasm (ixtiyoriy)</label>
                        <input type="file" name="image" accept="image/*"
                            class="form-control @error('image') is-invalid @enderror">
                        <div class="form-text">JPG, PNG, GIF — maksimal 2MB</div>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">
                    ← Bekor qilish
                </a>
                <button type="submit" class="btn btn-gradient px-5 fw-semibold">
                    📢 E'lonni joylash
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
