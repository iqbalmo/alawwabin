@extends('layouts.app')

@section('title', 'Tambah Ekstrakurikuler | SITU Al-Awwabin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#2C5F2D]">Tambah Ekstrakurikuler</h1>
        <p class="mt-1 text-sm text-gray-600">Tambahkan kegiatan ekstrakurikuler baru.</p>
    </div>

    <form action="{{ route('ekskul.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-[#2C5F2D]">Informasi Ekskul</h3>
            </div>
            
            <div class="p-6 space-y-6">
                
                {{-- Nama Ekskul --}}
                <div>
                    <label for="nama_ekskul" class="block text-sm font-medium leading-6 text-gray-900">Nama Ekstrakurikuler <span class="text-red-600">*</span></label>
                    <div class="mt-2">
                        <input type="text" name="nama_ekskul" id="nama_ekskul" value="{{ old('nama_ekskul') }}" placeholder="Contoh: Pramuka, Futsal" required
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                        @error('nama_ekskul') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Guru Pembina --}}
                <div>
                    <label for="guru_id" class="block text-sm font-medium leading-6 text-gray-900">Guru Pembina</label>
                    <div class="mt-2">
                        <select id="guru_id" name="guru_id" class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi</label>
                    <div class="mt-2">
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                  class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6"
                                  placeholder="Jelaskan singkat tentang kegiatan ini...">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-x-4">
            <a href="{{ route('ekskul.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-[#C8963E] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600 transition-all">
                Simpan Ekskul
            </button>
        </div>
    </form>
</div>
@endsection