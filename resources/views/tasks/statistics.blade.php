<!DOCTYPE html>
<html>
<head>

    <title>Statistik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @php
        $theme = session('theme', 'light');
    @endphp

    <style>

        body{
            background: {{ $theme == 'dark' ? '#111827' : '#f4f7fb' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
        }

        .card{
            background: {{ $theme == 'dark' ? '#1e293b' : 'white' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
        }

    </style>

</head>
<body>

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <h2 class="mb-4">
            Statistik Tugas
        </h2>

        @php

            $total = $tasks->count();

            $done = $tasks->where('is_done', true)->count();

            $pending = $total - $done;

        @endphp

        <div class="mb-3">

            <h5>Total Tugas</h5>

            <div class="progress">

                <div class="progress-bar bg-primary"
                    style="width:100%">

                    {{ $total }}

                </div>

            </div>

        </div>

        <div class="mb-3">

            <h5>Tugas Selesai</h5>

            <div class="progress">

                <div class="progress-bar bg-success"
                    style="width:{{ $total ? ($done/$total)*100 : 0 }}%">

                    {{ $done }}

                </div>

            </div>

        </div>

        <div class="mb-3">

            <h5>Belum Selesai</h5>

            <div class="progress">

                <div class="progress-bar bg-danger"
                    style="width:{{ $total ? ($pending/$total)*100 : 0 }}%">

                    {{ $pending }}

                </div>

            </div>

        </div>

        <a href="javascript:history.back()"
            class="btn btn-primary mt-3">

            Kembali

        </a>

    </div>

</div>

</body>
</html>