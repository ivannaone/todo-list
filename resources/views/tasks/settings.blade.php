<!DOCTYPE html>
<html>
<head>

    <title>Pengaturan</title>

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

        .form-control{
            background: {{ $theme == 'dark' ? '#334155' : 'white' }};
            color: {{ $theme == 'dark' ? 'white' : 'black' }};
            border-color: #666;
        }

    </style>

</head>
<body>

<div class="container py-5">

    <div class="card shadow border-0 rounded-4 p-4">

        <h2 class="mb-4">

            Pengaturan

        </h2>

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <form action="/settings/save" method="POST">

            @csrf

            <div class="mb-3">

                <label>Nama User</label>

                <input type="text"
                    name="username"
                    class="form-control"
                    value="{{ session('username') }}">

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input type="email"
                    name="email"
                    class="form-control"
                    value="{{ session('email') }}">

            </div>

            <div class="mb-3">

                <label>Tema</label>

                <select name="theme" class="form-control">

                    <option value="light"
                        {{ session('theme') == 'light' ? 'selected' : '' }}>

                        Light Mode

                    </option>

                    <option value="dark"
                        {{ session('theme') == 'dark' ? 'selected' : '' }}>

                        Dark Mode

                    </option>

                </select>

            </div>

            <button class="btn btn-primary">

                Simpan Pengaturan

            </button>

        </form>

    </div>

</div>

</body>
</html>