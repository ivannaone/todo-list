<!DOCTYPE html>
<html>
<head>
    <title>Modern To-Do List</title>

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
            font-family: Arial, sans-serif;
        }

        .sidebar{
            width: 230px;
            height: 100vh;
            background: {{ $theme == 'dark' ? '#0f172a' : '#111827' }};
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px;
        }

        .sidebar h3{
            color: white;
            margin-bottom: 35px;
            font-weight: bold;
        }

        .sidebar a{
            display: block;
            color: #d1d5db;
            text-decoration: none;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover{
            background: #1f2937;
            color: white;
            transform: translateX(5px);
        }

        .main{
            margin-left: 230px;
            padding: 30px;
        }

        .navbar-custom{
            background: {{ $theme == 'dark' ? '#1e293b' : 'white' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            padding: 18px 25px;
            border-radius: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .search-box{
            border: none;
            background: {{ $theme == 'dark' ? '#334155' : '#f3f4f6' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            padding: 10px 15px;
            border-radius: 10px;
            width: 250px;
            outline: none;
        }

        .task-card{
            background: {{ $theme == 'dark' ? '#1e293b' : 'white' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: 0.3s;
            height: 100%;
        }

        .task-card:hover{
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .task-title{
            font-size: 20px;
            font-weight: bold;
            color: {{ $theme == 'dark' ? 'white' : '#111827' }};
        }

        .deadline{
            color: {{ $theme == 'dark' ? '#cbd5e1' : '#6b7280' }};
            font-size: 14px;
        }

        .badge-status{
            padding: 8px 12px;
            border-radius: 30px;
            font-size: 13px;
        }

        .btn-modern{
            border-radius: 10px;
        }

        .stats-card{
            border-radius: 18px;
            color: white;
            padding: 20px;
            margin-bottom: 25px;
            transition: 0.3s;
        }

        .stats-card:hover{
            transform: scale(1.03);
        }

        .text-muted{
            color: {{ $theme == 'dark' ? '#cbd5e1' : '#6c757d' }} !important;
        }

        .alert-secondary{
            background: {{ $theme == 'dark' ? '#334155' : '#e2e8f0' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            border: none;
        }

    </style>

</head>
<body>

@php

    $today = date('Y-m-d');

    $total = $tasks->count();

    $done = $tasks->where('is_done', true)->count();

    $late = $tasks->filter(function($task) use ($today){
        return !$task->is_done &&
        $task->deadline &&
        $task->deadline < $today;
    })->count();

@endphp

<div class="sidebar">

    <h3>
        <i class="fa-solid fa-layer-group"></i>
        TaskFlow
    </h3>

    <a href="/dashboard">

        <i class="fa-solid fa-house"></i>

        Semua Tugas

    </a>

    <a href="/tasks">

        <i class="fa-solid fa-list-check"></i>

        Dashboard

    </a>

    <a href="/deadline">

        <i class="fa-solid fa-clock"></i>

        Deadline

    </a>

    <a href="/statistics">

        <i class="fa-solid fa-chart-line"></i>

        Statistik

    </a>

    <a href="/settings">

        <i class="fa-solid fa-gear"></i>

        Pengaturan

    </a>

</div>

<div class="main">

    <div class="navbar-custom">

        <div>

            <h4 class="mb-1">
                My To-Do List
            </h4>

            <small class="text-muted">
                Kelola tugas lebih mudah
            </small>

        </div>

        <div class="d-flex align-items-center gap-3">

            <input type="text"
                id="searchInput"
                class="search-box"
                placeholder="Cari tugas...">

            <a href="/tasks/create"
                class="btn btn-primary btn-modern">

                <i class="fa-solid fa-plus"></i>
                Tambah

            </a>

        </div>

    </div>

    <div class="row">

        <div class="col-md-4">

            <div class="stats-card bg-primary">

                <h3>{{ $total }}</h3>
                <p>Total Tugas</p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="stats-card bg-success">

                <h3>{{ $done }}</h3>
                <p>Selesai</p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="stats-card bg-danger">

                <h3>{{ $late }}</h3>
                <p>Terlambat</p>

            </div>

        </div>

    </div>

    <div class="row" id="taskContainer">

        @forelse($tasks as $task)

        <div class="col-md-4 mb-4 task-item">

            <div class="task-card">

                <div class="d-flex justify-content-between align-items-start mb-3">

                    <div>

                        <div class="task-title">

                            {{ $task->title }}

                        </div>

                        <div class="deadline mt-2">

                            <i class="fa-regular fa-calendar"></i>

                            {{ $task->deadline }}

                        </div>

                    </div>

                    @if($task->is_done)

                        <span class="badge bg-success badge-status">

                            Selesai

                        </span>

                    @elseif($task->deadline &&
                            $task->deadline < $today)

                        <span class="badge bg-danger badge-status">

                            Terlambat

                        </span>

                    @else

                        <span class="badge bg-warning text-dark badge-status">

                            Belum

                        </span>

                    @endif

                </div>

                <p class="text-muted">

                    {{ $task->description }}

                </p>

                <div class="d-flex gap-2 mt-4">

                    <a href="/tasks/{{ $task->id }}/edit"
                        class="btn btn-warning w-100 btn-modern">

                        <i class="fa-solid fa-pen"></i>

                        Edit

                    </a>

                    <form action="/tasks/{{ $task->id }}"
                        method="POST"
                        class="w-100">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger w-100 btn-modern">

                            <i class="fa-solid fa-trash"></i>

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-secondary">

                Belum ada tugas

            </div>

        </div>

        @endforelse

    </div>

</div>

<script>

    const searchInput =
    document.getElementById('searchInput');

    searchInput.addEventListener('keyup', function(){

        const keyword =
        this.value.toLowerCase();

        const tasks =
        document.querySelectorAll('.task-item');

        tasks.forEach(task => {

            const text =
            task.innerText.toLowerCase();

            if(text.includes(keyword)){

                task.style.display = 'block';

            }else{

                task.style.display = 'none';

            }

        });

    });

</script>

</body>
</html>