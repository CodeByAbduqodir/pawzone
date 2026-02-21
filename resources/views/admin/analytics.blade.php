@extends('layouts.app')

@section('title', 'Аналитика — Admin')

@section('content')
<div class="container-fluid py-5">
    <div class="glass-container">

        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted small">← Dashboard</a>
            <h1 class="display-5 fw-bold mt-2 mb-1">📊 Аналитика</h1>
            <p class="text-muted">Статистика и график объявлений</p>
        </div>

        {{-- Потеряно/Найдено --}}
        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-4">📢 Потеряно vs Найдено</h5>
                    <canvas id="lostFoundChart" class="w-100"></canvas>
                </div>
            </div>

            {{-- Статусы --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-4">🎯 Распределение по статусам</h5>
                    <canvas id="statusChart" class="w-100"></canvas>
                </div>
            </div>
        </div>

        {{-- Тренд по дням --}}
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-4">📈 Тренд объявлений (последние 30 дней)</h5>
                    <canvas id="trendChart" class="w-100"></canvas>
                </div>
            </div>
        </div>

        {{-- Категории + Регионы --}}
        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-4">🐾 По категориям</h5>
                    <canvas id="categoryChart" class="w-100"></canvas>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-4">📍 Топ регионов</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm border-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Регион</th>
                                    <th>Объявлений</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($regionStats as $region)
                                    <tr>
                                        <td class="fw-semibold">{{ $region->location }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $region->count }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">
                                            Нет данных
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Потеряно vs Найдено
    const lostFoundCtx = document.getElementById('lostFoundChart').getContext('2d');
    new Chart(lostFoundCtx, {
        type: 'doughnut',
        data: {
            labels: ['😢 Потеряно', '🎉 Найдено'],
            datasets: [{
                data: [{{ $lostFoundStats['lost'] }}, {{ $lostFoundStats['found'] }}],
                backgroundColor: [
                    'rgba(245, 87, 108, 0.8)',
                    'rgba(67, 233, 123, 0.8)',
                ],
                borderColor: ['#f5576c', '#43e97b'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 13, weight: '600' },
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Статусы
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: ['✅ Faol', '⏳ Jarayonda', '✔️ Hal Qilindi'],
            datasets: [{
                data: [
                    {{ $statusStats['available'] }},
                    {{ $statusStats['pending'] }},
                    {{ $statusStats['resolved'] }}
                ],
                backgroundColor: [
                    'rgba(67, 233, 123, 0.8)',
                    'rgba(250, 112, 154, 0.8)',
                    'rgba(167, 165, 165, 0.8)',
                ],
                borderColor: ['#43e97b', '#fa709a', '#a7a5a5'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 13, weight: '600' },
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Тренд по дням
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyTrend) !!},
            datasets: [{
                label: 'Объявлений в день',
                data: {!! json_encode($dailyPerDay) !!},
                borderColor: 'rgba(102, 126, 234, 1)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: { size: 13, weight: '600' },
                        padding: 20
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Категории
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoryNames) !!},
            datasets: [{
                label: 'Объявлений',
                data: {!! json_encode(array_values($categoryStats)) !!},
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(67, 233, 123, 0.8)',
                ],
                borderColor: [
                    '#667eea',
                    '#f093fb',
                    '#4facfe',
                    '#43e97b'
                ],
                borderWidth: 2,
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endsection
