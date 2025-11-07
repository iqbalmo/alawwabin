@extends('layouts.app')

@section('title', 'Edit Data Siswa: ' . $siswa->nama)
@section('header-title', 'Edit Data Siswa')

@section('content')
<form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
    @csrf
    @method('PUT') {{-- PENTING: Gunakan method PUT/PATCH untuk update --}}
    
    <div class="space-y-12">
        
        {{-- BAGIAN 1: DATA DIRI SISWA --}}
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Data Diri Siswa</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Informasi pribadi dan akademik siswa.</p>

            @if ($errors->any())
                <div class="mt-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.293 7.293a1 1 0 011.414 0L10 8.586l1.293-1.293a1 1 0 111.414 1.414L11.414 10l1.293 1.293a1 1 0 01-1.414 1.414L10 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L8.586 10 7.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} error pada input Anda:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                {{-- Data Wajib --}}
                <div class="sm:col-span-3">
                    <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="nis" class="block text-sm font-medium leading-6 text-gray-900">NIS (Lokal) <span class="text-red-500">*</span></label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="kelas_id" class="block text-sm font-medium leading-6 text-gray-900">Kelas <span class="text-red-500">*</span></label>
                    <select id="kelas_id" name="kelas_id" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                        <option value="">Pilih kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->tingkat }} - {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Data Opsional Siswa --}}
                <div class="sm:col-span-3">
                    <label for="no_absen" class="block text-sm font-medium leading-6 text-gray-900">Nomor Absen</label>
                    <input type="number" name="no_absen" id="no_absen" value="{{ old('no_absen', $siswa->no_absen) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="nisn" class="block text-sm font-medium leading-6 text-gray-900">NISN</label>
                    <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="nik_siswa" class="block text-sm font-medium leading-6 text-gray-900">NIK Siswa</label>
                    <input type="text" name="nik_siswa" id="nik_siswa" value="{{ old('nik_siswa', $siswa->nik_siswa) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Lahir</label>
                    {{-- Format tanggal untuk input type="date" adalah Y-m-d --}}
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="jenis_kelamin" class="block text-sm font-medium leading-6 text-gray-900">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="anak_ke" class="block text-sm font-medium leading-6 text-gray-900">Anak Ke-</label>
                    <input type="number" name="anak_ke" id="anak_ke" value="{{ old('anak_ke', $siswa->anak_ke) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="jumlah_saudara" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Saudara</label>
                    <input type="number" name="jumlah_saudara" id="jumlah_saudara" value="{{ old('jumlah_saudara', $siswa->jumlah_saudara) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="no_kk" class="block text-sm font-medium leading-6 text-gray-900">Nomor Kartu Keluarga</label>
                    <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $siswa->no_kk) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="sekolah_asal" class="block text-sm font-medium leading-6 text-gray-900">Sekolah Asal</label>
                    <input type="text" name="sekolah_asal" id="sekolah_asal" value="{{ old('sekolah_asal', $siswa->sekolah_asal) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="status_mukim" class="block text-sm font-medium leading-6 text-gray-900">Status Mukim</label>
                    <select id="status_mukim" name="status_mukim" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                        <option value="">Pilih status</option>
                        <option value="MUKIM" {{ old('status_mukim', $siswa->status_mukim) == 'MUKIM' ? 'selected' : '' }}>Mukim (Asrama)</option>
                        <option value="NON MUKIM" {{ old('status_mukim', $siswa->status_mukim) == 'NON MUKIM' ? 'selected' : '' }}>Non Mukim (Pulang Pergi)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- BAGIAN 2: DATA ORANG TUA --}}
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Data Orang Tua</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Informasi Ayah dan Ibu kandung siswa.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                {{-- Ayah --}}
                <div class="sm:col-span-3">
                    <label for="nama_ayah" class="block text-sm font-medium leading-6 text-gray-900">Nama Ayah</label>
                    <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="ttl_ayah" class="block text-sm font-medium leading-6 text-gray-900">Tempat, Tanggal Lahir Ayah</label>
                    <input type="text" name="ttl_ayah" id="ttl_ayah" value="{{ old('ttl_ayah', $siswa->ttl_ayah) }}" placeholder="Contoh: Jakarta, 01 Januari 1980" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="pendidikan_ayah" class="block text-sm font-medium leading-6 text-gray-900">Pendidikan Terakhir Ayah</label>
                    <input type="text" name="pendidikan_ayah" id="pendidikan_ayah" value="{{ old('pendidikan_ayah', $siswa->pendidikan_ayah) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="pekerjaan_ayah" class="block text-sm font-medium leading-6 text-gray-900">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>

                {{-- Ibu --}}
                <div class="sm:col-span-3">
                    <label for="nama_ibu" class="block text-sm font-medium leading-6 text-gray-900">Nama Ibu</label>
                    <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="ttl_ibu" class="block text-sm font-medium leading-6 text-gray-900">Tempat, Tanggal Lahir Ibu</label>
                    <input type="text" name="ttl_ibu" id="ttl_ibu" value="{{ old('ttl_ibu', $siswa->ttl_ibu) }}" placeholder="Contoh: Bogor, 01 Januari 1980" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="pendidikan_ibu" class="block text-sm font-medium leading-6 text-gray-900">Pendidikan Terakhir Ibu</label>
                    <input type="text" name="pendidikan_ibu" id="pendidikan_ibu" value="{{ old('pendidikan_ibu', $siswa->pendidikan_ibu) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="pekerjaan_ibu" class="block text-sm font-medium leading-6 text-gray-900">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
            </div>
        </div>

        {{-- BAGIAN 3: ALAMAT & KONTAK ORANG TUA --}}
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Alamat & Kontak Orang Tua</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Alamat domisili dan kontak orang tua.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="col-span-full">
                    <label for="alamat_orangtua" class="block text-sm font-medium leading-6 text-gray-900">Alamat Orang Tua</label>
                    <textarea id="alamat_orangtua" name="alamat_orangtua" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">{{ old('alamat_orangtua', $siswa->alamat_orangtua) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label for="kelurahan" class="block text-sm font-medium leading-6 text-gray-900">Kelurahan/Desa</label>
                    <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $siswa->kelurahan) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="kecamatan" class="block text-sm font-medium leading-6 text-gray-900">Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $siswa->kecamatan) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="kota" class="block text-sm font-medium leading-6 text-gray-900">Kabupaten/Kota</label>
                    <input type="text" name="kota" id="kota" value="{{ old('kota', $siswa->kota) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="provinsi" class="block text-sm font-medium leading-6 text-gray-900">Provinsi</label>
                    <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi', $siswa->provinsi) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="kodepos" class="block text-sm font-medium leading-6 text-gray-900">Kode Pos</label>
                    <input type="text" name="kodepos" id="kodepos" value="{{ old('kodepos', $siswa->kodepos) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                
                {{-- Kontak --}}
                <div class="sm:col-span-3">
                    <label for="hp_ayah" class="block text-sm font-medium leading-6 text-gray-900">No. HP Ayah</label>
                    <input type="text" name="hp_ayah" id="hp_ayah" value="{{ old('hp_ayah', $siswa->hp_ayah) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="hp_ibu" class="block text-sm font-medium leading-6 text-gray-900">No. HP Ibu</label>
                    <input type="text" name="hp_ibu" id="hp_ibu" value="{{ old('hp_ibu', $siswa->hp_ibu) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="email_ayah" class="block text-sm font-medium leading-6 text-gray-900">Email Ayah</label>
                    <input type="email" name="email_ayah" id="email_ayah" value="{{ old('email_ayah', $siswa->email_ayah) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="email_ibu" class="block text-sm font-medium leading-6 text-gray-900">Email Ibu</label>
                    <input type="email" name="email_ibu" id="email_ibu" value="{{ old('email_ibu', $siswa->email_ibu) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
            </div>
        </div>

        {{-- BAGIAN 4: DATA WALI (OPSIONAL) --}}
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Data Wali (Opsional)</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Diisi jika siswa tinggal bersama wali yang bukan orang tua kandung.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="nama_wali" class="block text-sm font-medium leading-6 text-gray-900">Nama Wali</label>
                    <input type="text" name="nama_wali" id="nama_wali" value="{{ old('nama_wali', $siswa->nama_wali) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="ttl_wali" class="block text-sm font-medium leading-6 text-gray-900">Tempat, Tanggal Lahir Wali</label>
                    <input type="text" name="ttl_wali" id="ttl_wali" value="{{ old('ttl_wali', $siswa->ttl_wali) }}" placeholder="Contoh: Depok, 01 Januari 1970" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="pekerjaan_wali" class="block text-sm font-medium leading-6 text-gray-900">Pekerjaan Wali</label>
                    <input type="text" name="pekerjaan_wali" id="pekerjaan_wali" value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">
                </div>
                <div class="col-span-full">
                    <label for="alamat_wali" class="block text-sm font-medium leading-6 text-gray-900">Alamat Wali</label>
                    <textarea id="alamat_wali" name="alamat_wali" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm">{{ old('alamat_wali', $siswa->alamat_wali) }}</textarea>
                </div>
            </div>
        </div>

    </div>

    {{-- Tombol Simpan --}}
    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('siswa.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
        <button type="submit" class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#2C5F2D]">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection