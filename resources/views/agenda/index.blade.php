@extends('layouts.app')

@section('title', 'Agenda Mengajar | SIAP Al-Awwabin')
@section('header-title', 'Agenda Mengajar')

@section('content')
    
    {{-- 
      File ini sekarang hanya bertugas memanggil Komponen Livewire.
      Semua HTML dan logika tampilan ada di:
      - app/Livewire/AgendaDashboard.php
      - resources/views/livewire/agenda-dashboard.blade.php
    --}}
    @livewire('agenda-dashboard')

@endsection
