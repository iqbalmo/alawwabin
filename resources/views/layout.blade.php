<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alawwabin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">📘 Alawwabin</a>
        <div>
            <a href="{{ route('kelas.index') }}" class="btn btn-light btn-sm me-2">Kelas</a>
            <a href="{{ route('siswa.index') }}" class="btn btn-light btn-sm me-2">Siswa</a>
            <a href="{{ route('guru.index') }}" class="btn btn-light btn-sm">Guru</a>
            <a href="{{ route('mapels.index') }}" class="btn btn-light btn-sm">Mapel</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>
