@extends('layouts.app')

@section('title', 'Tambah Kelas | SIAP Al-Awwabin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#2C5F2D]">Tambah Kelas Baru</h1>
        <p class="mt-1 text-sm text-gray-600">Tambahkan kelas baru untuk tahun ajaran ini.</p>
    </div>

    <form action="{{ route('kelas.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-[#2C5F2D]">Informasi Kelas</h3>
            </div>
            
            <div class="p-6 grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                
                {{-- Tingkat --}}
                <div class="sm:col-span-2">
                    <label for="tingkat" class="block text-sm font-medium leading-6 text-gray-900">Tingkat <span class="text-red-600">*</span></label>
                    <div class="mt-2">
                        <select id="tingkat" name="tingkat" required
                                class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            <option value="">Pilih</option>
                            <option value="7" {{ old('tingkat') == '7' ? 'selected' : '' }}>VII (7)</option>
                            <option value="8" {{ old('tingkat') == '8' ? 'selected' : '' }}>VIII (8)</option>
                            <option value="9" {{ old('tingkat') == '9' ? 'selected' : '' }}>IX (9)</option>
                        </select>
                        @error('tingkat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Nama Kelas --}}
                <div class="sm:col-span-4">
                    <label for="nama_kelas" class="block text-sm font-medium leading-6 text-gray-900">Nama Kelas / Jurusan <span class="text-red-600">*</span></label>
                    <div class="mt-2">
                        <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas') }}" placeholder="Contoh: A, B, Tahfidz" required
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                        @error('nama_kelas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Wali Kelas --}}
                <div class="sm:col-span-6">
                    <label for="wali_kelas" class="block text-sm font-medium leading-6 text-gray-900">Wali Kelas</label>
                    <div class="mt-2">
                        <select id="wali_kelas" name="wali_kelas" class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('wali_kelas') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }} {{ $guru->gelar ? ', ' . $guru->gelar : '' }}
                                </option>
                            @endforeach
                        </select>
                         @error('wali_kelas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-x-4">
            <a href="{{ route('kelas.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-[#C8963E] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600 transition-all">
                Simpan Kelas
            </button>
        </div>
    </form>
</div>
@endsection
