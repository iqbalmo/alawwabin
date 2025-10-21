@extends('layouts.app')

@section('title', 'Tambah Event | SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')
<div class="max-w-2xl mx-auto"> {{-- Membatasi lebar form dan menempatkannya di tengah --}}
    
    <h2 class="text-2xl font-bold text-[#2C5F2D] mb-6">Tambah Event Baru</h2>

    {{-- Blok Error Validasi (Teks digelapkan) --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-500/20 p-4 border border-red-500/30">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-700">Terjadi {{ $errors->count() }} kesalahan:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Tambah Event --}}
    <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Grup Form: Judul Event --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                Judul Event
            </label>
            <input type="text" name="title" id="title" 
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   required>
        </div>

        {{-- Grup Form: Tanggal Mulai --}}
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Mulai
            </label>
            <input type="date" name="start_date" id="start_date" 
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm"
                   style="color-scheme: light;" {{-- Diubah ke light --}}
                   required>
        </div>

        {{-- Grup Form: Tanggal Selesai --}}
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Selesai (Opsional)
            </label>
            <input type="date" name="end_date" id="end_date" 
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm"
                   style="color-scheme: light;">
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 pt-4">
            {{-- Tombol Simpan (Primary) diubah ke Aksen Emas --}}
            <button type="submit"
                    class="bg-[#C8963E] hover:bg-[#b58937] text-[#333333] font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                Simpan
            </button>
            
            {{-- Tombol Kembali (Secondary) diubah ke style outline terang --}}
            <a href="{{ route('home') }}" {{-- Arahkan kembali ke dashboard --}}
               class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
               Kembali
            </a>
        </div>
    </form>
</div>
@endsection