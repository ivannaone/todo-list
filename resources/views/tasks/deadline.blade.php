@extends('layout.app')

@section('title', 'Deadline — TaskFlow')
@section('page-title', 'Tugas Terlambat')
@section('page-subtitle', 'Tugas yang melewati batas waktu dan belum selesai')

@section('topbar-actions')
    <a href="/tasks" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('content')

@if($tasks->isEmpty())
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <i class="fa-solid fa-party-horn" style="color:#10b981;opacity:1;"></i>
                <h5>Semua tugas tepat waktu!</h5>
                <p>Tidak ada tugas yang melewati deadline. Kerja bagus! 🎉</p>
                <a href="/tasks" class="btn btn-primary mt-2">Lihat Semua Tugas</a>
            </div>
        </div>
    </div>
@else
    <!-- Alert Banner -->
    <div class="alert alert-danger mb-4" style="border-radius:12px;">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        <strong>{{ $tasks->count() }} tugas</strong> melewati deadline dan belum diselesaikan.
    </div>

    <div class="row g-3">
        @foreach($tasks as $task)
        @php
            $daysLate = \Carbon\Carbon::parse($task->deadline)->diffInDays(\Carbon\Carbon::now());
            $priorityColors = ['high' => '#ef4444', 'medium' => '#f59e0b', 'low' => '#10b981'];
            $priorityLabels = ['high' => 'Tinggi', 'medium' => 'Sedang', 'low' => 'Rendah'];
            $pColor = $priorityColors[$task->priority ?? 'medium'];
            $pLabel = $priorityLabels[$task->priority ?? 'medium'];
        @endphp
        <div class="col-md-6 col-lg-4">
            <div class="task-card" style="border-left:4px solid #ef4444;">
                <div style="padding-left:8px;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="task-title">{{ $task->title }}</div>
                        <span class="badge-status badge-late">Terlambat</span>
                    </div>

                    @if($task->description)
                        <p class="task-desc mb-3">{{ $task->description }}</p>
                    @endif

                    <div class="p-2 mb-3" style="background:rgba(239,68,68,0.08);border-radius:8px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-calendar-xmark" style="color:#ef4444;font-size:13px;"></i>
                            <div>
                                <div style="font-size:12px;color:#ef4444;font-weight:600;">
                                    {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') }}
                                </div>
                                <div style="font-size:11px;color:var(--text-secondary);">
                                    {{ $daysLate }} hari yang lalu
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span style="font-size:11px;color:var(--text-secondary);">Prioritas:</span>
                        <span style="font-size:11px;font-weight:600;color:{{ $pColor }};">● {{ $pLabel }}</span>
                    </div>

                    <div class="d-flex gap-2">
                        <form action="/tasks/{{ $task->id }}/toggle" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" style="font-size:13px;">
                                <i class="fa-solid fa-check me-1"></i> Tandai Selesai
                            </button>
                        </form>
                        <a href="/tasks/{{ $task->id }}/edit" class="btn btn-warning" style="font-size:13px;">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
