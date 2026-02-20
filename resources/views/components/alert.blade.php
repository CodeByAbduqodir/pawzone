@props(['type' => 'success', 'msg'])

@php
    $alertClass = $type === 'success' ? 'alert-success' : 'alert-danger';
@endphp

<div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
    {{ $msg }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>