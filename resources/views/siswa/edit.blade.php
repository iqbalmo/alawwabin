@extends('layouts.app')

@section('title', 'Edit Data Siswa - SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')
<div class="max-w-2xl mx-auto"> {{-- Wrapper form --}}
    
    <h2 class="text-2xl font-bold text-[#2C5F2D] mb-6">Edit Siswa</h2>

    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT') {{-- Penting untuk metode update --}}
        
        {{-- Grup Form: Nama --}}
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                Nama
            </label>
            <input type="text" name="nama" id="nama" 
                   value="{{ old('nama', $siswa->nama) }}" {{-- Menampilkan data lama atau data dari database --}}
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   required>
        </div>

        {{-- Grup Form: NIS --}}
        <div>
            <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">
                NIS
            </label>
            <input type="text" name="nis" id="nis" 
                   value="{{ old('nis', $siswa->nis) }}"
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                   required>
        </div>

        {{-- Grup Form: Tanggal Lahir --}}
        <div>
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Lahir
            </label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                   value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                   class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm"
                   style="color-scheme: light;">
        </div>

        {{-- Grup Form: Kelas --}}
        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">
                Kelas
            </label>
            <select name="kelas_id" id="kelas_id" 
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" 
                    required>
                <option value="">-- Pilih Kelas --</option>
                @forelse($kelas as $k)
                    {{-- Logika 'selected' untuk menampilkan data yang tersimpan --}}
                    <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @empty
                    <option value="" disabled>Belum ada data kelas</option>
                @endforelse
            </select>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 pt-4">
            {{-- Tombol Update (Primary) diubah ke Aksen Emas --}}
            <button type="submit"
                    class="bg-[#C8963E] hover:bg-[#b58937] text-[#333333] font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                Update
            </button>
            
            {{-- Tombol Kembali (Secondary) diubah ke style outline terang --}}
            <a href="{{ route('siswa.index') }}" 
               class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
               Kembali
            </a>
        </div>
    </form>
</div>
@endsection