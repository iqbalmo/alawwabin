<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alawwabin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">Alawwabin</a>
    <div class="collapse navbar-collapse">
     <ul class="navbar-nav me-auto">
    @auth
        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswa.index') }}">Siswa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('guru.index') }}">Guru</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kelas.index') }}">Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('mapels.index') }}">Mata Pelajaran</a>
        </li>
    @endauth
</ul>

<ul class="navbar-nav ms-auto">
    @auth
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    @else
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
    @endauth
</ul>

    </div>
  </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
