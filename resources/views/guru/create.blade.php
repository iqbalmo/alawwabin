@extends('layouts.app')

@section('title', 'Tambah Guru Baru')

@section('content')
<form action="{{ route('guru.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 md:p-8">
    @csrf
    <div class="space-y-12">

        <!-- Header Form -->
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Formulir Guru Baru</h2>
            <p class="mt-2 text-sm text-gray-600">Isi data guru dengan lengkap.</p>
        </div>

        <!-- BAGIAN 1: DATA PRIBADI GURU -->
        <div class="border-b border-gray-900/10 pb-12">
            <h3 class="text-lg font-semibold leading-7 text-gray-900">1. Data Pribadi</h3>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">

                <div class="md:col-span-3">
                    <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap <span class="text-red-600">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('nama') border-red-500 @enderror">
                    @error('nama') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                
                <div class="md:col-span-3">
                    <label for="nip" class="block text-sm font-medium leading-6 text-gray-900">NIP</label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('nip') border-red-500 @enderror">
                    @error('nip') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                </div>

                <div class="md:col-span-2">
                    <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                </div>
                
                <div class="md:col-span-2">
                    <label for="jenis_kelamin" class="block text-sm font-medium leading-6 text-gray-900">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                
                <div class="md:col-span-6">
                    <label for="alamat" class="block text-sm font-medium leading-6 text-gray-900">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" 
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('alamat') }}</textarea>
                </div>

                <div class="md:col-span-3">
                    <label for="telepon" class="block text-sm font-medium leading-6 text-gray-900">No. Telepon/HP</label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                </div>
            </div>
        </div>
        
        <!-- BAGIAN 2: DATA KEPEGAWAIAN & PENDIDIKAN -->
        <div class="border-b border-gray-900/10 pb-12">
            <h3 class="text-lg font-semibold leading-7 text-gray-900">2. Data Kepegawaian & Pendidikan</h3>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">

                <div class="md:col-span-3">
                    <label for="jabatan" class="block text-sm font-medium leading-6 text-gray-900">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                </div>

                <div class="md:col-span-3">
                    <label for="mapel_id" class="block text-sm font-medium leading-6 text-gray-900">Mata Pelajaran Utama</label>
                    <select id="mapel_id" name="mapel_id" class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        <option value="">-- Tidak Mengampu Mapel Utama --</option>
                        @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="md:col-span-3">
                    <label for="status_kepegawaian" class="block text-sm font-medium leading-6 text-gray-900">Status Kepegawaian</label>
                    <select id="status_kepegawaian" name="status_kepegawaian" class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        <option value="">-- Pilih Status --</option>
                        <option value="PNS" {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="Swasta" {{ old('status_kepegawaian') == 'Swasta' ? 'selected' : '' }}>Swasta/Honorer</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label for="tahun_mulai_bekerja" class="block text-sm font-medium leading-6 text-gray-900">Tahun Mulai Bekerja</label>
                    <input type="text" name="tahun_mulai_bekerja" id="tahun_mulai_bekerja" value="{{ old('tahun_mulai_bekerja') }}" placeholder="Contoh: 2010"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                </div>

                <div class="md:col-span-full"><h4 class="text-md font-medium text-gray-800 mt-6">Pendidikan Terakhir</h4></div>

                <div class="md:col-span-3">
                    <label for="pend_terakhir_univ" class="block text-sm font-medium leading-6 text-gray-900">Perguruan Tinggi</label>
                    <input type="text" name="pend_terakhir_univ" id="pend_terakhir_univ" value="{{ old('pend_terakhir_univ') }}"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                </div>

                <div class="md:col-span-2">
                    <label for="pend_terakhir_jurusan" class="block text-sm font-medium leading-6 text-gray-900">Jurusan</label>
                    <input type="text" name="pend_terakhir_jurusan" id="pend_terakhir_jurusan" value="{{ old('pend_terakhir_jurusan') }}"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                </div>

                <div class="md:col-span-1">
                    <label for="pend_terakhir_tahun" class="block text-sm font-medium leading-6 text-gray-900">Tahun Lulus</label>
                    <input type="text" name="pend_terakhir_tahun" id="pend_terakhir_tahun" value="{{ old('pend_terakhir_tahun') }}" placeholder="Contoh: 2008"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('guru.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
            Batal
        </a>
        <button type="submit"
                class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
            Simpan Data Guru
        </button>
    </div>
</form>
@endsection