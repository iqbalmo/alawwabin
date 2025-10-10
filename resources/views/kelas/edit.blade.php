@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Kelas</h1>

    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Kelas --}}
        <div class="mb-3">
            <label for="nama_kelas" class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" 
                value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
        </div>

        {{-- Wali Kelas --}}
        <div class="mb-3">
            <label for="wali_kelas" class="form-label">Wali Kelas</label>
            <select name="wali_kelas" id="wali_kelas" class="form-control" required>
                <option value="">-- Pilih Wali Kelas --</option>
                @foreach($guru as $g)
                    <option value="{{ $g->id }}" 
                        {{ $kelas->wali_kelas == $g->id ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol --}}
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
