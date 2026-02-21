@extends('layouts.app')

@section('title', 'Audit Log — Admin')

@section('content')
<div class="container-fluid py-5">
    <div class="glass-container">

        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted small">← Dashboard</a>
            <h1 class="display-5 fw-bold mt-2 mb-1">📋 Audit Log</h1>
            <p class="text-muted">Barcha xarakat va o'zgarishlarning tarixi</p>
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.audit-log') }}" class="mb-4 pb-3" style="border-bottom:1px solid #e9ecef;">
            <div class="row g-2">
                <div class="col-md-3">
                    <select name="action" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Xarakat: Barchasi</option>
                        <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>➕ Yaratildi</option>
                        <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>✏️ Yangilandi</option>
                        <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>🗑️ O'chirildi</option>
                        <option value="moderated" {{ request('action') === 'moderated' ? 'selected' : '' }}>🎯 Moderatsiya</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <button type="reset" class="btn btn-sm btn-outline-secondary w-100" onclick="window.location.href='{{ route('admin.audit-log') }}'">
                        Qayta tiklash
                    </button>
                </div>
            </div>
        </form>

        {{-- Logs Table --}}
        <div class="table-responsive">
            <table class="table table-hover border-0">
                <thead class="table-light">
                    <tr>
                        <th>Vaqt</th>
                        <th>Foydalanuvchi</th>
                        <th>Xarakat</th>
                        <th>E'lon</th>
                        <th>IP Manzili</th>
                        <th>Tafsilotlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-muted small">
                                {{ $log->created_at->format('d.m.Y H:i:s') }}
                            </td>
                            <td>
                                <div class="fw-bold">{{ $log->user->name }}</div>
                                <div class="small text-muted">{{ $log->user->email }}</div>
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
                            <td class="small text-muted">
                                {{ $log->ip_address ?? '—' }}
                            </td>
                            <td>
                                @if($log->new_values || $log->old_values)
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                        data-bs-target="#detailsModal{{ $log->id }}">
                                        👁️ Ko'rish
                                    </button>
                                @endif
                            </td>
                        </tr>

                        {{-- Details Modal --}}
                        @if($log->new_values || $log->old_values)
                            <div class="modal fade" id="detailsModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tafsilotlar — {{ $log->pet->name ?? 'E\'lon' }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($log->old_values)
                                                <h6 class="fw-bold mb-2">Oldingi qiymatlar:</h6>
                                                <div class="bg-light p-2 rounded mb-3 small">
                                                    <code>{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code>
                                                </div>
                                            @endif
                                            @if($log->new_values)
                                                <h6 class="fw-bold mb-2">Yangi qiymatlar:</h6>
                                                <div class="bg-light p-2 rounded small">
                                                    <code>{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Xarakat yo'q
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $logs->onEachSide(1)->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
