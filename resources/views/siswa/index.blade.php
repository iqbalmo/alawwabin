@extends('layouts.app')

@section('title', 'Daftar Siswa | SITU Al-Awwabin')
@section('header-title', 'Daftar Siswa Aktif')

@section('content')

{{-- 
  Halaman ini sekarang hanya bertugas sebagai 'shell' atau 'wrapper'.
  Semua logika pencarian, tabel, dan paginasi
  sekarang ditangani oleh komponen Livewire.
--}}

{{-- 
  Kita tidak perlu lagi me-render <h2>, <form>, <table>, atau {{ $siswa->links() }}
  karena semuanya sudah ada di dalam file 'livewire.search-siswa.blade.php'.
--}}

{{-- Cukup panggil komponen Livewire di sini --}}
<livewire:search-siswa />

@endsection