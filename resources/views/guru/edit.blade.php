@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Guru</h2>

    <form action="{{ route('guru.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Guru</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $guru->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
            <select class="form-control" id="mapel_id" name="mapel_id" required>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}" {{ $guru->mapel_id == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $guru->alamat }}" required>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $guru->telepon }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
