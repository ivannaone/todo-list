<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tugas</title>

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

    </style>

</head>
<body>

<div class="container mt-5">

    <h2>Tambah Tugas</h2>

    <form action="/tasks" method="POST">

        @csrf

        <div class="mb-3">
            <label>Judul</label>

            <input type="text"
                   name="title"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>

            <textarea name="description"
                      class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Deadline</label>

            <input type="date"
                   name="deadline"
                   class="form-control">
        </div>

        <button class="btn btn-primary">
            Simpan
        </button>

    </form>

</div>

</body>
</html>