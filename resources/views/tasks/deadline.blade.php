<!DOCTYPE html>
<html>
<head>

    <title>Deadline</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @php
        $theme = session('theme', 'light');
    @endphp

    <style>

        body{
            background: {{ $theme == 'dark' ? '#111827' : '#f4f7fb' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            font-family: Arial;
        }

        .container-box{
            max-width: 900px;
            margin: 50px auto;
        }

        .task-card{
            background: {{ $theme == 'dark' ? '#1e293b' : 'white' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .deadline{
            color: #ef4444;
        }

    </style>

</head>
<body>

<div class="container-box">

    <h2 class="mb-4">

        <i class="fa-solid fa-clock"></i>

        Deadline Tugas

    </h2>

    @forelse($tasks as $task)

        <div class="task-card">

            <h4>

                {{ $task->title }}

            </h4>

            <p>

                {{ $task->description }}

            </p>

            <div class="deadline">

                Deadline:
                {{ $task->deadline }}

            </div>

        </div>

    @empty

        <div class="alert alert-success">

            Tidak ada tugas terlambat 🎉

        </div>

    @endforelse

    <a href="/tasks" class="btn btn-primary">

        Kembali

    </a>

</div>

</body>
</html>