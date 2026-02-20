@extends('layouts.app')

@section('title', 'Hayvonni tahrirlash - Admin')

@section('content')
    <div class="container my-5">
        <div class="glass-container">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="display-5 fw-bold mb-2">✏️ Hayvonni tahrirlash</h1>
                <p class="text-muted">{{ $pet->name }} ma'lumotlarini yangilash</p>
            </div>

            <!-- Form -->
            <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <!-- Name -->
                        <x-form-input 
                            name="name" 
                            label="Hayvon nomi *" 
                            type="text"
                            :value="$pet->name"
                        />

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategoriya *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id"
                                    required>
                                <option value="" disabled>-- Kategoriyani tanlang --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ (old('category_id', $pet->category_id) == $category->id) ? 'selected' : '' }}>
                                        @if($category->slug === 'mushuklar') 🐱
                                        @elseif($category->slug === 'itlar') 🐶
                                        @elseif($category->slug === 'qushlar') 🐦
                                        @elseif($category->slug === 'baliqlar') 🐟
                                        @endif
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price -->
                        <x-form-input 
                            name="price" 
                            label="Narxi (so'm) *" 
                            type="number"
                            :value="$pet->price"
                        />

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Holat *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status"
                                    required>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Tavsif</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5">{{ old('description', $pet->description) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($pet->image)
                            <div class="mb-3">
                                <label class="form-label">Joriy rasm:</label>
                                <div>
                                    <img src="{{ asset('storage/' . $pet->image) }}" 
                                         alt="{{ $pet->name }}" 
                                         class="img-thumbnail"
                                         style="max-width: 200px;">
                                </div>
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <x-form-input 
                            name="image" 
                            label="Yangi rasm yuklash" 
                            type="file" 
                        />
                        <small class="text-muted">Ruxsat etilgan formatlar: JPG, PNG, GIF. Maksimal hajmi: 2MB</small>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
                            ← Orqaga
                        </a>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <!-- Delete Button -->
                        <form action="{{ route('pets.destroy', $pet) }}" method="POST" 
                              onsubmit="return confirm('⚠️ Haqiqatdan ham bu hayvonni o\'chirmoqchimisiz? Bu amalni qaytarib bo\'lmaydi!');" 
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                🗑️ O'chirish
                            </button>
                        </form>

                        <!-- Update Button -->
                        <button type="submit" class="btn btn-gradient-success px-5">
                            ✅ Yangilash
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
