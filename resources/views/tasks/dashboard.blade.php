@extends('layout.app')

@section('title', 'Dashboard — TaskFlow')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas tugas kamu')

@section('topbar-actions')
    <a href="/tasks/create" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Tambah Tugas
    </a>
@endsection

@section('content')

@php
    $today   = date('Y-m-d');
    $total   = $tasks->count();
    $done    = $tasks->where('is_done', true)->count();
    $pending = $total - $done;
    $late    = $tasks->filter(fn($t) => !$t->is_done && $t->deadline && $t->deadline < $today)->count();
    $pct     = $total > 0 ? round(($done / $total) * 100) : 0;
    $todayTasks = $tasks->filter(fn($t) => $t->deadline == $today && !$t->is_done);
@endphp

<!-- Stat Cards -->
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
    <!-- Progress Card -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="font-size:14px;">
                    <i class="fa-solid fa-chart-pie me-2" style="color:#6366f1;"></i>
                    Progress Keseluruhan
                </h6>

                <!-- Donut Chart -->
                <div class="text-center mb-4">
                    <div style="position:relative;display:inline-block;">
                        <canvas id="donutChart" width="160" height="160"></canvas>
                        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                            <div style="font-size:28px;font-weight:700;color:var(--text-primary);">{{ $pct }}%</div>
                            <div style="font-size:11px;color:var(--text-secondary);">Selesai</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-around">
                    <div class="text-center">
                        <div style="width:10px;height:10px;border-radius:50%;background:#10b981;display:inline-block;margin-right:4px;"></div>
                        <span style="font-size:12px;color:var(--text-secondary);">Selesai ({{ $done }})</span>
                    </div>
                    <div class="text-center">
                        <div style="width:10px;height:10px;border-radius:50%;background:#f59e0b;display:inline-block;margin-right:4px;"></div>
                        <span style="font-size:12px;color:var(--text-secondary);">Pending ({{ $pending - $late }})</span>
                    </div>
                    <div class="text-center">
                        <div style="width:10px;height:10px;border-radius:50%;background:#ef4444;display:inline-block;margin-right:4px;"></div>
                        <span style="font-size:12px;color:var(--text-secondary);">Terlambat ({{ $late }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Tasks -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0" style="font-size:14px;">
                        <i class="fa-regular fa-calendar-check me-2" style="color:#6366f1;"></i>
                        Deadline Hari Ini
                    </h6>
                    <span class="badge" style="background:rgba(99,102,241,0.15);color:#6366f1;font-size:11px;">
                        {{ $todayTasks->count() }} tugas
                    </span>
                </div>

                @forelse($todayTasks as $task)
                    <div class="d-flex align-items-center gap-3 mb-3 p-3"
                         style="background:var(--input-bg);border-radius:10px;">
                        <div style="width:8px;height:8px;border-radius:50%;background:{{ $task->priority == 'high' ? '#ef4444' : ($task->priority == 'medium' ? '#f59e0b' : '#10b981') }};flex-shrink:0;"></div>
                        <div class="flex-grow-1">
                            <div style="font-size:13px;font-weight:600;color:var(--text-primary);">{{ $task->title }}</div>
                            @if($task->description)
                                <div style="font-size:11px;color:var(--text-secondary);">{{ Str::limit($task->description, 50) }}</div>
                            @endif
                        </div>
                        <form action="/tasks/{{ $task->id }}/toggle" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" style="border-radius:8px;font-size:11px;padding:4px 10px;">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="empty-state" style="padding:30px 0;">
                        <i class="fa-solid fa-party-horn" style="font-size:32px;"></i>
                        <p class="mt-2" style="font-size:13px;">Tidak ada deadline hari ini 🎉</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0" style="font-size:14px;">
                        <i class="fa-solid fa-clock-rotate-left me-2" style="color:#6366f1;"></i>
                        Aktivitas Terbaru
                    </h6>
                    <a href="/tasks" style="font-size:12px;color:#6366f1;text-decoration:none;">Lihat semua →</a>
                </div>

                @forelse($tasks->take(6) as $task)
                @php
                    $isLate = !$task->is_done && $task->deadline && $task->deadline < $today;
                @endphp
                <div class="d-flex align-items-center gap-3 py-2"
                     style="border-bottom:1px solid var(--card-border);">
                    <div style="width:36px;height:36px;border-radius:10px;background:{{ $task->is_done ? 'rgba(16,185,129,0.15)' : ($isLate ? 'rgba(239,68,68,0.15)' : 'rgba(99,102,241,0.15)') }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid {{ $task->is_done ? 'fa-check' : ($isLate ? 'fa-exclamation' : 'fa-clock') }}"
                           style="font-size:13px;color:{{ $task->is_done ? '#10b981' : ($isLate ? '#ef4444' : '#6366f1') }};"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);">{{ $task->title }}</div>
                        <div style="font-size:11px;color:var(--text-secondary);">
                            {{ $task->deadline ? 'Deadline: ' . \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') : 'Tanpa deadline' }}
                        </div>
                    </div>
                    @if($task->is_done)
                        <span class="badge-status badge-done">Selesai</span>
                    @elseif($isLate)
                        <span class="badge-status badge-late">Terlambat</span>
                    @else
                        <span class="badge-status badge-pending">Berjalan</span>
                    @endif
                </div>
                @empty
                    <div class="empty-state" style="padding:30px 0;">
                        <i class="fa-solid fa-inbox"></i>
                        <p>Belum ada aktivitas</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const done = {{ $done }};
    const pending = {{ $pending - $late }};
    const late = {{ $late }};
    const total = {{ $total }};

    const ctx = document.getElementById('donutChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: total > 0 ? [done, pending, late] : [1],
                backgroundColor: total > 0
                    ? ['#10b981', '#f59e0b', '#ef4444']
                    : ['#e2e8f0'],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            cutout: '72%',
            plugins: { legend: { display: false }, tooltip: { enabled: total > 0 } },
            animation: { animateRotate: true, duration: 800 }
        }
    });
</script>
@endsection
