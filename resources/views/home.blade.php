@extends('layouts.app')

@section('title', 'PawZone - Uy hayvonlari do\'koni')

@section('content')
    <div class="container my-5">
        <div class="glass-container">
            <!-- Header with Admin Button -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h1 class="display-4 fw-bold mb-2">🐾 PawZone</h1>
                    <p class="lead text-muted">Uy hayvonlari do'koniga xush kelibsiz!</p>
                </div>
                <div>
                    <a href="{{ route('pets.index') }}" class="btn btn-gradient">
                        🔧 Adminка
                    </a>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="mb-5">
                <h3 class="mb-4 fw-bold text-center">🎯 Kategoriya tanlang</h3>
                <div class="row g-3">
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <div class="category-filter-card {{ !request('category') ? 'active' : '' }}">
                                <div class="category-icon">📦</div>
                                <div class="category-name">Barchasi</div>
                            </div>
                        </a>
                    </div>

                    @foreach($categories as $category)
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('home') }}?category={{ $category->slug }}" class="text-decoration-none">
                                <div class="category-filter-card {{ request('category') === $category->slug ? 'active' : '' }}">
                                    <div class="category-icon">
                                        @if($category->slug === 'mushuklar') 🐱
                                        @elseif($category->slug === 'itlar') 🐶
                                        @elseif($category->slug === 'qushlar') 🐦
                                        @elseif($category->slug === 'baliqlar') 🐟
                                        @endif
                                    </div>
                                    <div class="category-name">{{ $category->name }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="my-5">

            <!-- Pets Grid -->
            @php
                $filteredPets = request('category')
                    ? $pets->filter(function ($pet) {
                        return $pet->category->slug === request('category');
                    })
                    : $pets;
            @endphp

            @if($filteredPets->count() > 0)
                <h2 class="mb-4 fw-bold">Mavjud hayvonlar:</h2>
                <div class="row g-4">
                    @foreach($filteredPets as $pet)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100">
                                <!-- Pet Image -->
                                <div class="position-relative overflow-hidden">
                                    @if($pet->image)
                                        <img src="{{ asset('storage/' . $pet->image) }}" class="card-img-top" alt="{{ $pet->name }}">
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 250px;">
                                            <span class="display-3 text-white">🐾</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold mb-2">{{ $pet->name }}</h5>

                                    <div class="mb-3">
                                        <span class="badge bg-info">
                                            @if($pet->category->slug === 'mushuklar') 🐱
                                            @elseif($pet->category->slug === 'itlar') 🐶
                                            @elseif($pet->category->slug === 'qushlar') 🐦
                                            @elseif($pet->category->slug === 'baliqlar') 🐟
                                            @endif
                                            {{ $pet->category->name }}
                                        </span>
                                    </div>

                                    <div class="price mb-3">
                                        {{ number_format($pet->price, 0, ',', ' ') }} so'm
                                    </div>

                                    <a href="{{ route('pet.show', $pet->id) }}" class="btn btn-gradient w-100 mt-auto">
                                        Batafsil →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="display-1 mb-4">😔</div>
                    <h3 class="mb-3">Hayvonlar topilmadi</h3>
                    <a href="{{ route('home') }}" class="btn btn-gradient">Barchasini ko'rish</a>
                </div>
            @endif
        </div>
    </div>
@endsection