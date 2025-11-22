@extends('layouts.app')

@section('title', 'Tambah Guru Baru | SIAP Al-Awwabin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#2C5F2D]">Tambah Guru Baru</h1>
        <p class="mt-1 text-sm text-gray-600">Lengkapi formulir di bawah ini untuk menambahkan data guru atau staf pengajar baru.</p>
    </div>

    <form action="{{ route('guru.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- BAGIAN 1: DATA PRIBADI --}}
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-[#2C5F2D]">1. Data Pribadi</h3>
            </div>
            <div class="p-6 grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                
                {{-- Nama Lengkap --}}
                <div class="sm:col-span-3">
                    <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap (Tanpa Gelar) <span class="text-red-600">*</span></label>
                    <div class="mt-2">
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                        @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Gelar --}}
                <div class="sm:col-span-3">
                    <label for="gelar" class="block text-sm font-medium leading-6 text-gray-900">Gelar Akademik</label>
                    <div class="mt-2">
                        <input type="text" name="gelar" id="gelar" value="{{ old('gelar') }}" placeholder="Contoh: S.Pd., M.Pd."
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- NIP --}}
                <div class="sm:col-span-3">
                    <label for="nip" class="block text-sm font-medium leading-6 text-gray-900">NIP / NUPTK</label>
                    <div class="mt-2">
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}" required
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                        @error('nip') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Jenis Kelamin --}}
                <div class="sm:col-span-3">
                    <label for="jenis_kelamin" class="block text-sm font-medium leading-6 text-gray-900">Jenis Kelamin</label>
                    <div class="mt-2">
                        <select id="jenis_kelamin" name="jenis_kelamin" class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                {{-- Tempat Lahir --}}
                <div class="sm:col-span-3">
                    <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tempat Lahir</label>
                    <div class="mt-2">
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- Tanggal Lahir --}}
                <div class="sm:col-span-3">
                    <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Lahir</label>
                    <div class="mt-2">
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="sm:col-span-6">
                    <label for="alamat" class="block text-sm font-medium leading-6 text-gray-900">Alamat Lengkap</label>
                    <div class="mt-2">
                        <textarea id="alamat" name="alamat" rows="3" 
                                  class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                {{-- Telepon --}}
                <div class="sm:col-span-3">
                    <label for="telepon" class="block text-sm font-medium leading-6 text-gray-900">No. Telepon / HP</label>
                    <div class="mt-2">
                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}"
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

            </div>
        </div>

        {{-- BAGIAN 2: KEPEGAWAIAN & PENDIDIKAN --}}
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-[#2C5F2D]">2. Data Kepegawaian & Pendidikan</h3>
            </div>
            <div class="p-6 grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                
                {{-- Jabatan --}}
                <div class="sm:col-span-3">
                    <label for="jabatan" class="block text-sm font-medium leading-6 text-gray-900">Jabatan</label>
                    <div class="mt-2">
                        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Guru Mapel, Staf TU"
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- Mapel Pengampu --}}
                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium leading-6 text-gray-900 mb-3">Mata Pelajaran Pengampu</label>
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($mapels as $mapel)
                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input id="mapel_{{ $mapel->id }}" name="mapel_ids[]" type="checkbox" value="{{ $mapel->id }}"
                                           {{ in_array($mapel->id, old('mapel_ids', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 text-[#2C5F2D] focus:ring-[#C8963E]">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="mapel_{{ $mapel->id }}" class="font-medium text-gray-900 select-none cursor-pointer">{{ $mapel->nama_mapel }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($mapels->isEmpty())
                            <p class="text-sm text-gray-500 italic">Belum ada data mata pelajaran.</p>
                        @endif
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Centang mata pelajaran yang diajarkan oleh guru ini.</p>
                </div>

                {{-- Status Kepegawaian --}}
                <div class="sm:col-span-3">
                    <label for="status_kepegawaian" class="block text-sm font-medium leading-6 text-gray-900">Status Kepegawaian</label>
                    <div class="mt-2">
                        <select id="status_kepegawaian" name="status_kepegawaian" class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            <option value="">-- Pilih Status --</option>
                            <option value="PNS" {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="GTY" {{ old('status_kepegawaian') == 'GTY' ? 'selected' : '' }}>GTY (Guru Tetap Yayasan)</option>
                            <option value="GTT" {{ old('status_kepegawaian') == 'GTT' ? 'selected' : '' }}>GTT (Guru Tidak Tetap)</option>
                            <option value="Staf" {{ old('status_kepegawaian') == 'Staf' ? 'selected' : '' }}>Staf / Karyawan</option>
                        </select>
                    </div>
                </div>

                {{-- Tahun Mulai --}}
                <div class="sm:col-span-3">
                    <label for="tahun_mulai_bekerja" class="block text-sm font-medium leading-6 text-gray-900">Tahun Mulai Bekerja</label>
                    <div class="mt-2">
                        <input type="text" name="tahun_mulai_bekerja" id="tahun_mulai_bekerja" value="{{ old('tahun_mulai_bekerja') }}" placeholder="Contoh: 2015"
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-6 border-t border-gray-100 pt-4 mt-2">
                    <h4 class="text-sm font-semibold text-gray-900">Pendidikan Terakhir</h4>
                </div>

                {{-- Universitas --}}
                <div class="sm:col-span-3">
                    <label for="pend_terakhir_univ" class="block text-sm font-medium leading-6 text-gray-900">Perguruan Tinggi</label>
                    <div class="mt-2">
                        <input type="text" name="pend_terakhir_univ" id="pend_terakhir_univ" value="{{ old('pend_terakhir_univ') }}"
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- Jurusan --}}
                <div class="sm:col-span-2">
                    <label for="pend_terakhir_jurusan" class="block text-sm font-medium leading-6 text-gray-900">Jurusan</label>
                    <div class="mt-2">
                        <input type="text" name="pend_terakhir_jurusan" id="pend_terakhir_jurusan" value="{{ old('pend_terakhir_jurusan') }}"
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- Tahun Lulus --}}
                <div class="sm:col-span-1">
                    <label for="pend_terakhir_tahun" class="block text-sm font-medium leading-6 text-gray-900">Tahun Lulus</label>
                    <div class="mt-2">
                        <input type="text" name="pend_terakhir_tahun" id="pend_terakhir_tahun" value="{{ old('pend_terakhir_tahun') }}" placeholder="2010"
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                    </div>
                </div>

            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-x-4">
            <a href="{{ route('guru.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-[#2C5F2D] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
