@extends('layouts.app')

@section('content')
<h2>Edit Siswa</h2>

<form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" value="{{ $siswa->nama }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>NIS</label>
        <input type="text" name="nis" value="{{ $siswa->nis }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ $siswa->tanggal_lahir }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Kelas</label>
        <select name="kelas_id" class="form-control" required>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
