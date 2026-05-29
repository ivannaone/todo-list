@extends('layout.app')

@section('title', 'Pengaturan — TaskFlow')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola profil dan preferensi tampilan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        <!-- Profile Card -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="font-size:14px;">
                    <i class="fa-solid fa-user me-2" style="color:#6366f1;"></i>
                    Profil Pengguna
                </h6>

                <!-- Avatar Preview -->
                <div class="d-flex align-items-center gap-3 mb-4 p-3"
                     style="background:var(--input-bg);border-radius:12px;">
                    <div id="avatarPreview"
                         style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;color:white;font-size:22px;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr(session('username', 'U'), 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:600;color:var(--text-primary);" id="namePreview">
                            {{ session('username', 'User') }}
                        </div>
                        <div style="font-size:12px;color:var(--text-secondary);" id="emailPreview">
                            {{ session('email', 'user@taskflow.app') }}
                        </div>
                    </div>
                </div>

                <form action="/settings/save" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fa-solid fa-user me-1" style="color:#6366f1;"></i>
                            Nama Pengguna <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="username"
                               id="usernameInput"
                               class="form-control @error('username') is-invalid @enderror"
                               value="{{ session('username') }}"
                               placeholder="Masukkan nama kamu">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fa-solid fa-envelope me-1" style="color:#6366f1;"></i>
                            Email
                        </label>
                        <input type="email"
                               name="email"
                               id="emailInput"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ session('email') }}"
                               placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fa-solid fa-palette me-1" style="color:#6366f1;"></i>
                            Tema Tampilan
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="theme-option {{ session('theme', 'light') == 'light' ? 'selected' : '' }}"
                                       style="cursor:pointer;display:block;padding:14px;border:2px solid {{ session('theme', 'light') == 'light' ? '#6366f1' : 'var(--input-border)' }};border-radius:12px;text-align:center;transition:all 0.2s;">
                                    <input type="radio" name="theme" value="light" class="d-none"
                                           {{ session('theme', 'light') == 'light' ? 'checked' : '' }}>
                                    <div style="font-size:24px;margin-bottom:4px;">☀️</div>
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);">Light Mode</div>
                                    <div style="font-size:11px;color:var(--text-secondary);">Terang & bersih</div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="theme-option {{ session('theme') == 'dark' ? 'selected' : '' }}"
                                       style="cursor:pointer;display:block;padding:14px;border:2px solid {{ session('theme') == 'dark' ? '#6366f1' : 'var(--input-border)' }};border-radius:12px;text-align:center;transition:all 0.2s;">
                                    <input type="radio" name="theme" value="dark" class="d-none"
                                           {{ session('theme') == 'dark' ? 'checked' : '' }}>
                                    <div style="font-size:24px;margin-bottom:4px;">🌙</div>
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);">Dark Mode</div>
                                    <div style="font-size:11px;color:var(--text-secondary);">Gelap & nyaman</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // Live preview
    const usernameInput = document.getElementById('usernameInput');
    const emailInput = document.getElementById('emailInput');
    const namePreview = document.getElementById('namePreview');
    const emailPreview = document.getElementById('emailPreview');
    const avatarPreview = document.getElementById('avatarPreview');

    usernameInput.addEventListener('input', function() {
        namePreview.textContent = this.value || 'User';
        avatarPreview.textContent = (this.value || 'U').charAt(0).toUpperCase();
    });

    emailInput.addEventListener('input', function() {
        emailPreview.textContent = this.value || 'user@taskflow.app';
    });

    // Theme selector
    document.querySelectorAll('.theme-option').forEach(label => {
        label.addEventListener('click', function() {
            document.querySelectorAll('.theme-option').forEach(l => {
                l.style.borderColor = 'var(--input-border)';
            });
            this.style.borderColor = '#6366f1';
        });
    });
</script>
@endsection
