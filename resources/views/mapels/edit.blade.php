@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran - SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')
{{-- Wrapper 'bg-slate-800' dihapus agar konsisten --}}
<div class="max-w-2xl mx-auto"> 
    
    <!-- Judul diubah ke Hijau Utama -->
    <h2 class="text-2xl font-bold text-[#2C5F2D] mb-6">Edit Mata Pelajaran</h2>

    {{-- Blok Error Validasi (disesuaikan untuk tema terang) --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-500/20 p-4 border border-red-500/30">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <!-- Teks diubah ke warna merah gelap -->
                    <h3 class="text-sm font-medium text-red-700">Terdapat {{ $errors->count() }} error pada input Anda:</h3>
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

    <form action="{{ route('mapels.update', $mapel->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Grup Form: Nama Mata Pelajaran --}}
        <div>
            <!-- Label diubah ke teks abu-abu gelap -->
            <label for="nama_mapel" class="block text-sm font-medium text-gray-700 mb-1">
                Nama Mata Pelajaran
            </label>
            <!-- Input diubah ke style light mode, fokus Aksen Emas -->
            <input type="text" name="nama_mapel" id="nama_mapel" 
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   value="{{ old('nama_mapel', $mapel->nama_mapel) }}" required>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 pt-4">
            {{-- Tombol Update (Primary) diubah ke Aksen Emas --}}
            <button type="submit"
                    class="bg-[#C8963E] hover:bg-[#b58937] text-[#333333] font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                Update
            </button>
            
            {{-- Tombol Batal (Secondary) diubah ke style outline terang --}}
            <a href="{{ route('mapels.index') }}" 
               class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
               Batal
            </a>
        </div>
    </form>
</div>
@endsection