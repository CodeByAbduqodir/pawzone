@extends('layouts.app')

@section('title', 'Analitika — PawZone')

@section('content')
<div class="container-xl">
    <div class="hero-surface mb-4">
        <span class="hero-kicker">ka</span>
        <h1 class="hero-title">Statistika va trendlar</h1>
        <p class="hero-subtitle mb-0">
            E'lonlar bo'yicha umumiy ko'rinish, statuslar va geografik taqsimot.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="section-card h-100">
                <h5 class="mb-3">Yo'qolgan / Topilgan</h5>
                <canvas id="lostFoundChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="section-card h-100">
                <h5 class="mb-3">Holatlar</h5>
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="section-card mb-4">
        <h5 class="mb-3">So'nggi 30 kun</h5>
        <canvas id="trendChart"></canvas>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="section-card h-100">
                <h5 class="mb-3">Kategoriyalar</h5>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="section-card h-100">
                <h5 class="mb-3">Top hududlar</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Hudud</th>
                                <th>E'lonlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($regionStats as $region)
                                <tr>
                                    <td class="fw-semibold">{{ $region->location }}</td>
                                    <td><span class="badge rounded-pill bg-info">{{ $region->count }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        <div class="empty-state py-4">
                                            <div class="emoji">📭</div>
                                            <p class="mb-0">Ma'lumot yo'q.</p>
                                        </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const palette = {
        blue: 'rgba(59, 130, 246, 0.75)',
        green: 'rgba(16, 185, 129, 0.75)',
        amber: 'rgba(245, 158, 11, 0.75)',
        slate: 'rgba(100, 116, 139, 0.75)'
    };

    new Chart(document.getElementById('lostFoundChart'), {
        type: 'doughnut',
        data: {
            labels: ['Yo\'qolgan', 'Topilgan'],
            datasets: [{
                data: [{{ $lostFoundStats['lost'] }}, {{ $lostFoundStats['found'] }}],
                backgroundColor: [palette.blue, palette.green],
                borderColor: ['#3b82f6', '#10b981'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18 } }
            }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: ['Faol', 'Jarayonda', 'Yopiq'],
            datasets: [{
                data: [{{ $statusStats['available'] }}, {{ $statusStats['pending'] }}, {{ $statusStats['resolved'] }}],
                backgroundColor: [palette.green, palette.amber, palette.slate],
                borderColor: ['#10b981', '#f59e0b', '#64748b'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18 } }
            }
        }
    });

    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyTrend) !!},
            datasets: [{
                label: "E'lonlar",
                data: {!! json_encode($dailyPerDay) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.10)',
                fill: true,
                tension: 0.35,
                pointRadius: 3,
                pointBackgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoryNames) !!},
            datasets: [{
                label: 'E\'lonlar',
                data: {!! json_encode(array_values($categoryStats)) !!},
                backgroundColor: ['rgba(59, 130, 246, 0.75)', 'rgba(16, 185, 129, 0.75)', 'rgba(245, 158, 11, 0.75)', 'rgba(100, 116, 139, 0.75)'],
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endsection
