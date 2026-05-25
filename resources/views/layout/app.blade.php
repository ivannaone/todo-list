<!DOCTYPE html>
<html>
<head>
    <title>To Do App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @php
        $theme = session('theme', 'light');
    @endphp

    <style>

        body{
            background-color: {{ $theme == 'dark' ? '#1e1e1e' : '#f5f5f5' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
        }

        .card,
        .table,
        .list-group-item{
            background-color: {{ $theme == 'dark' ? '#2d2d2d' : 'white' }} !important;
            color: {{ $theme == 'dark' ? 'white' : 'black' }} !important;
        }

        a{
            color: {{ $theme == 'dark' ? '#4da3ff' : '#0d6efd' }};
        }

    </style>

</head>
<body>

<div class="container mt-4">

    @yield('content')

</div>

</body>
</html>