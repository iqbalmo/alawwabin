@extends('layouts.app')

@section('title', 'Tambah Jadwal Baru | SITU Al-Awwabin')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-[#2C5F2D] mb-6">Tambah Jadwal Pelajaran</h2>

    <form action="{{ route('jadwal.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Pesan Error Validasi --}}
        @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-500/20 p-4 border border-red-500/30">
            <div class="ml-3">
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

        {{-- Grup Form: Hari --}}
        <div>
            <label for="hari" class="block text-sm font-medium text-gray-700 mb-1">Hari <span class="text-red-600">*</span></label>
            {{-- --- UBAH DARI INPUT MENJADI SELECT --- --}}
            <select name="hari" id="hari" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Hari --</option>
                <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
            </select>
            @error('hari') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Grup Form: Jam Mulai & Selesai --}}
        <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
            <div>
                <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-600">*</span></label>
                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                @error('jam_mulai') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai <span class="text-red-600">*</span></label>
                <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                @error('jam_selesai') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Grup Form: Kelas --}}
        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-600">*</span></label>
            <select name="kelas_id" id="kelas_id" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->tingkat }} - {{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            @error('kelas_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Grup Form: Mata Pelajaran --}}
        <div>
            <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran <span class="text-red-600">*</span></label>
            <select name="mapel_id" id="mapel_id" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($mapels as $mapel)
                <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>
            @error('mapel_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Grup Form: Guru --}}
        <div>
            <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-1">Guru Pengampu <span class="text-red-600">*</span></label>
            <select name="guru_id" id="guru_id" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Guru --</option>
                @foreach($gurus as $guru)
                <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                @endforeach
            </select>
            @error('guru_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 pt-4">
            <button type="submit" class="bg-[#C8963E] hover:bg-[#b58937] text-[#333333] font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                Simpan
            </button>
            <a href="{{ route('jadwal.index') }}" class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
               Batal
            </a>
        </div>
    </form>
</div>
@endsection