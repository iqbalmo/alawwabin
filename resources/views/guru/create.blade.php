@extends('layouts.app')

@section('title', 'Tambah Guru | SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')
<div class="max-w-2xl mx-auto"> {{-- Membatasi lebar form dan menempatkannya di tengah --}}
    
    <!-- Judul diubah ke Hijau Utama -->
    <h2 class="text-2xl font-bold text-[#2C5F2D] mb-6">Tambah Guru</h2>

    <form action="{{ route('guru.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Grup Form: Nama Guru --}}
        <div>
            <!-- Label diubah ke teks abu-abu gelap -->
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                Nama Guru
            </label>
            <!-- Input diubah ke style light mode, fokus Aksen Emas -->
            <input type="text" name="nama" id="nama" 
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   required>
        </div>

        {{-- Grup Form: NIP --}}
        <div>
            <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">
                NIP
            </label>
            <input type="text" name="nip" id="nip" 
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   required>
        </div>

        {{-- Grup Form: Mata Pelajaran --}}
        <div>
            <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">
                Mata Pelajaran
            </label>
            <select name="mapel_id" id="mapel_id" 
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                    required>
                <!-- Kelas bg-slate-800 dihapus dari option -->
                <option value="">-- Pilih Mata Pelajaran --</option>
                @forelse($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                @empty
                    <option value="" disabled>Belum ada data mapel</option>
                @endforelse
            </select>
        </div>

        {{-- Grup Form: Alamat --}}
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                Alamat
            </label>
            <input type="text" name="alamat" id="alamat" 
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   required>
        </div>

        {{-- Grup Form: Telepon --}}
        <div>
            <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">
                Telepon
            </label>
            <input type="text" name="telepon" id="telepon" 
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   required>
        </div>

        {{-- Grup Form: Gaji Pokok --}}
        <div>
            <label for="gaji_pokok" class="block text-sm font-medium text-gray-700 mb-1">
                Gaji Pokok (Rp)
            </label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" value="{{ old('gaji_pokok') }}"
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   placeholder="Contoh: 3000000"
                   min="0"
                   required>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 pt-4">
            {{-- Tombol Simpan (Primary) diubah ke Aksen Emas --}}
            <button type="submit"
                    class="bg-[#C8963E] hover:bg-[#b58937] text-[#333333] font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                Simpan
            </button>
            
            {{-- Tombol Kembali (Secondary) diubah ke style outline terang --}}
            <a href="{{ route('guru.index') }}" 
               class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
               Kembali
            </a>
        </div>
    </form>
</div>
@endsection