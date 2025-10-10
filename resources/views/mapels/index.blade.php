@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Mata Pelajaran</h2>
    <a href="{{ route('mapels.create') }}" class="btn btn-primary mb-3">Tambah Mapel</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Mapel</th>
                
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mapels as $mapel)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mapel->nama_mapel }}</td>
                    
                    <td>
                        <a href="{{ route('mapels.edit', $mapel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('mapels.destroy', $mapel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
