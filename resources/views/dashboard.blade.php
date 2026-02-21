@extends('layouts.app')

@section('title', 'Dashboard — PawZone')

@section('content')
<div class="container my-5">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="glass-container mb-4 py-4 px-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h2 class="mb-1 fw-bold">
                👋 Xush kelibsiz, {{ auth()->user()->name }}!
            </h2>
            <span class="text-muted">
                @if(auth()->user()->isAdmin())
                    🛡 Admin panel
                @elseif(auth()->user()->isOwner())
                    🏠 Hayvon egasi
                @else
                    🔍 Topuvchi
                @endif
            </span>
        </div>
        <a href="{{ route('pets.create') }}" class="btn btn-gradient px-4 py-2 fw-semibold">
            ➕ Yangi e'lon joylash
        </a>
    </div>

    {{-- Статистика --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="glass-container py-3 px-4 text-center mb-0">
                <div class="fs-1 fw-bold" style="color:#667eea;">{{ $stats['total_pets'] }}</div>
                <div class="text-muted small">Jami hayvonlar</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="glass-container py-3 px-4 text-center mb-0">
                <div class="fs-1 fw-bold text-success">{{ $stats['available'] }}</div>
                <div class="text-muted small">Mavjud</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="glass-container py-3 px-4 text-center mb-0">
                <div class="fs-1 fw-bold text-warning">{{ $stats['pending'] }}</div>
                <div class="text-muted small">Band qilingan</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="glass-container py-3 px-4 text-center mb-0">
                <div class="fs-1 fw-bold text-danger">{{ $stats['total_orders'] }}</div>
                <div class="text-muted small">Buyurtmalar</div>
            </div>
        </div>
    </div>

    {{-- Мои питомцы --}}
    <div class="glass-container mb-4">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <h4 class="fw-bold mb-0">
                🐾 {{ auth()->user()->isAdmin() ? 'Barcha hayvonlar' : 'Mening hayvonlarim' }}
            </h4>
            <a href="{{ route('pets.create') }}" class="btn btn-sm btn-gradient px-3">➕ Qo'shish</a>
        </div>

        @if($pets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #667eea22, #764ba222);">
                        <tr>
                            <th>#</th>
                            <th>Rasm</th>
                            <th>Nomi</th>
                            <th>Kategoriya</th>
                            <th>Narx</th>
                            <th>Holat</th>
                            @if(auth()->user()->isAdmin())
                                <th>Egasi</th>
                            @endif
                            <th>Sana</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pets as $pet)
                            <tr>
                                <td class="text-muted small">#{{ $pet->id }}</td>
                                <td>
                                    @if($pet->image)
                                        <img src="{{ asset('storage/' . $pet->image) }}"
                                            style="width:48px; height:48px; object-fit:cover; border-radius:8px;">
                                    @else
                                        <div style="width:48px; height:48px; border-radius:8px; background:linear-gradient(135deg,#667eea,#764ba2); display:flex; align-items:center; justify-content:center;">
                                            <span>🐾</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-semibold">
                                    <a href="{{ route('pets.show', $pet) }}" class="text-decoration-none" style="color:#667eea;">
                                        {{ $pet->name }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-75">
                                        @if($pet->category->slug === 'mushuklar') 🐱
                                        @elseif($pet->category->slug === 'itlar') 🐶
                                        @elseif($pet->category->slug === 'qushlar') 🐦
                                        @elseif($pet->category->slug === 'baliqlar') 🐟
                                        @else 🐾
                                        @endif
                                        {{ $pet->category->name }}
                                    </span>
                                </td>
                                <td class="fw-semibold" style="color:#667eea;">
                                    {{ number_format($pet->price, 0, ',', ' ') }} so'm
                                </td>
                                <td>
                                    @if($pet->status === 'available')
                                        <span class="badge bg-success">✅ Mavjud</span>
                                    @elseif($pet->status === 'pending')
                                        <span class="badge bg-warning text-dark">⏳ Band</span>
                                    @else
                                        <span class="badge bg-danger">❌ Sotilgan</span>
                                    @endif
                                </td>
                                @if(auth()->user()->isAdmin())
                                    <td class="text-muted small">{{ $pet->user?->name ?? '—' }}</td>
                                @endif
                                <td class="text-muted small">{{ $pet->created_at->format('d.m.Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('pets.edit', $pet) }}"
                                            class="btn btn-sm btn-outline-primary">✏️</a>
                                        <form action="{{ route('pets.destroy', $pet) }}" method="POST"
                                            onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">🗑</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <div class="fs-1 mb-3">🐾</div>
                <p>Hozircha e'lonlar yo'q.</p>
                <a href="{{ route('pets.create') }}" class="btn btn-gradient px-4">➕ Birinchi e'lonni joylash</a>
            </div>
        @endif
    </div>

    {{-- Заказы --}}
    <div class="glass-container">
        <h4 class="fw-bold mb-4">
            📋 {{ auth()->user()->isAdmin() ? 'Barcha buyurtmalar' : 'Mening buyurtmalarim' }}
        </h4>

        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #f093fb22, #f5576c22);">
                        <tr>
                            <th>#</th>
                            <th>Hayvon</th>
                            <th>Mijoz</th>
                            <th>Telefon</th>
                            <th>Holat</th>
                            @if(auth()->user()->isAdmin())
                                <th>Foydalanuvchi</th>
                            @endif
                            <th>Sana</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="text-muted small">#{{ $order->id }}</td>
                                <td>
                                    @if($order->pet)
                                        <a href="{{ route('pets.show', $order->pet) }}" class="text-decoration-none fw-semibold" style="color:#667eea;">
                                            {{ $order->pet->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_phone }}</td>
                                <td>
                                    @if($order->status === 'new')
                                        <span class="badge bg-primary">🆕 Yangi</span>
                                    @elseif($order->status === 'confirmed')
                                        <span class="badge bg-success">✅ Tasdiqlangan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                    @endif
                                </td>
                                @if(auth()->user()->isAdmin())
                                    <td class="text-muted small">{{ $order->user?->name ?? '—' }}</td>
                                @endif
                                <td class="text-muted small">{{ $order->created_at->format('d.m.Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <div class="fs-1 mb-2">📭</div>
                <p class="mb-0">Hozircha buyurtmalar yo'q.</p>
            </div>
        @endif
    </div>

</div>
@endsection
