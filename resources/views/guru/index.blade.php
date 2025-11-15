@extends('layouts.app')

@section('title', 'Daftar Guru | SITU Al-Awwabin')
@section('header-title', 'Daftar Guru')

@section('content')

{{-- 
  Halaman ini sekarang hanya bertugas sebagai 'shell' atau 'wrapper'.
  Semua logika pencarian, tabel, dan paginasi
  sekarang ditangani oleh komponen Livewire baru.
--}}

<livewire:search-guru />

@endsection