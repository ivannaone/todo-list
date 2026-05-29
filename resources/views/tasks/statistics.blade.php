@extends('layout.app')

@section('title', 'Statistik — TaskFlow')
@section('page-title', 'Statistik')
@section('page-subtitle', 'Analisis performa penyelesaian tugas kamu')

@section('content')

@php
    $today   = date('Y-m-d');
    $total   = $tasks->count();
    $done    = $tasks->where('is_done', true)->count();
    $pending = $total - $done;
    $late    = $tasks->filter(fn($t) => !$t->is_done && $t->deadline && $t->deadline < $today)->count();
    $pct     = $total > 0 ? round(($done / $total) * 100) : 0;

    $highTotal  = $tasks->where('priority', 'high')->count();
    $highDone   = $tasks->where('priority', 'high')->where('is_done', true)->count();
    $medTotal   = $tasks->where('priority', 'medium')->count();
    $medDone    = $tasks->where('priority', 'medium')->where('is_done', true)->count();
    $lowTotal   = $tasks->where('priority', 'low')->count();
    $lowDone    = $tasks->where('priority', 'low')->where('is_done', true)->count();
@endphp

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card stat-blue">
            <div class="stat-icon"><i class="fa-solid fa-list-check"></i></div>
            <div class="stat-value">{{ $total }}</div>
            <div class="stat-label">Total Tugas</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-value">{{ $done }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card stat-orange">
            <div class="stat-icon"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-value">{{ $pending }}</div>
            <div class="stat-label">Belum Selesai</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card stat-red">
            <div class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="stat-value">{{ $late }}</div>
            <div class="stat-label">Terlambat</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Bar Chart -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="font-size:14px;">
                    <i class="fa-solid fa-chart-bar me-2" style="color:#6366f1;"></i>
                    Distribusi Status Tugas
                </h6>
                <canvas id="barChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Completion Rate -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="font-size:14px;">
                    <i class="fa-solid fa-bullseye me-2" style="color:#6366f1;"></i>
                    Tingkat Penyelesaian
                </h6>

                <div class="text-center mb-4">
                    <div style="font-size:52px;font-weight:800;background:linear-gradient(135deg,#6366f1,#10b981);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                        {{ $pct }}%
                    </div>
                    <div style="font-size:13px;color:var(--text-secondary);">tugas berhasil diselesaikan</div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:12px;font-weight:600;">Selesai</span>
                        <span style="font-size:12px;color:var(--text-secondary);">{{ $done }}/{{ $total }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width:{{ $pct }}%;background:linear-gradient(90deg,#10b981,#059669);border-radius:10px;"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:12px;font-weight:600;">Terlambat</span>
                        <span style="font-size:12px;color:var(--text-secondary);">{{ $late }}/{{ $total }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width:{{ $total > 0 ? round(($late/$total)*100) : 0 }}%;background:linear-gradient(90deg,#ef4444,#dc2626);border-radius:10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Priority Breakdown -->
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="font-size:14px;">
                    <i class="fa-solid fa-flag me-2" style="color:#6366f1;"></i>
                    Penyelesaian per Prioritas
                </h6>
                <div class="row g-3">
                    @foreach([
                        ['label' => 'Prioritas Tinggi', 'total' => $highTotal, 'done' => $highDone, 'color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)', 'icon' => '🔴'],
                        ['label' => 'Prioritas Sedang', 'total' => $medTotal,  'done' => $medDone,  'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)', 'icon' => '🟡'],
                        ['label' => 'Prioritas Rendah', 'total' => $lowTotal,  'done' => $lowDone,  'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.1)', 'icon' => '🟢'],
                    ] as $p)
                    @php $ppct = $p['total'] > 0 ? round(($p['done']/$p['total'])*100) : 0; @endphp
                    <div class="col-md-4">
                        <div class="p-3" style="background:{{ $p['bg'] }};border-radius:12px;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="font-size:13px;font-weight:600;color:var(--text-primary);">
                                    {{ $p['icon'] }} {{ $p['label'] }}
                                </span>
                                <span style="font-size:18px;font-weight:700;color:{{ $p['color'] }};">{{ $ppct }}%</span>
                            </div>
                            <div class="progress mb-2" style="height:6px;">
                                <div class="progress-bar" style="width:{{ $ppct }}%;background:{{ $p['color'] }};border-radius:10px;"></div>
                            </div>
                            <div style="font-size:11px;color:var(--text-secondary);">
                                {{ $p['done'] }} dari {{ $p['total'] }} tugas selesai
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const isDark = document.documentElement.style.getPropertyValue('--body-bg') !== '';
    const textColor = getComputedStyle(document.documentElement).getPropertyValue('--text-secondary').trim() || '#64748b';

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Selesai', 'Berjalan', 'Terlambat'],
            datasets: [{
                label: 'Jumlah Tugas',
                data: [{{ $done }}, {{ $pending - $late }}, {{ $late }}],
                backgroundColor: [
                    'rgba(16,185,129,0.8)',
                    'rgba(245,158,11,0.8)',
                    'rgba(239,68,68,0.8)',
                ],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.raw} tugas`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#94a3b8', font: { size: 11 } },
                    grid: { color: 'rgba(148,163,184,0.1)' }
                },
                x: {
                    ticks: { color: '#94a3b8', font: { size: 12 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection
