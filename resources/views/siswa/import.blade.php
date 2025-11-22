@extends('layouts.app')

@section('title', 'Import Data Siswa')
@section('header-title', 'Import Data Siswa dari Excel')

@section('content')

{{-- 
  Halaman ini hanya 'shell'.
  Semua logika (upload, mapping, proses)
  ditangani oleh komponen Livewire di bawah ini.
--}}
<livewire:siswa-importer />

@endsection
