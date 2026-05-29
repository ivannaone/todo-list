@extends('layout.app')

@section('title', 'Tambah Tugas — TaskFlow')
@section('page-title', 'Tambah Tugas')
@section('page-subtitle', 'Buat tugas baru untuk dikerjakan')

@section('topbar-actions')
    <a href="/tasks" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form action="/tasks" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fa-solid fa-heading me-1" style="color:#6366f1;"></i>
                            Judul Tugas <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Contoh: Buat laporan mingguan"
                               value="{{ old('title') }}"
                               autofocus>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fa-solid fa-align-left me-1" style="color:#6366f1;"></i>
                            Deskripsi
                        </label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Tambahkan detail tugas (opsional)..."
                                  rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fa-regular fa-calendar me-1" style="color:#6366f1;"></i>
                                Deadline
                            </label>
                            <input type="date"
                                   name="deadline"
                                   class="form-control @error('deadline') is-invalid @enderror"
                                   value="{{ old('deadline') }}"
                                   min="{{ date('Y-m-d') }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fa-solid fa-flag me-1" style="color:#6366f1;"></i>
                                Prioritas <span class="text-danger">*</span>
                            </label>
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                                <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>🟢 Rendah</option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
                                <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>🔴 Tinggi</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Tugas
                        </button>
                        <a href="/tasks" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
