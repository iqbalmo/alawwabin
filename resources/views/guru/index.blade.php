@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Guru</h2>

    <a href="{{ route('guru.create') }}" class="btn btn-primary mb-3">Tambah Guru</a>

    <table class="table table-bordered table-striped ">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Mata Pelajaran</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gurus as $guru)
            <tr>
                <td>{{ $guru->nama }}</td>
                <td>{{ $guru->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ $guru->alamat }}</td>
                <td>{{ $guru->telepon }}</td>
                <td>
                    <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus guru ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
