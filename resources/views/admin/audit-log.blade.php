@extends('layouts.app')

@section('title', 'Audit Log — PawZone')

@section('content')
<div class="container-xl">
    <div class="hero-surface mb-4">
        <span class="hero-kicker">Audit</span>
        <h1 class="hero-title">Harakatlar tarixi</h1>
        <p class="hero-subtitle mb-0">
            Kim nima qilganini filtrlab, e'lonlar bo'yicha barcha izlarni kuzating.
        </p>
    </div>

    <div class="section-card mb-4">
        <form method="GET" action="{{ route('admin.audit-log') }}" class="row g-3 align-items-end">
            <div class="col-lg-3">
                <label class="form-label">Harakat</label>
                <select name="action" class="form-select" onchange="this.form.submit()">
                    <option value="">Barchasi</option>
                    <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>Yaratildi</option>
                    <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>Yangilandi</option>
                    <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>O'chirildi</option>
                    <option value="moderated" {{ request('action') === 'moderated' ? 'selected' : '' }}>Moderatsiya</option>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="form-label">Boshlanish</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" onchange="this.form.submit()">
            </div>
            <div class="col-lg-3">
                <label class="form-label">Tugash</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" onchange="this.form.submit()">
            </div>
            <div class="col-lg-3">
                <a href="{{ route('admin.audit-log') }}" class="btn btn-outline-secondary w-100">Tozalash</a>
            </div>
        </form>
    </div>

    <div class="section-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Vaqt</th>
                        <th>Foydalanuvchi</th>
                        <th>Harakat</th>
                        <th>E'lon</th>
                        <th>IP</th>
                        <th>Tafsilot</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-muted small">{{ $log->created_at->format('d.m.Y H:i:s') }}</td>
                            <td>
                                <div class="fw-semibold">{{ $log->user->name }}</div>
                                <div class="small text-muted">{{ $log->user->email }}</div>
                            </td>
                            <td>
                                <span class="badge rounded-pill text-bg-light border">{{ $log->actionLabel() }}</span>
                            </td>
                            <td>
                                @if($log->pet)
                                    <a href="{{ route('pets.show', $log->pet) }}" class="text-decoration-none">{{ $log->pet->name }}</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-muted small">{{ $log->ip_address ?? '—' }}</td>
                            <td>
                                @if($log->new_values || $log->old_values)
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $log->id }}">Ko'rish</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state py-4">
                                    <div class="emoji">🗂️</div>
                                    <p class="mb-0">Harakatlar topilmadi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @foreach($logs as $log)
            @if($log->new_values || $log->old_values)
                <div class="modal fade" id="detailsModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tafsilotlar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @if($log->old_values)
                                    <div class="mb-3">
                                        <div class="fw-semibold mb-2">Oldingi qiymatlar</div>
                                        <pre class="bg-light p-3 rounded-3 mb-0 small"><code>{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                    </div>
                                @endif
                                @if($log->new_values)
                                    <div>
                                        <div class="fw-semibold mb-2">Yangi qiymatlar</div>
                                        <pre class="bg-light p-3 rounded-3 mb-0 small"><code>{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @if($logs->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $logs->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
