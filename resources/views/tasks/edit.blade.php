@extends('layout.app')

@section('title', 'Edit Tugas — TaskFlow')
@section('page-title', 'Edit Tugas')
@section('page-subtitle', 'Perbarui informasi tugas')

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
                <form action="/tasks/{{ $task->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fa-solid fa-heading me-1" style="color:#6366f1;"></i>
                            Judul Tugas <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $task->title) }}"
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
                                  rows="4">{{ old('description', $task->description) }}</textarea>
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
                                   value="{{ old('deadline', $task->deadline) }}">
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
                                <option value="low"    {{ old('priority', $task->priority) == 'low'    ? 'selected' : '' }}>🟢 Rendah</option>
                                <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
                                <option value="high"   {{ old('priority', $task->priority) == 'high'   ? 'selected' : '' }}>🔴 Tinggi</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check" style="padding:14px 16px;background:var(--input-bg);border:1px solid var(--input-border);border-radius:10px;">
                            <input type="checkbox"
                                   name="is_done"
                                   class="form-check-input"
                                   id="isDone"
                                   {{ $task->is_done ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="isDone" style="font-size:14px;">
                                <i class="fa-solid fa-circle-check me-1" style="color:#10b981;"></i>
                                Tandai sebagai selesai
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-grow-1">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                        <a href="/tasks" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
