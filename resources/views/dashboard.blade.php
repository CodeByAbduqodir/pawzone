@extends('layouts.app')

@section('title', 'Dashboard — PawZone')

@section('content')
<div class="container-xl">
    <div class="hero-surface mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <span class="hero-kicker">Dashboard</span>
                <h1 class="hero-title">Xush kelibsiz, {{ auth()->user()->name }}!</h1>
                <p class="hero-subtitle mb-0">
                    E'lonlar, buyurtmalar va holatlarni bir ekranda kuzating.
                </p>
            </div>

            <a href="{{ route('pets.create') }}" class="btn btn-gradient-success px-4 py-2">
                + Yangi e'lon
            </a>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success" :msg="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="danger" :msg="session('error')" />
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="section-card stat-card h-100">
                <div class="stat-value" style="color: var(--primary);">{{ $stats['total_pets'] }}</div>
                <div class="stat-label">Jami e'lonlar</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="section-card stat-card h-100">
                <div class="stat-value text-success">{{ $stats['available'] }}</div>
                <div class="stat-label">Faol</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="section-card stat-card h-100">
                <div class="stat-value text-warning">{{ $stats['pending'] }}</div>
                <div class="stat-label">Jarayonda</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="section-card stat-card h-100">
                <div class="stat-value text-danger">{{ $stats['total_orders'] }}</div>
                <div class="stat-label">Buyurtmalar</div>
            </div>
        </div>
    </div>

    <div class="section-card mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h4 class="mb-0">{{ auth()->user()->isAdmin() ? 'Barcha e\'lonlar' : 'Mening e\'lonlarim' }}</h4>
            <a href="{{ route('pets.create') }}" class="btn btn-outline-primary btn-sm px-3">Qo'shish</a>
        </div>

        @if($pets->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>E'lon</th>
                            <th>Kategoriya</th>
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
                                    <div class="fw-semibold">{{ $pet->name }}</div>
                                    @if($pet->type === 'lost')
                                        <div class="small text-muted">Yo'qolgan</div>
                                    @else
                                        <div class="small text-muted">Topilgan</div>
                                    @endif
                                </td>
                                <td>{{ $pet->category->name }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $pet->status === 'available' ? 'bg-success' : ($pet->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ $pet->status === 'available' ? 'Faol' : ($pet->status === 'pending' ? 'Jarayonda' : 'Hal qilingan') }}
                                    </span>
                                </td>
                                @if(auth()->user()->isAdmin())
                                    <td class="text-muted small">{{ $pet->user?->name ?? '—' }}</td>
                                @endif
                                <td class="text-muted small">{{ $pet->created_at->format('d.m.Y') }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('pets.show', $pet) }}" class="btn btn-sm btn-outline-primary">Ko'rish</a>
                                        <a href="{{ route('pets.edit', $pet) }}" class="btn btn-sm btn-outline-secondary">Tahrirlash</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="emoji">🐾</div>
                <h5>Hozircha e'lon yo'q</h5>
                <p class="mb-3">Birinchi e'lonni joylab, kabinetni to'ldiring.</p>
                <a href="{{ route('pets.create') }}" class="btn btn-gradient px-4">E'lon joylash</a>
            </div>
        @endif
    </div>

    <div class="section-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h4 class="mb-0">{{ auth()->user()->isAdmin() ? 'Barcha buyurtmalar' : 'Mening buyurtmalarim' }}</h4>
        </div>

        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
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
                                <td class="fw-semibold">
                                    @if($order->pet)
                                        <a href="{{ route('pets.show', $order->pet) }}" class="text-decoration-none">{{ $order->pet->name }}</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_phone }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $order->status === 'new' ? 'bg-primary' : ($order->status === 'confirmed' ? 'bg-success' : 'bg-secondary') }}">
                                        {{ $order->status === 'new' ? 'Yangi' : ($order->status === 'confirmed' ? 'Tasdiqlangan' : $order->status) }}
                                    </span>
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
            <div class="empty-state">
                <div class="emoji">📭</div>
                <h5>Hozircha buyurtma yo'q</h5>
                <p class="mb-0">Yangi buyurtmalar shu yerda ko'rinadi.</p>
            </div>
        @endif
    </div>
</div>
@endsection
