<!DOCTYPE html>
<html>
<head>

    <title>Edit Tugas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @php
        $theme = session('theme', 'light');
    @endphp

    <style>

        body{
            background-color: {{ $theme == 'dark' ? '#1e1e1e' : 'white' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
        }

        .form-control,
        textarea{
            background-color: {{ $theme == 'dark' ? '#2d2d2d' : 'white' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            border-color: #666;
        }

        .form-check-input{
            background-color: {{ $theme == 'dark' ? '#2d2d2d' : 'white' }};
            border-color: #666;
        }

    </style>

</head>
<body>

<div class="container mt-5">

    <h2>Edit Tugas</h2>

    <form action="/tasks/{{ $task->id }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label>Judul</label>

            <input type="text"
                name="title"
                class="form-control"
                value="{{ $task->title }}">

        </div>

        <div class="mb-3">

            <label>Deskripsi</label>

            <textarea name="description"
                class="form-control">{{ $task->description }}</textarea>

        </div>

        <div class="mb-3">

            <label>Deadline</label>

            <input type="date"
                name="deadline"
                class="form-control"
                value="{{ $task->deadline }}">

        </div>

        <div class="form-check mb-3">

            <input type="checkbox"
                name="is_done"
                class="form-check-input"
                {{ $task->is_done ? 'checked' : '' }}>

            <label class="form-check-label">

                Selesai

            </label>

        </div>

        <button class="btn btn-success">

            Update

        </button>

    </form>

</div>

</body>
</html>