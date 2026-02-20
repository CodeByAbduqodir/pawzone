@extends('layouts.app')

@section('title', 'Hayvon qo\'shish - Admin')

@section('content')
    <div class="container my-5">
        <div class="glass-container">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="display-5 fw-bold mb-2">➕ Yangi hayvon qo'shish</h1>
                <p class="text-muted">Barcha maydonlarni to'ldiring</p>
            </div>

            <!-- Form -->
            <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <!-- Name -->
                        <x-form-input 
                            name="name" 
                            label="Hayvon nomi *" 
                            type="text" 
                        />

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategoriya *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id"
                                    required>
                                <option value="" disabled selected>-- Kategoriyani tanlang --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                      rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image -->
                        <x-form-input 
                            name="image" 
                            label="Rasm yuklash" 
                            type="file" 
                        />
                        <small class="text-muted">Ruxsat etilgan formatlar: JPG, PNG, GIF. Maksimal hajmi: 2MB</small>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
                        ← Bekor qilish
                    </a>
                    <button type="submit" class="btn btn-gradient-success px-5">
                        ✅ Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
