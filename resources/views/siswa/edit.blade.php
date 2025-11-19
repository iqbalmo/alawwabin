@extends('layouts.app')

@section('title', 'Edit Data Siswa | SITU Al-Awwabin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#2C5F2D]">Edit Data Siswa</h1>
            <p class="mt-2 text-gray-600">Perbarui data siswa atas nama <strong>{{ $siswa->nama }}</strong>.</p>
        </div>

        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- BAGIAN 1: DATA INTI SISWA --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D] flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#2C5F2D] text-white text-sm mr-3">1</span>
                        Data Inti Siswa
                    </h3>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-2">
                    
                    <div class="md:col-span-2">
                        <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow @error('nama') ring-red-500 @enderror">
                        </div>
                        @error('nama') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="kelas_id" class="block text-sm font-medium leading-6 text-gray-900">Kelas <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <select id="kelas_id" name="kelas_id"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow @error('kelas_id') ring-red-500 @enderror">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->tingkat }} - {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('kelas_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nis" class="block text-sm font-medium leading-6 text-gray-900">NIS (Lokal) <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow @error('nis') ring-red-500 @enderror">
                        </div>
                        @error('nis') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nisn" class="block text-sm font-medium leading-6 text-gray-900">NISN</label>
                        <div class="mt-2">
                            <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow @error('nisn') ring-red-500 @enderror">
                        </div>
                        @error('nisn') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_absen" class="block text-sm font-medium leading-6 text-gray-900">No. Absen</label>
                        <div class="mt-2">
                            <input type="number" name="no_absen" id="no_absen" value="{{ old('no_absen', $siswa->no_absen) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow @error('no_absen') ring-red-500 @enderror">
                        </div>
                        @error('no_absen') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: DATA PRIBADI SISWA --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D] flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#2C5F2D] text-white text-sm mr-3">2</span>
                        Data Pribadi Siswa
                    </h3>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-2">
                    
                    <div class="md:col-span-2">
                        <label for="nik_siswa" class="block text-sm font-medium leading-6 text-gray-900">NIK Siswa</label>
                        <div class="mt-2">
                            <input type="text" name="nik_siswa" id="nik_siswa" value="{{ old('nik_siswa', $siswa->nik_siswa) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow @error('nik_siswa') ring-red-500 @enderror">
                        </div>
                        @error('nik_siswa') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_kk" class="block text-sm font-medium leading-6 text-gray-900">Nomor KK</label>
                        <div class="mt-2">
                            <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $siswa->no_kk) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                        </div>
                    </div>

                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tempat Lahir</label>
                        <div class="mt-2">
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                        </div>
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Lahir</label>
                        <div class="mt-2">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                        </div>
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium leading-6 text-gray-900">Jenis Kelamin</label>
                        <div class="mt-2">
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="status_mukim" class="block text-sm font-medium leading-6 text-gray-900">Status Mukim</label>
                        <div class="mt-2">
                            <select id="status_mukim" name="status_mukim"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                                <option value="">-- Pilih --</option>
                                <option value="MUKIM" {{ old('status_mukim', $siswa->status_mukim) == 'MUKIM' ? 'selected' : '' }}>MUKIM</option>
                                <option value="PP" {{ old('status_mukim', $siswa->status_mukim) == 'PP' ? 'selected' : '' }}>PP</option>
                                @if($siswa->status_mukim == 'Lulus')
                                    <option value="Lulus" selected>Lulus (Arsip)</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="anak_ke" class="block text-sm font-medium leading-6 text-gray-900">Anak Ke-</label>
                        <div class="mt-2">
                            <input type="number" name="anak_ke" id="anak_ke" value="{{ old('anak_ke', $siswa->anak_ke) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                        </div>
                    </div>

                    <div>
                        <label for="jumlah_saudara" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Saudara</label>
                        <div class="mt-2">
                            <input type="number" name="jumlah_saudara" id="jumlah_saudara" value="{{ old('jumlah_saudara', $siswa->jumlah_saudara) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="sekolah_asal" class="block text-sm font-medium leading-6 text-gray-900">Sekolah Asal</label>
                        <div class="mt-2">
                            <input type="text" name="sekolah_asal" id="sekolah_asal" value="{{ old('sekolah_asal', $siswa->sekolah_asal) }}"
                                placeholder="Contoh: SDN 01 Pagi Depok"
                                class="block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 3: DATA ORANG TUA --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D] flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#2C5F2D] text-white text-sm mr-3">3</span>
                        Data Orang Tua
                    </h3>
                </div>
                <div class="p-6 md:p-8 space-y-8">
                    
                    {{-- Data Ayah --}}
                    <div>
                        <h4 class="text-md font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Data Ayah</h4>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="nama_ayah" class="block text-sm font-medium leading-6 text-gray-900">Nama Ayah</label>
                                <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                            <div>
                                <label for="hp_ayah" class="block text-sm font-medium leading-6 text-gray-900">No. HP Ayah</label>
                                <input type="text" name="hp_ayah" id="hp_ayah" value="{{ old('hp_ayah', $siswa->hp_ayah) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                            <div>
                                <label for="pekerjaan_ayah" class="block text-sm font-medium leading-6 text-gray-900">Pekerjaan Ayah</label>
                                <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                        </div>
                    </div>

                    {{-- Data Ibu --}}
                    <div>
                        <h4 class="text-md font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Data Ibu</h4>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="nama_ibu" class="block text-sm font-medium leading-6 text-gray-900">Nama Ibu</label>
                                <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                            <div>
                                <label for="hp_ibu" class="block text-sm font-medium leading-6 text-gray-900">No. HP Ibu</label>
                                <input type="text" name="hp_ibu" id="hp_ibu" value="{{ old('hp_ibu', $siswa->hp_ibu) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                            <div>
                                <label for="pekerjaan_ibu" class="block text-sm font-medium leading-6 text-gray-900">Pekerjaan Ibu</label>
                                <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <h4 class="text-md font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Alamat Orang Tua</h4>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="alamat_orangtua" class="block text-sm font-medium leading-6 text-gray-900">Alamat Lengkap</label>
                                <textarea id="alamat_orangtua" name="alamat_orangtua" rows="3"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">{{ old('alamat_orangtua', $siswa->alamat_orangtua) }}</textarea>
                            </div>
                            <div>
                                <label for="kelurahan" class="block text-sm font-medium leading-6 text-gray-900">Kelurahan/Desa</label>
                                <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $siswa->kelurahan) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                            <div>
                                <label for="kecamatan" class="block text-sm font-medium leading-6 text-gray-900">Kecamatan</label>
                                <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $siswa->kecamatan) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                            <div>
                                <label for="kota" class="block text-sm font-medium leading-6 text-gray-900">Kabupaten/Kota</label>
                                <input type="text" name="kota" id="kota" value="{{ old('kota', $siswa->kota) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                            <div>
                                <label for="provinsi" class="block text-sm font-medium leading-6 text-gray-900">Provinsi</label>
                                <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi', $siswa->provinsi) }}"
                                    class="mt-2 block w-full rounded-lg border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6 transition-shadow">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-x-4 pt-4">
                <a href="{{ route('siswa.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700 transition-colors">Batal</a>
                <button type="submit"
                    class="rounded-lg bg-[#2C5F2D] px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all duration-200 transform hover:scale-[1.02]">
                    Update Data Siswa
                </button>
            </div>
        </form>
    </div>
@endsection