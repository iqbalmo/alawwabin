@extends('layouts.app')

@section('title', 'Edit Guru | SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')
    {{-- Wrapper 'bg-slate-800' dihapus agar konsisten dengan form lain --}}
    <div class="max-w-2xl mx-auto">

        <!-- Judul diubah ke Hijau Utama -->
        <h2 class="text-2xl font-bold text-[#2C5F2D] mb-6">Edit Data Guru</h2>

        {{-- Blok Error Validasi (disesuaikan untuk tema terang) --}}
        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-500/20 p-4 border border-red-500/30">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
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

        <form action="{{ route('guru.update', $guru->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Grup Form: Nama Guru --}}
            <div>
                <!-- Label diubah ke teks abu-abu gelap -->
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Guru</label>
                <!-- Input diubah ke style light mode -->
                <input type="text" name="nama" id="nama"
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm"
                    value="{{ old('nama', $guru->nama) }}" required>
            </div>

            {{-- Grup Form: NIP --}}
            <div>
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" name="nip" id="nip"
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm"
                    value="{{ old('nip', $guru->nip) }}" required>
            </div>

            {{-- Grup Form: Mata Pelajaran --}}
            <div>
                <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran Utama</label>
                <select name="mapel_id" id="mapel_id"
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm">
                    <option value="">-- Tidak Ditentukan --</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}"
                            {{ old('mapel_id', $guru->mapel_id) == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Grup Form: Alamat --}}
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" id="alamat"
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm"
                    value="{{ old('alamat', $guru->alamat) }}" required>
            </div>

            {{-- Grup Form: Telepon --}}
            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <input type="text" name="telepon" id="telepon"
                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm"
                    value="{{ old('telepon', $guru->telepon) }}">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center space-x-4 pt-4">
                <!-- Tombol Update (Primary) diubah ke Aksen Emas -->
                <button type="submit"
                    class="bg-[#C8963E] hover:bg-[#b58937] text-[#333333] font-medium py-2 px-4 rounded-md shadow-sm transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                    Update
                </button>
                <!-- Tombol Kembali (Secondary) diubah ke style outline terang -->
                <a href="{{ route('guru.index') }}"
                    class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
