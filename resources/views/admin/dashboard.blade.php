@extends('layouts.app')

@section('title', 'Admin Dashboard — PawZone')

@section('content')
<div class="container-fluid py-5">
    <div class="glass-container">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="display-5 fw-bold mb-1">🛡️ Admin Dashboard</h1>
            <p class="text-muted">Boshqaruv paneli va e'lonlarni moderatsiya</p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Statistics Cards --}}
        <div class="row g-3 mb-5">
            <div class="col-md-2">
                <div class="card border-0 shadow-sm" style="background:linear-gradient(135deg,#667eea,#764ba2);">
                    <div class="card-body text-white">
                        <h6 class="card-title text-white-50">Jami</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm" style="background:linear-gradient(135deg,#43e97b,#38f9d7);">
                    <div class="card-body text-dark">
                        <h6 class="card-title text-muted">Faol</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['active'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm" style="background:linear-gradient(135deg,#fa709a,#fee140);">
                    <div class="card-body text-dark">
                        <h6 class="card-title text-muted">Jarayonda</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['pending'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm" style="background:linear-gradient(135deg,#a8edea,#fed6e3);">
                    <div class="card-body text-dark">
                        <h6 class="card-title text-muted">Hal Qilindi</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['resolved'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm" style="background:linear-gradient(135deg,#ff9db5,#ff6e7f);">
                    <div class="card-body text-white">
                        <h6 class="card-title text-white-50">Yo'qoldi</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['lost'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm" style="background:linear-gradient(135deg,#4facfe,#00f2fe);">
                    <div class="card-body text-white">
                        <h6 class="card-title text-white-50">Topildi</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['found'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Buttons --}}
        <div class="mb-4 pb-3" style="border-bottom:1px solid #e9ecef;">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex flex-wrap gap-2 align-items-center">
                <input type="text" name="search" class="form-control form-control-sm" style="width:200px;"
                    placeholder="🔍 Nomi yoki telefon..." value="{{ request('search') }}">
                <select name="status" class="form-select form-select-sm" style="width:120px;" onchange="this.form.submit()">
                    <option value="">Holat: Barchasi</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Faol</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Jarayonda</option>
                    <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Hal Qilindi</option>
                </select>
                <select name="type" class="form-select form-select-sm" style="width:120px;" onchange="this.form.submit()">
                    <option value="">Turi: Barchasi</option>
                    <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>Yo'qoldi</option>
                    <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>Topildi</option>
                </select>
                <button type="submit" class="btn btn-sm btn-outline-secondary">Qidirish</button>
                <a href="{{ route('admin.analytics') }}" class="btn btn-sm btn-outline-info">
                    📊 Analitika
                </a>
                <a href="{{ route('admin.audit-log') }}" class="btn btn-sm btn-outline-primary ms-auto">
                    📋 Audit Log
                </a>
            </form>
        </div>

        {{-- Pets Table --}}
        <div class="table-responsive">
            <table class="table table-hover border-0">
                <thead class="table-light">
                    <tr>
                        <th>E'lon</th>
                        <th>Muallif</th>
                        <th>Turi</th>
                        <th>Telefon</th>
                        <th>Holat</th>
                        <th>Sana</th>
                        <th>Xarakat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pets as $pet)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $pet->name }}</div>
                                <div class="small text-muted">{{ $pet->category->name }}</div>
                            </td>
                            <td>
                                <div>{{ $pet->user->name }}</div>
                                <div class="small text-muted">{{ $pet->user->email }}</div>
                            </td>
                            <td>
                                @if($pet->type === 'lost')
                                    <span class="badge" style="background:#f5576c;">😢 Yo'qoldi</span>
                                @else
                                    <span class="badge" style="background:#43e97b;">🎉 Topildi</span>
                                @endif
                            </td>
                            <td>
                                <a href="tel:{{ $pet->phone }}">{{ $pet->phone }}</a>
                            </td>
                            <td>
                                @if($pet->status === 'available')
                                    <span class="badge bg-success">✅ Faol</span>
                                @elseif($pet->status === 'pending')
                                    <span class="badge bg-warning text-dark">⏳ Jarayonda</span>
                                @else
                                    <span class="badge bg-secondary">✔️ Hal Qilindi</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $pet->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('pets.show', $pet) }}" class="btn btn-outline-primary" title="Ko'rish">
                                        👁️
                                    </a>
                                    <a href="{{ route('pets.edit', $pet) }}" class="btn btn-outline-secondary" title="Tahrirlash">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.delete-pet', $pet) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('O'chirmoqchimisiz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="O'chirish">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                E'lonlar topilmadi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pets->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $pets->onEachSide(1)->links() }}
            </div>
        @endif

        {{-- Recent Actions --}}
        <hr class="my-5">

        <h4 class="fw-bold mb-3">📢 So'nggi xarakat</h4>
        <div class="table-responsive">
            <table class="table table-sm table-hover border-0">
                <thead class="table-light">
                    <tr>
                        <th>Vaqt</th>
                        <th>Foydalanuvchi</th>
                        <th>Xarakat</th>
                        <th>E'lon</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActions as $log)
                        <tr>
                            <td class="text-muted small">
                                {{ $log->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td>
                                <div class="small">{{ $log->user->name }}</div>
                            </td>
                            <td>
                                @if($log->action === 'created')
                                    <span class="badge bg-success">➕ Yaratildi</span>
                                @elseif($log->action === 'updated')
                                    <span class="badge bg-info">✏️ Yangilandi</span>
                                @elseif($log->action === 'deleted')
                                    <span class="badge bg-danger">🗑️ O'chirildi</span>
                                @elseif($log->action === 'moderated')
                                    <span class="badge bg-warning">🎯 Moderatsiya</span>
                                @endif
                            </td>
                            <td>
                                @if($log->pet)
                                    <a href="{{ route('pets.show', $log->pet) }}" class="text-decoration-none">
                                        {{ $log->pet->name }}
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                Xarakat yo'q
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
