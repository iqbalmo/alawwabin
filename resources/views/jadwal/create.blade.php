{{-- resources/views/jadwal/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Jadwal | SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')
<div class="max-w-2xl mx-auto">
    
    <h2 class="text-2xl font-bold text-[#2C5F2D] mb-6">Tambah Jadwal Baru</h2>

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
                    <h3 class="text-sm font-medium text-red-700">Terdapat {{ $errors->count() }} error:</h3>
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

    <form action="{{ route('jadwal.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Grup Form: Hari --}}
        <div>
            <label for="hari" class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
            <select name="hari" id="hari" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Hari --</option>
                <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
            </select>
        </div>

        {{-- Grup Form: Jam Mulai & Selesai (Grid) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" style="color-scheme: light;" required>
            </div>
            <div>
                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" style="color-scheme: light;" required>
            </div>
        </div>

        {{-- Grup Form: Mata Pelajaran --}}
        <div>
            <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <select name="mapel_id" id="mapel_id" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach ($mapels as $mapel)
                    <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>
        </div>

        {{-- Grup Form: Guru --}}
        <div>
            <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-1">Guru Pengajar</label>
            <select name="guru_id" id="guru_id" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Grup Form: Kelas --}}
        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 pt-4">
            <button type="submit" class="bg-[#C8963E] hover:bg-[#b58937] text-[#333333] font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                Simpan
            </button>
            <a href="{{ route('jadwal.index') }}" class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
               Kembali
            </a>
        </div>
    </form>
</div>
@endsection