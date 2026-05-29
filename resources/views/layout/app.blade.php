<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskFlow')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @php $theme = session('theme', 'light'); @endphp

    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-width: 260px;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --body-bg: {{ $theme == 'dark' ? '#0f172a' : '#f1f5f9' }};
            --card-bg: {{ $theme == 'dark' ? '#1e293b' : '#ffffff' }};
            --card-border: {{ $theme == 'dark' ? '#334155' : '#e2e8f0' }};
            --text-primary: {{ $theme == 'dark' ? '#f1f5f9' : '#0f172a' }};
            --text-secondary: {{ $theme == 'dark' ? '#94a3b8' : '#64748b' }};
            --input-bg: {{ $theme == 'dark' ? '#334155' : '#f8fafc' }};
            --input-border: {{ $theme == 'dark' ? '#475569' : '#cbd5e1' }};
            --hover-bg: {{ $theme == 'dark' ? '#334155' : '#f1f5f9' }};
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            padding: 0;
            z-index: 1000;
            overflow: hidden;
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .sidebar-brand .brand-logo {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white;
            margin-bottom: 10px;
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            font-size: 18px;
            margin: 0;
        }

        .sidebar-brand small {
            color: #64748b;
            font-size: 12px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section-label {
            color: #475569;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 8px 12px 4px;
            margin-top: 8px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            text-decoration: none;
            padding: 11px 14px;
            border-radius: 10px;
            margin-bottom: 2px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            background: rgba(99,102,241,0.15);
            color: #a5b4fc;
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(99,102,241,0.25), rgba(139,92,246,0.15));
            color: #a5b4fc;
            border-left: 3px solid #6366f1;
        }

        .sidebar-nav a .nav-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            background: rgba(255,255,255,0.05);
            flex-shrink: 0;
        }

        .sidebar-nav a.active .nav-icon {
            background: rgba(99,102,241,0.3);
            color: #818cf8;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,0.04);
            transition: background 0.2s;
            cursor: pointer;
        }

        .user-info:hover {
            background: rgba(99,102,241,0.15);
        }

        .user-info:hover .user-name {
            color: #a5b4fc;
        }

        .user-info:hover i {
            color: #a5b4fc !important;
        }

        .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600; font-size: 14px;
            flex-shrink: 0;
        }

        .user-name { color: #e2e8f0; font-size: 13px; font-weight: 600; }
        .user-email { color: #64748b; font-size: 11px; }

        /* ── Main Content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--card-border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title h5 {
            font-weight: 700;
            font-size: 16px;
            margin: 0;
            color: var(--text-primary);
        }

        .topbar-title small {
            color: var(--text-secondary);
            font-size: 12px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 12px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 13px;
        }

        .search-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            padding: 9px 14px 9px 36px;
            border-radius: 10px;
            width: 240px;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }

        .search-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .search-input::placeholder { color: var(--text-secondary); }

        .page-content {
            flex: 1;
            padding: 28px 32px;
        }

        /* ── Buttons ── */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            padding: 9px 18px;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            padding: 9px 18px;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            color: white;
            padding: 9px 18px;
        }

        .btn-warning:hover { color: white; }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            padding: 9px 18px;
        }

        .btn-outline-secondary {
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            border-color: var(--input-border);
            color: var(--text-secondary);
        }

        .btn-outline-secondary:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
            border-color: var(--input-border);
        }

        /* ── Cards ── */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        /* ── Stat Cards ── */
        .stat-card {
            border-radius: 16px;
            padding: 22px;
            color: white;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px; top: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }

        .stat-card .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }

        .stat-card .stat-value {
            font-size: 32px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 13px;
            opacity: 0.85;
        }

        .stat-blue { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .stat-green { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-red { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .stat-orange { background: linear-gradient(135deg, #f59e0b, #d97706); }

        /* ── Task Cards ── */
        .task-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 20px;
            transition: all 0.2s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #6366f1;
        }

        .task-card.done {
            opacity: 0.7;
        }

        .task-card .priority-bar {
            position: absolute;
            top: 0; left: 0;
            width: 4px; height: 100%;
            border-radius: 16px 0 0 16px;
        }

        .priority-high { background: #ef4444; }
        .priority-medium { background: #f59e0b; }
        .priority-low { background: #10b981; }

        .task-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .task-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .task-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 10px;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-done { background: rgba(16,185,129,0.15); color: #10b981; }
        .badge-late { background: rgba(239,68,68,0.15); color: #ef4444; }
        .badge-pending { background: rgba(245,158,11,0.15); color: #f59e0b; }

        /* ── Forms ── */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            background: var(--input-bg);
            border-color: #6366f1;
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .form-control::placeholder { color: var(--text-secondary); }

        textarea.form-control { resize: vertical; min-height: 100px; }

        /* ── Alerts ── */
        .alert-success {
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.3);
            color: #10b981;
            border-radius: 12px;
            font-size: 14px;
        }

        .alert-danger {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #ef4444;
            border-radius: 12px;
            font-size: 14px;
        }

        /* ── Page Header ── */
        .page-header {
            margin-bottom: 24px;
        }

        .page-header h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 13px;
            margin: 4px 0 0;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.4;
        }

        .empty-state h5 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        /* ── Modal ── */
        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            color: var(--text-primary);
        }

        .modal-header {
            border-bottom: 1px solid var(--card-border);
            padding: 20px 24px;
        }

        .modal-body { padding: 24px; }
        .modal-footer {
            border-top: 1px solid var(--card-border);
            padding: 16px 24px;
        }

        /* ── Progress ── */
        .progress {
            background: var(--input-bg);
            border-radius: 10px;
            height: 10px;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }

        /* ── Toast ── */
        .toast-container { z-index: 9999; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
            }
            .page-content {
                padding: 16px;
                padding-bottom: 80px;
            }
            .topbar {
                padding: 12px 16px;
                border-radius: 0;
            }
            .search-input {
                width: 130px;
            }
            /* Bottom Nav */
            .bottom-nav {
                display: flex !important;
            }
        }

        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #0f172a;
            border-top: 1px solid rgba(255,255,255,0.08);
            z-index: 1000;
            padding: 8px 0 12px;
            justify-content: space-around;
            align-items: center;
        }

        .bottom-nav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            color: #64748b;
            text-decoration: none;
            font-size: 10px;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 10px;
            transition: color 0.2s;
            position: relative;
        }

        .bottom-nav a i {
            font-size: 18px;
        }

        .bottom-nav a.active {
            color: #818cf8;
        }

        .bottom-nav a .bnav-badge {
            position: absolute;
            top: 0; right: 6px;
            background: #ef4444;
            color: white;
            font-size: 9px;
            font-weight: 700;
            width: 16px; height: 16px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
    </style>

    @yield('styles')
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <h4>TaskFlow</h4>
        <small>Kelola tugas dengan mudah</small>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <a href="/tasks" class="{{ request()->is('tasks') && !request()->is('tasks/*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-list-check"></i></span>
            Semua Tugas
        </a>

        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
            Dashboard
        </a>

        <div class="nav-section-label">Analitik</div>

        <a href="/deadline" class="{{ request()->is('deadline') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-clock"></i></span>
            Deadline
            @php
                $lateCount = \App\Models\Task::where('deadline', '<', date('Y-m-d'))->where('is_done', false)->count();
            @endphp
            @if($lateCount > 0)
                <span class="badge bg-danger ms-auto" style="font-size:10px;">{{ $lateCount }}</span>
            @endif
        </a>

        <a href="/statistics" class="{{ request()->is('statistics') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span>
            Statistik
        </a>

        <div class="nav-section-label">Akun</div>

        <a href="/settings" class="{{ request()->is('settings') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-gear"></i></span>
            Pengaturan
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="/settings" class="user-info" style="text-decoration:none;" title="Buka Pengaturan">
            <div class="user-avatar">
                {{ strtoupper(substr(session('username', 'U'), 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <div class="user-name">{{ session('username', 'User') }}</div>
                <div class="user-email">{{ session('email', 'user@taskflow.app') }}</div>
            </div>
            <i class="fa-solid fa-gear" style="color:#475569;font-size:13px;flex-shrink:0;"></i>
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="topbar">
        <div class="topbar-title">
            <h5>@yield('page-title', 'TaskFlow')</h5>
            <small>@yield('page-subtitle', '')</small>
        </div>
        <div class="topbar-actions">
            @yield('topbar-actions')
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Hapus Tugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div style="width:64px;height:64px;background:rgba(239,68,68,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <i class="fa-solid fa-trash" style="color:#ef4444;font-size:24px;"></i>
                </div>
                <h6 class="fw-bold mb-2">Yakin ingin menghapus?</h6>
                <p class="text-secondary" style="font-size:13px;">Tugas "<span id="deleteTaskTitle" class="fw-semibold"></span>" akan dihapus permanen.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navigation (Mobile) -->
<nav class="bottom-nav">
    @php $lateCount = \App\Models\Task::where('deadline', '<', date('Y-m-d'))->where('is_done', false)->count(); @endphp
    <a href="/tasks" class="{{ request()->is('tasks') && !request()->is('tasks/*') ? 'active' : '' }}">
        <i class="fa-solid fa-list-check"></i>
        Tugas
    </a>
    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>
    <a href="/tasks/create" style="color:#818cf8;">
        <div style="width:44px;height:44px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:2px;box-shadow:0 4px 12px rgba(99,102,241,0.5);">
            <i class="fa-solid fa-plus" style="font-size:18px;color:white;"></i>
        </div>
        Tambah
    </a>
    <a href="/deadline" class="{{ request()->is('deadline') ? 'active' : '' }}" style="position:relative;">
        <i class="fa-solid fa-clock"></i>
        @if($lateCount > 0)
            <span class="bnav-badge">{{ $lateCount }}</span>
        @endif
        Deadline
    </a>
    <a href="/settings" class="{{ request()->is('settings') ? 'active' : '' }}">
        <i class="fa-solid fa-gear"></i>
        Setelan
    </a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
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

    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
    }
</script>

@yield('scripts')
</body>
</html>
