@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Event Baru</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Event --}}
    <form action="{{ route('events.store') }}" method="POST">
       <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Judul Event</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" name="start" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Tanggal Selesai (Opsional)</label>
            <input type="date" name="end" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
    </form>
</div>
@endsection
