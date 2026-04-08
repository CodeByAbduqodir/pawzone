@props(['type' => 'success', 'msg'])

@php
    $alertClass = match ($type) {
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
        default => 'alert-danger',
    };
@endphp

<div class="alert {{ $alertClass }} alert-dismissible fade show mb-4" role="alert">
    {{ $msg }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
