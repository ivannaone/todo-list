@extends('layout.app')

@section('title', 'Semua Tugas — TaskFlow')
@section('page-title', 'Semua Tugas')
@section('page-subtitle', 'Kelola dan pantau semua tugas kamu')

@section('topbar-actions')
    <div class="search-wrap d-none d-md-block">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Cari tugas...">
    </div>
    <a href="/tasks/create" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Tambah Tugas
    </a>
@endsection

@section('content')

@php
    $today  = date('Y-m-d');
    $total  = $tasks->count();
    $done   = $tasks->where('is_done', true)->count();
    $late   = $tasks->filter(fn($t) => !$t->is_done && $t->deadline && $t->deadline < $today)->count();
    $pending = $total - $done - $late;
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
            <div class="stat-label">Berjalan</div>
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

<!-- Filter Bar -->
<div class="card mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span style="font-size:13px;font-weight:600;color:var(--text-secondary);">Filter:</span>
            <button class="btn btn-sm filter-btn active" data-filter="all">Semua</button>
            <button class="btn btn-sm filter-btn" data-filter="pending">Berjalan</button>
            <button class="btn btn-sm filter-btn" data-filter="done">Selesai</button>
            <button class="btn btn-sm filter-btn" data-filter="late">Terlambat</button>
            <div class="ms-auto d-flex gap-2">
                <button class="btn btn-sm filter-priority active" data-priority="all">Semua Prioritas</button>
                <button class="btn btn-sm filter-priority" data-priority="high" style="color:#ef4444;border-color:#ef4444;">🔴 Tinggi</button>
                <button class="btn btn-sm filter-priority" data-priority="medium" style="color:#f59e0b;border-color:#f59e0b;">🟡 Sedang</button>
                <button class="btn btn-sm filter-priority" data-priority="low" style="color:#10b981;border-color:#10b981;">🟢 Rendah</button>
            </div>
        </div>
    </div>
</div>

<!-- Task Grid -->
<div class="row g-3" id="taskContainer">
    @forelse($tasks as $task)
    @php
        $isLate = !$task->is_done && $task->deadline && $task->deadline < $today;
        $statusClass = $task->is_done ? 'done' : ($isLate ? 'late' : 'pending');
        $priorityLabel = ['high' => 'Tinggi', 'medium' => 'Sedang', 'low' => 'Rendah'][$task->priority ?? 'medium'];
        $deadlineFormatted = $task->deadline ? \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') : null;
        $daysLeft = $task->deadline ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($task->deadline), false) : null;
    @endphp
    <div class="col-md-6 col-lg-4 task-item"
         data-status="{{ $statusClass }}"
         data-priority="{{ $task->priority ?? 'medium' }}">
        <div class="task-card {{ $task->is_done ? 'done' : '' }}">
            <!-- Priority bar -->
            <div class="priority-bar priority-{{ $task->priority ?? 'medium' }}"></div>

            <div style="padding-left: 10px;">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1 me-2">
                        <div class="task-title {{ $task->is_done ? 'text-decoration-line-through' : '' }}">
                            {{ $task->title }}
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1">
                        @if($task->is_done)
                            <span class="badge-status badge-done">✓ Selesai</span>
                        @elseif($isLate)
                            <span class="badge-status badge-late">⚠ Terlambat</span>
                        @else
                            <span class="badge-status badge-pending">● Berjalan</span>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                @if($task->description)
                    <p class="task-desc mb-2">{{ $task->description }}</p>
                @endif

                <!-- Meta -->
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @if($deadlineFormatted)
                        <span class="task-meta">
                            <i class="fa-regular fa-calendar"></i>
                            {{ $deadlineFormatted }}
                            @if(!$task->is_done && $daysLeft !== null)
                                @if($daysLeft < 0)
                                    <span style="color:#ef4444;font-weight:600;">({{ abs((int)$daysLeft) }} hari lalu)</span>
                                @elseif($daysLeft == 0)
                                    <span style="color:#f59e0b;font-weight:600;">(Hari ini)</span>
                                @elseif($daysLeft <= 3)
                                    <span style="color:#f59e0b;font-weight:600;">({{ (int)$daysLeft }} hari lagi)</span>
                                @else
                                    <span style="color:var(--text-secondary);">({{ (int)$daysLeft }} hari lagi)</span>
                                @endif
                            @endif
                        </span>
                    @endif
                    <span class="task-meta">
                        <i class="fa-solid fa-flag"></i>
                        {{ $priorityLabel }}
                    </span>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2">
                    <!-- Toggle Done -->
                    <form action="/tasks/{{ $task->id }}/toggle" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit"
                            class="btn btn-sm {{ $task->is_done ? 'btn-outline-secondary' : 'btn-success' }}"
                            title="{{ $task->is_done ? 'Buka kembali' : 'Tandai selesai' }}"
                            style="border-radius:8px;padding:6px 10px;">
                            <i class="fa-solid {{ $task->is_done ? 'fa-rotate-left' : 'fa-check' }}"></i>
                        </button>
                    </form>

                    <a href="/tasks/{{ $task->id }}/edit"
                        class="btn btn-sm btn-warning flex-grow-1"
                        style="border-radius:8px;">
                        <i class="fa-solid fa-pen me-1"></i> Edit
                    </a>

                    <button type="button"
                        class="btn btn-sm btn-danger flex-shrink-0"
                        data-delete-id="{{ $task->id }}"
                        data-delete-title="{{ $task->title }}"
                        style="border-radius:8px;padding:6px 10px;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="fa-solid fa-clipboard-list"></i>
            <h5>Belum ada tugas</h5>
            <p>Mulai tambahkan tugas pertamamu sekarang!</p>
            <a href="/tasks/create" class="btn btn-primary mt-2">
                <i class="fa-solid fa-plus me-1"></i> Tambah Tugas
            </a>
        </div>
    </div>
    @endforelse
</div>

@endsection

@section('styles')
<style>
    .filter-btn, .filter-priority {
        background: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--text-secondary);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        padding: 5px 12px;
        transition: all 0.2s;
    }
    .filter-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
    }
    .filter-priority.active {
        background: var(--hover-bg);
        color: var(--text-primary);
        font-weight: 600;
    }
</style>
@endsection

@section('scripts')
<script>
    // Search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    // Status filter
    let activeFilter = 'all';
    let activePriority = 'all';

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.dataset.filter;
            applyFilters();
        });
    });

    document.querySelectorAll('.filter-priority').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-priority').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activePriority = this.dataset.priority;
            applyFilters();
        });
    });

    function applyFilters() {
        const keyword = searchInput ? searchInput.value.toLowerCase() : '';
        const items = document.querySelectorAll('.task-item');
        let visible = 0;

        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            const status = item.dataset.status;
            const priority = item.dataset.priority;

            const matchSearch = !keyword || text.includes(keyword);
            const matchFilter = activeFilter === 'all' || status === activeFilter;
            const matchPriority = activePriority === 'all' || priority === activePriority;

            if (matchSearch && matchFilter && matchPriority) {
                item.style.display = '';
                visible++;
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Delete modal
    document.querySelectorAll('[data-delete-id]').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.deleteId;
            const title = this.dataset.deleteTitle;
            document.getElementById('deleteTaskTitle').textContent = title;
            document.getElementById('deleteForm').action = '/tasks/' + id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
</script>
@endsection
