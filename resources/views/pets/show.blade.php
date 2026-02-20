@extends('layouts.app')

@section('title', $pet->name . ' - PawZone')

@section('content')
    <div class="container my-5">
        <div class="glass-container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('pets.index') }}" class="text-decoration-none">Bosh
                            sahifa</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('pets.index') }}?category={{ $pet->category->slug }}"
                            class="text-decoration-none">{{ $pet->category->name }}</a></li>
                    <li class="breadcrumb-item active">{{ $pet->name }}</li>
                </ol>
            </nav>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <x-alert type="success" :msg="session('success')" />
            @endif

            @if(session('error'))
                <x-alert type="danger" :msg="session('error')" />
            @endif

            <div class="row g-5">
                <!-- Pet Image -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg">
                        @if($pet->image)
                            <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->name }}" class="img-fluid rounded">
                        @else
                            <div class="d-flex align-items-center justify-content-center rounded"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 500px;">
                                <span class="display-1 text-white">🐾</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pet Details -->
                <div class="col-lg-6">
                    <!-- Title & Category -->
                    <div class="mb-4">
                        <h1 class="display-4 fw-bold mb-3">{{ $pet->name }}</h1>
                        <span class="badge bg-info fs-5 px-4 py-2">
                            @if($pet->category->slug === 'mushuklar') 🐱
                            @elseif($pet->category->slug === 'itlar') 🐶
                            @elseif($pet->category->slug === 'qushlar') 🐦
                            @elseif($pet->category->slug === 'baliqlar') 🐟
                            @endif
                            {{ $pet->category->name }}
                        </span>
                    </div>


                    <!-- Price -->
                    <div class="mb-4">
                        <h2 class="price mb-0" style="font-size: 2.5rem;">
                            {{ number_format($pet->price, 0, ',', ' ') }} so'm
                        </h2>
                    </div>

                    <!-- Description -->
                    @if($pet->description)
                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">📝 Tavsif:</h4>
                            <p class="text-muted fs-5 lh-lg">{{ $pet->description }}</p>
                        </div>
                    @endif

                    <!-- Additional Info Card -->
                    <div class="card mb-4"
                        style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border: none;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">ℹ️ Qo'shimcha ma'lumotlar:</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong>📂 Kategoriya:</strong>
                                    <span class="badge bg-info ms-2">{{ $pet->category->name }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>📊 Holat:</strong>
                                    <span class="ms-2">
                                        @if($pet->status === 'available') ✅ Mavjud
                                        @elseif($pet->status === 'pending') ⏳ Band qilingan
                                        @else ❌ Sotilgan
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-2">
                                    <strong>📅 Qo'shilgan sana:</strong>
                                    <span class="ms-2">{{ $pet->created_at->format('d.m.Y') }}</span>
                                </li>
                                <li>
                                    <strong>🔖 ID:</strong>
                                    <span class="ms-2">#{{ $pet->id }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-3">
                        @if($pet->status === 'available')
                            <button type="button" class="btn btn-gradient-success btn-lg" data-bs-toggle="modal"
                                data-bs-target="#buyModal">
                                🛒 Sotib olish
                            </button>
                            <a href="#" class="btn btn-gradient btn-lg">
                                📞 Aloqa qilish
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg" disabled>
                                @if($pet->status === 'pending')
                                    ⏳ Bu hayvon band qilingan
                                @else
                                    ❌ Bu hayvon sotilgan
                                @endif
                            </button>
                        @endif

                        <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary btn-lg">
                            ← Orqaga qaytish
                        </a>
                    </div>
                </div>
            </div>

            <!-- Similar Pets Section -->
            @php
                $similarPets = \App\Models\Pet::where('category_id', $pet->category_id)
                    ->where('id', '!=', $pet->id)
                    ->where('status', 'available')
                    ->limit(4)
                    ->get();
            @endphp

            @if($similarPets->count() > 0)
                <hr class="my-5">

                <div class="mb-5">
                    <h2 class="display-6 fw-bold mb-4 text-center">O'xshash Hayvonlar</h2>
                    <p class="text-center text-muted mb-5">Sizga yoqishi mumkin bo'lgan boshqa hayvonlar</p>

                    <div class="row g-4">
                        @foreach($similarPets as $similarPet)
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100">
                                    <div class="position-relative overflow-hidden">
                                        @if($similarPet->image)
                                            <img src="{{ asset('storage/' . $similarPet->image) }}" class="card-img-top"
                                                alt="{{ $similarPet->name }}">
                                        @else
                                            <div class="card-img-top d-flex align-items-center justify-content-center"
                                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 200px;">
                                                <span class="display-4 text-white">🐾</span>
                                            </div>
                                        @endif
                                        <span class="badge badge-modern badge-available position-absolute top-0 end-0 m-3">
                                            ✅ Mavjud
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">{{ $similarPet->name }}</h5>
                                        <p class="price small mb-3">
                                            {{ number_format($similarPet->price, 0, ',', ' ') }} so'm
                                        </p>
                                        <a href="{{ route('pets.show', $similarPet->id) }}" class="btn btn-gradient w-100">
                                            Ko'rish →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Buy Modal -->
    <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <h5 class="modal-title text-white fw-bold" id="buyModalLabel">
                        🛒 {{ $pet->name }} ni sotib olish
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="{{ route('orders.store', $pet) }}" method="POST">
                    @csrf

                    <div class="modal-body p-4">
                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                            <div>
                                <strong>💰 Narx:</strong> {{ number_format($pet->price, 0, ',', ' ') }} so'm
                            </div>
                        </div>

                        <p class="text-muted mb-4">
                            Ma'lumotlaringizni qoldiring, biz tez orada siz bilan bog'lanamiz va buyurtmani tasdiqlаymiz.
                        </p>

                        <!-- Customer Name -->
                        <x-form-input name="customer_name" label="Ismingiz *" type="text" placeholder="Masalan: Alisher" />

                        <!-- Customer Phone -->
                        <x-form-input name="customer_phone" label="Telefon raqamingiz *" type="tel"
                            placeholder="+998 90 123 45 67" />

                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> Ma'lumotlaringiz maxfiy saqlanadi.
                        </small>
                    </div>

                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Bekor qilish
                        </button>
                        <button type="submit" class="btn btn-gradient-success px-5">
                            ✅ Buyurtma berish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection