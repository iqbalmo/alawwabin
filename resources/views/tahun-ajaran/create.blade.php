@extends('layouts.app')

@section('title', 'Tambah Tahun Ajaran | SIAP Al-Awwabin')

@section('content')

    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('tahun-ajaran.index') }}"
                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Tambah Tahun Ajaran</h2>
        <p class="mt-2 text-sm text-gray-600">
            Tambahkan tahun ajaran baru untuk sistem absensi.
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
        <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-[#2C5F2D]">Form Tahun Ajaran</h3>
        </div>

        <form action="{{ route('tahun-ajaran.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{-- Nama Tahun Ajaran --}}
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-900 mb-2">
                    Nama Tahun Ajaran <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    placeholder="Contoh: 2024/2025"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('nama') border-red-300 @enderror">
                @error('nama')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">Format: YYYY/YYYY (contoh: 2024/2025)</p>
            </div>

            {{-- Tanggal Mulai --}}
            <div>
                <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-900 mb-2">
                    Tanggal Mulai <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('tanggal_mulai') border-red-300 @enderror">
                @error('tanggal_mulai')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Selesai --}}
            <div>
                <label for="tanggal_selesai" class="block text-sm font-semibold text-gray-900 mb-2">
                    Tanggal Selesai <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('tanggal_selesai') border-red-300 @enderror">
                @error('tanggal_selesai')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Set as Active --}}
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active') ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                </div>
                <div class="ml-3 text-sm">
                    <label for="is_active" class="font-medium text-gray-900">Aktifkan tahun ajaran ini</label>
                    <p class="text-gray-500">Jika dicentang, tahun ajaran ini akan menjadi tahun ajaran aktif dan tahun
                        ajaran lain akan dinonaktifkan.</p>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('tahun-ajaran.index') }}"
                    class="inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>

@endsection
