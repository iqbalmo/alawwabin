@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Guru</h2>

    <form action="{{ route('guru.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Guru</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control" required>
        </div>


        <div class="mb-3">
            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
            <select class="form-control" id="mapel_id" name="mapel_id" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" required>
        </div>



        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
