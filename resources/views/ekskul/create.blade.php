@extends('layouts.app')

@section('title', 'Tambah Ekstrakurikuler Baru | SITU Al-Awwabin')
@section('header-title', 'Tambah Ekstrakurikuler')

@section('content')
<form action="{{ route('ekskul.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 md:p-8 max-w-2xl mx-auto">
    @csrf
    <div class="space-y-8">
        
        <div>
            <label for="nama_ekskul" class="block text-sm font-medium leading-6 text-gray-900">Nama Ekstrakurikuler <span class="text-red-600">*</span></label>
            <div class="mt-2">
                <input type="text" name="nama_ekskul" id="nama_ekskul" value="{{ old('nama_ekskul') }}" required
                       class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('nama_ekskul') border-red-500 @enderror"
                       placeholder="Contoh: Pramuka, PMR, Futsal">
            </div>
            @error('nama_ekskul') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="guru_id" class="block text-sm font-medium leading-6 text-gray-900">Guru Pembina (Opsional)</label>
            <div class="mt-2">
                <select id="guru_id" name="guru_id"
                        class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    <option value="">-- Pilih Guru Pembina --</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="deskripsi" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi (Opsional)</label>
            <div class="mt-2">
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                          placeholder="Jelaskan sedikit tentang kegiatan ini...">{{ old('deskripsi') }}</textarea>
            </div>
        </div>

    </div>

    <!-- Tombol Aksi -->
    <div class="mt-8 flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
        <a href="{{ route('ekskul.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
        <button type="submit"
                class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
            Simpan
        </button>
    </div>
</form>
@endsection