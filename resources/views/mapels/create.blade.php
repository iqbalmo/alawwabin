@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Mata Pelajaran</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mapels.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" placeholder="Contoh: Matematika" value="{{ old('nama_mapel') }}" required>
        </div>

        <div class="mb-3">
            <label for="guru_id" class="form-label">Guru Pengajar</label>
            <select name="guru_id" id="guru_id" class="form-control">
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('mapels.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
