@extends('layouts.app')

@section('title', 'Tambah Kelas | SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')
{{-- Wrapper 'bg-slate-800' dihapus agar konsisten --}}
<div class="max-w-2xl mx-auto"> 
    
    <!-- Judul diubah ke Hijau Utama -->
    <h2 class="text-2xl font-bold text-[#2C5F2D] mb-6">Tambah Kelas Baru</h2>

    {{-- Notifikasi Error (disesuaikan untuk tema terang) --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-500/20 p-4 border border-red-500/30">
            <div class="ml-3">
                <!-- Teks diubah ke warna merah gelap -->
                <h3 class="text-sm font-medium text-red-700">Terdapat error pada input Anda:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul role="list" class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('kelas.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Grup Form: Tingkat dan Nama Kelas (digabung) --}}
        <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
            {{-- Dropdown untuk Tingkat Kelas --}}
            <div class="sm:col-span-2">
                <!-- Label diubah ke teks abu-abu gelap -->
                <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                <!-- Select diubah ke style light mode -->
                <select name="tingkat" id="tingkat" 
                        class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm"
                        required>
                    <option value="">Pilih Tingkat</option>
                    <option value="7" {{ old('tingkat') == '7' ? 'selected' : '' }}>VII (7)</option>
                    <option value="8" {{ old('tingkat') == '8' ? 'selected' : '' }}>VIII (8)</option>
                    <option value="9" {{ old('tingkat') == '9' ? 'selected' : '' }}>IX (9)</option>
                </select>
            </div>

            {{-- Text Field untuk Nama/Jurusan --}}
            <div class="sm:col-span-4">
                <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <!-- Input diubah ke style light mode -->
                <input type="text" name="nama_kelas" id="nama_kelas" 
                       class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                       placeholder="Contoh: A, B, .." value="{{ old('nama_kelas') }}" required>
            </div>
        </div>

        {{-- Grup Form: Wali Kelas --}}
        <div>
            <label for="wali_kelas" class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas (Opsional)</label>
            <select name="wali_kelas" id="wali_kelas" 
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm">
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 pt-4">
            <!-- Tombol Simpan (Primary) diubah ke Aksen Emas -->
            <button type="submit" class="bg-[#C8963E] hover:bg-[#b58937] text-[#333333] font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                Simpan
            </button>
            <!-- Tombol Kembali (Secondary) diubah ke style outline terang -->
            <a href="{{ route('kelas.index') }}" class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
               Batal
            </a>
        </div>
    </form>
</div>
@endsection