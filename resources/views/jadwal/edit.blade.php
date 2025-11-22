@extends('layouts.app')

@section('title', 'Edit Jadwal | SIAP Al-Awwabin')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('jadwal.index') }}" class="text-gray-400 hover:text-[#2C5F2D] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-[#2C5F2D]">Edit Jadwal Pelajaran</h2>
        </div>
    </div>

    {{-- Error Messages --}}
    @if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-200 shadow-sm">
        <div class="flex items-start gap-3">
            <svg class="h-5 w-5 text-red-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <div class="flex-1">
                <h3 class="text-sm font-medium text-red-800">Terdapat error pada input Anda:</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
        @csrf
        @method('PUT')

        {{-- Hari --}}
        <div>
            <label for="hari" class="block text-sm font-medium text-gray-700 mb-2">Hari <span class="text-red-600">*</span></label>
            <select name="hari" id="hari" class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm" required>
                <option value="">-- Pilih Hari --</option>
                <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ old('hari', $jadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
            </select>
            @error('hari') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Jam Mulai & Selesai --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai <span class="text-red-600">*</span></label>
                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm" required>
                @error('jam_mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai <span class="text-red-600">*</span></label>
                <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm" required>
                @error('jam_selesai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Kelas --}}
        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas <span class="text-red-600">*</span></label>
            <select name="kelas_id" id="kelas_id" class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ old('kelas_id', $jadwal->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->tingkat }} - {{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            @error('kelas_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Mata Pelajaran --}}
        <div>
            <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran <span class="text-red-600">*</span></label>
            <select name="mapel_id" id="mapel_id" class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($mapels as $mapel)
                <option value="{{ $mapel->id }}" {{ old('mapel_id', $jadwal->mapel_id) == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>
            @error('mapel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Guru --}}
        <div>
            <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-2">Guru Pengampu <span class="text-red-600">*</span></label>
            <select name="guru_id" id="guru_id" class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm" required>
                <option value="">-- Pilih Guru --</option>
                @foreach($gurus as $guru)
                <option value="{{ $guru->id }}" {{ old('guru_id', $jadwal->guru_id) == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                @endforeach
            </select>
            @error('guru_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
                Update Jadwal
            </button>
            <a href="{{ route('jadwal.index') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
