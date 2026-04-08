@extends('layouts.app')

@section('title', 'Admin Dashboard — PawZone')

@section('content')
<div class="container-xl">
    <div class="hero-surface mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <span class="hero-kicker">Admin</span>
                <h1 class="hero-title">Boshqaruv paneli</h1>
                <p class="hero-subtitle mb-0">
                    E'lonlar, moderatsiya va so'nggi harakatlarni bir joydan kuzating.
                </p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.analytics') }}" class="btn btn-outline-primary px-4">Analitika</a>
                <a href="{{ route('admin.audit-log') }}" class="btn btn-gradient px-4">Audit log</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success" :msg="session('success')" />
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-2">
            <div class="section-card stat-card h-100"><div class="stat-value" style="color: var(--primary);">{{ $stats['total'] }}</div><div class="stat-label">Jami</div></div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="section-card stat-card h-100"><div class="stat-value text-success">{{ $stats['active'] }}</div><div class="stat-label">Faol</div></div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="section-card stat-card h-100"><div class="stat-value text-warning">{{ $stats['pending'] }}</div><div class="stat-label">Jarayonda</div></div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="section-card stat-card h-100"><div class="stat-value text-secondary">{{ $stats['resolved'] }}</div><div class="stat-label">Hal qilingan</div></div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="section-card stat-card h-100"><div class="stat-value text-danger">{{ $stats['lost'] }}</div><div class="stat-label">Yo'qoldi</div></div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="section-card stat-card h-100"><div class="stat-value text-info">{{ $stats['found'] }}</div><div class="stat-label">Topildi</div></div>
        </div>
    </div>

    <div class="section-card mb-4">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3 align-items-end">
            <div class="col-lg-4">
                <label class="form-label">Qidiruv</label>
                <input type="text" name="search" class="form-control" placeholder="Nomi yoki telefon..." value="{{ request('search') }}">
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label">Holat</label>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Barchasi</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Faol</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Jarayonda</option>
                    <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Hal qilingan</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label">Turi</label>
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="">Barchasi</option>
                    <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>Yo'qoldi</option>
                    <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>Topildi</option>
                </select>
            </div>
            <div class="col-lg-4">
                <div class="page-actions justify-content-lg-end">
                    <button type="submit" class="btn btn-gradient px-4">Filtrlash</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4">Tozalash</a>
                </div>
            </div>
        </form>
    </div>

    <div class="section-card mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h4 class="mb-0">E'lonlar</h4>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>E'lon</th>
                        <th>Muallif</th>
                        <th>Turi</th>
                        <th>Telefon</th>
                        <th>Holat</th>
                        <th>Sana</th>
                        <th style="min-width: 220px;">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pets as $pet)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $pet->name }}</div>
                                <div class="small text-muted">{{ $pet->category->name }}</div>
                            </td>
                            <td>
                                <div>{{ $pet->user->name }}</div>
                                <div class="small text-muted">{{ $pet->user->email }}</div>
                            </td>
                            <td>
                                <span class="badge rounded-pill text-bg-light border">
                                    {{ $pet->type === 'lost' ? 'Yo\'qoldi' : 'Topildi' }}
                                </span>
                            </td>
                            <td><a href="tel:{{ $pet->phone }}">{{ $pet->phone }}</a></td>
                            <td>
                                <span class="badge rounded-pill {{ $pet->status === 'available' ? 'bg-success' : ($pet->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                    {{ $pet->status === 'available' ? 'Faol' : ($pet->status === 'pending' ? 'Jarayonda' : 'Hal qilingan') }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $pet->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('pets.show', $pet) }}" class="btn btn-sm btn-outline-primary">Ko'rish</a>
                                    <a href="{{ route('pets.edit', $pet) }}" class="btn btn-sm btn-outline-secondary">Tahrirlash</a>

                                    @if($pet->status !== 'available')
                                        <form action="{{ route('admin.moderate', $pet) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn btn-sm btn-success">Faollashtirish</button>
                                        </form>
                                    @endif

                                    @if($pet->status === 'available')
                                        <form action="{{ route('admin.moderate', $pet) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn btn-sm btn-warning text-dark">Yopish</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.delete-pet', $pet) }}" method="POST" class="d-inline" onsubmit="return confirm('E\'lonni o\'chirishni tasdiqlaysizmi?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">O'chirish</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state py-4">
                                    <div class="emoji">🫥</div>
                                    <p class="mb-0">E'lonlar topilmadi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pets->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $pets->onEachSide(1)->links() }}
            </div>
        @endif
    </div>

    <div class="section-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h4 class="mb-0">So'nggi harakatlar</h4>
            <a href="{{ route('admin.audit-log') }}" class="btn btn-outline-primary btn-sm px-3">Barchasi</a>
        </div>

        @if($recentActions->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Vaqt</th>
                            <th>Foydalanuvchi</th>
                            <th>Xarakat</th>
                            <th>E'lon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentActions as $log)
                            <tr>
                                <td class="text-muted small">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $log->user->name }}</td>
                                <td>
                                    <span class="badge rounded-pill text-bg-light border">{{ $log->action }}</span>
                                </td>
                                <td>
                                    @if($log->pet)
                                        <a href="{{ route('pets.show', $log->pet) }}" class="text-decoration-none">{{ $log->pet->name }}</a>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="emoji">📭</div>
                <p class="mb-0">So'nggi harakatlar yo'q.</p>
            </div>
        @endif
    </div>
</div>
@endsection
