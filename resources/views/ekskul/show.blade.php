@extends('layouts.app')

@section('title', 'Anggota Ekskul: ' . $ekskul->nama_ekskul)
@section('header-title', 'Manajemen Anggota Ekskul')

@section('content')
    
{{-- 
  Halaman ini sekarang hanya 'shell'.
  Semua logika dan tampilan ditangani oleh komponen Livewire.
  Kita 'pass' variabel $ekskul dari Controller ke dalam komponen.
--}}
<livewire:manage-ekskul-members :ekskul="$ekskul" />

@endsection