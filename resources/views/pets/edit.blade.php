@extends('layouts.app')

@section('title', "E'lonni tahrirlash — PawZone")

@section('content')
<div class="container my-5">
    <div class="glass-container">
        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted small">← Dashboard</a>
            <h1 class="display-5 fw-bold mt-2 mb-1">✏️ E'lonni tahrirlash</h1>
            <p class="text-muted">{{ $pet->name }}</p>
        </div>

        <form action="{{ route('pets.update', $pet) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-semibold">E'lon turi *</label>
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type_lost"
                            value="lost" {{ old('type', $pet->type) === 'lost' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="type_lost">
                            😢 Hayvon yo'qoldi
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type_found"
                            value="found" {{ old('type', $pet->type) === 'found' ? 'checked' : '' }}>
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
                        <label class="form-label fw-semibold">Hayvon nomi *</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $pet->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategoriya *</label>
                        <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $pet->category_id) == $category->id ? 'selected' : '' }}>
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
                            value="{{ old('phone', $pet->phone) }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">✈️ Telegram username (ixtiyoriy)</label>
                        <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input type="text" name="telegram"
                                class="form-control @error('telegram') is-invalid @enderror"
                                value="{{ old('telegram', $pet->telegram) }}"
                                placeholder="username">
                        </div>
                        <div class="form-text">Masalan: username (@ belgisisiz kiriting)</div>
                        @error('telegram') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">📍 Joy</label>
                        <input type="text" name="location"
                            class="form-control @error('location') is-invalid @enderror"
                            value="{{ old('location', $pet->location) }}">
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">📅 Sana</label>
                        <input type="date" name="incident_date"
                            class="form-control @error('incident_date') is-invalid @enderror"
                            value="{{ old('incident_date', $pet->incident_date?->format('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}">
                        @error('incident_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Holat</label>
                        <select name="status"
                            class="form-select @error('status') is-invalid @enderror" required>
                            <option value="available" {{ old('status', $pet->status) === 'available' ? 'selected' : '' }}>
                                ✅ Faol
                            </option>
                            <option value="pending" {{ old('status', $pet->status) === 'pending' ? 'selected' : '' }}>
                                ⏳ Jarayonda
                            </option>
                            <option value="resolved" {{ old('status', $pet->status) === 'resolved' ? 'selected' : '' }}>
                                ✔️ Hal Qilindi (topildi / qaytarildi)
                            </option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">📝 Tavsif / xususiyatlar</label>
                        <textarea name="description" rows="6"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $pet->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    @if($pet->image)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Joriy rasm:</label>
                            <div>
                                <img src="{{ asset('storage/' . $pet->image) }}"
                                    alt="{{ $pet->name }}"
                                    style="max-width:180px; border-radius:8px; border:2px solid #e9ecef;">
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            🖼 {{ $pet->image ? 'Rasmni almashtirish' : 'Rasm yuklash' }}
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="form-control @error('image') is-invalid @enderror">
                        <div class="form-text">JPG, PNG, GIF — maksimal 2MB</div>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">
                    ← Bekor qilish
                </a>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gradient px-5 fw-semibold">
                        ✅ Saqlash
                    </button>
                </div>
            </div>
        </form>

        {{-- Удаление отдельной формой --}}
        <div class="mt-3 pt-3" style="border-top:1px solid #e9ecef;">
            <form action="{{ route('pets.destroy', $pet) }}" method="POST"
                onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    🗑 E'lonni o'chirish
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
