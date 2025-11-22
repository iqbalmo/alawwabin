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

                <label class="block text-sm font-medium leading-6 text-gray-900 mt-4 mb-3">Guru Pengampu (Opsional)</label>
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($gurus as $guru)
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input id="guru_{{ $guru->id }}" name="guru_ids[]" type="checkbox" value="{{ $guru->id }}"
                                       {{ in_array($guru->id, old('guru_ids', $mapel->gurus->pluck('id')->toArray())) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-gray-300 text-[#2C5F2D] focus:ring-[#C8963E]">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="guru_{{ $guru->id }}" class="font-medium text-gray-900 select-none cursor-pointer">{{ $guru->nama }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($gurus->isEmpty())
                        <p class="text-sm text-gray-500 italic">Belum ada data guru.</p>
                    @endif
                </div>
                <p class="mt-2 text-xs text-gray-500">Centang guru yang mengajar mata pelajaran ini.</p>
                @error('guru_ids') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                @error('guru_ids.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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