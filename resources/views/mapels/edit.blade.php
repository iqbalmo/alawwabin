@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran | SITU Al-Awwabin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#2C5F2D]">Edit Mata Pelajaran</h1>
        <p class="mt-1 text-sm text-gray-600">Perbarui informasi mata pelajaran.</p>
    </div>

    <form action="{{ route('mapels.update', $mapel->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-[#2C5F2D]">Informasi Mapel</h3>
            </div>
            
            <div class="p-6">
                <label for="nama_mapel" class="block text-sm font-medium leading-6 text-gray-900">Nama Mata Pelajaran <span class="text-red-600">*</span></label>
                <div class="mt-2">
                    <input type="text" name="nama_mapel" id="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}" placeholder="Contoh: Matematika" required
                           class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    @error('nama_mapel') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-x-4">
            <a href="{{ route('mapels.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-[#2C5F2D] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
                Update Mapel
            </button>
        </div>
    </form>
</div>
@endsection