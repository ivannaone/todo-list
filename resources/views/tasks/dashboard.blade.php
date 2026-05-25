<!DOCTYPE html>
<html>
<head>

    <title>Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @php
        $theme = session('theme', 'light');
    @endphp

    <style>

        body{
            background: {{ $theme == 'dark' ? '#1e1e1e' : '#f4f7fb' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            font-family:Arial;
        }

        .card-modern{
            border:none;
            border-radius:20px;
            padding:25px;
            color:white;
            transition:0.3s;
        }

        .card-modern:hover{
            transform:translateY(-5px);
        }

        .card{
            background-color: {{ $theme == 'dark' ? '#2d2d2d' : 'white' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
        }

        .text-muted{
            color: {{ $theme == 'dark' ? '#cfcfcf' : '#6c757d' }} !important;
        }

        .border-bottom{
            border-color: {{ $theme == 'dark' ? '#555' : '#dee2e6' }} !important;
        }

    </style>

</head>
<body>

<div class="container py-5">

    <h2 class="mb-4">

        <i class="fa-solid fa-chart-pie"></i>

        Semua Tugas

    </h2>

    @php

        $total = $tasks->count();

        $done = $tasks->where('is_done', true)->count();

        $pending = $total - $done;

    @endphp

    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card-modern bg-primary shadow">

                <h3>{{ $total }}</h3>

                <p>Total Tugas</p>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card-modern bg-success shadow">

                <h3>{{ $done }}</h3>

                <p>Tugas Selesai</p>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card-modern bg-danger shadow">

                <h3>{{ $pending }}</h3>

                <p>Belum Selesai</p>

            </div>

        </div>

    </div>

    <div class="card shadow border-0 rounded-4 p-4 mt-3">

        <h4 class="mb-3">

            Aktivitas Terbaru

        </h4>

        @foreach($tasks->take(5) as $task)

            <div class="d-flex justify-content-between border-bottom py-2">

                <div>

                    <strong>{{ $task->title }}</strong>

                    <br>

                    <small class="text-muted">
                        {{ $task->deadline }}
                    </small>

                </div>

                <div>

                    @if($task->is_done)

                        <span class="badge bg-success">

                            Selesai

                        </span>

                    @else

                        <span class="badge bg-warning text-dark">

                            Pending

                        </span>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

    <a href="/tasks"
        class="btn btn-primary mt-4">

        Lihat Semua Tugas

    </a>

</div>

</body>
</html>