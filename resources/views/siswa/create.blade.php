@extends('layouts.app')

@section('title', 'Tambah Siswa Baru')

@section('content')
    <form action="{{ route('siswa.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 md:p-8">
        @csrf
        <div class="space-y-12">

            <!-- Header Form -->
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Formulir Siswa Baru</h2>
                <p class="mt-2 text-sm text-gray-600">Isi data siswa sesuai dengan aturan baru.</p>
            </div>

            <!-- BAGIAN 1: DATA INTI SISWA -->
            <div class="border-b border-gray-900/10 pb-12">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">1. Data Inti Siswa</h3>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">

                    <div class="md:col-span-3">
                        <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap <span
                                class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('nama') border-red-500 @enderror">
                        </div>
                        @error('nama')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-3">
                        <label for="kelas_id" class="block text-sm font-medium leading-6 text-gray-900">Kelas <span
                                class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <select id="kelas_id" name="kelas_id"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('kelas_id') border-red-500 @enderror">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->tingkat }} - {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('kelas_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="nis" class="block text-sm font-medium leading-6 text-gray-900">NIS (Lokal) <span
                                class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="text" name="nis" id="nis" value="{{ old('nis') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('nis') border-red-500 @enderror">
                        </div>
                        @error('nis')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="nisn" class="block text-sm font-medium leading-6 text-gray-900">NISN</label>
                        <div class="mt-2">
                            <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('nisn') border-red-500 @enderror">
                        </div>
                        @error('nisn')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="no_absen" class="block text-sm font-medium leading-6 text-gray-900">No. Absen</label>
                        <div class="mt-2">
                            <input type="number" name="no_absen" id="no_absen" value="{{ old('no_absen') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('no_absen') border-red-500 @enderror">
                        </div>
                        @error('no_absen')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: DATA PRIBADI SISWA -->
            <div class="border-b border-gray-900/10 pb-12">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">2. Data Pribadi Siswa</h3>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">
                    <div class="md:col-span-3">
                        <label for="nik_siswa" class="block text-sm font-medium leading-6 text-gray-900">NIK Siswa</label>
                        <div class="mt-2">
                            <input type="text" name="nik_siswa" id="nik_siswa" value="{{ old('nik_siswa') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm @error('nik_siswa') border-red-500 @enderror">
                        </div>
                        @error('nik_siswa')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-3">
                        <label for="no_kk" class="block text-sm font-medium leading-6 text-gray-900">Nomor KK</label>
                        <div class="mt-2">
                            <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tempat
                            Lahir</label>
                        <div class="mt-2">
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal
                            Lahir</label>
                        <div class="mt-2">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="jenis_kelamin" class="block text-sm font-medium leading-6 text-gray-900">Jenis
                            Kelamin</label>
                        <div class="mt-2">
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="anak_ke" class="block text-sm font-medium leading-6 text-gray-900">Anak Ke-</label>
                        <div class="mt-2">
                            <input type="number" name="anak_ke" id="anak_ke" value="{{ old('anak_ke') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="jumlah_saudara" class="block text-sm font-medium leading-6 text-gray-900">Jumlah
                            Saudara</label>
                        <div class="mt-2">
                            <input type="number" name="jumlah_saudara" id="jumlah_saudara"
                                value="{{ old('jumlah_saudara') }}"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="status_mukim" class="block text-sm font-medium leading-6 text-gray-900">Status
                            Mukim</label>
                        <div class="mt-2">
                            <select id="status_mukim" name="status_mukim"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                                <option value="">-- Pilih --</option>
                                <option value="MUKIM" {{ old('status_mukim') == 'MUKIM' ? 'selected' : '' }}>MUKIM
                                </option>
                                <option value="PP" {{ old('status_mukim') == 'PP' ? 'selected' : '' }}>PP</option>
                            </select>
                        </div>
                    </div>
                    <div class="md:col-span-6">
                        <label for="sekolah_asal" class="block text-sm font-medium leading-6 text-gray-900">Sekolah
                            Asal</label>
                        <div class="mt-2">
                            <input type="text" name="sekolah_asal" id="sekolah_asal"
                                value="{{ old('sekolah_asal') }}"
                                placeholder="Contoh: SDN 01 Pagi Depok atau MI Al-Ikhlas"
                                class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 3: DATA ORANG TUA -->
            <div class="border-b border-gray-900/10 pb-12">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">3. Data Orang Tua</h3>
                <!-- Data Ayah -->
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">
                    <div class="md:col-span-full">
                        <h4 class="text-md font-medium text-gray-800">Data Ayah</h4>
                    </div>
                    <div class="md:col-span-3">
                        <label for="nama_ayah" class="block text-sm font-medium leading-6 text-gray-900">Nama Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="ttl_ayah" class="block text-sm font-medium leading-6 text-gray-900">Tempat, Tanggal
                            Lahir Ayah</label>
                        <input type="text" name="ttl_ayah" id="ttl_ayah" value="{{ old('ttl_ayah') }}"
                            placeholder="Contoh: Jakarta, 01-01-1980"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="pendidikan_ayah" class="block text-sm font-medium leading-6 text-gray-900">Pendidikan
                            Ayah</label>
                        <input type="text" name="pendidikan_ayah" id="pendidikan_ayah"
                            value="{{ old('pendidikan_ayah') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="pekerjaan_ayah" class="block text-sm font-medium leading-6 text-gray-900">Pekerjaan
                            Ayah</label>
                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah"
                            value="{{ old('pekerjaan_ayah') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="hp_ayah" class="block text-sm font-medium leading-6 text-gray-900">No. HP
                            Ayah</label>
                        <input type="text" name="hp_ayah" id="hp_ayah" value="{{ old('hp_ayah') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="email_ayah" class="block text-sm font-medium leading-6 text-gray-900">Email
                            Ayah</label>
                        <input type="email" name="email_ayah" id="email_ayah" value="{{ old('email_ayah') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                </div>
                <!-- Data Ibu -->
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">
                    <div class="md:col-span-full">
                        <h4 class="text-md font-medium text-gray-800">Data Ibu</h4>
                    </div>
                    <div class="md:col-span-3">
                        <label for="nama_ibu" class="block text-sm font-medium leading-6 text-gray-900">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="ttl_ibu" class="block text-sm font-medium leading-6 text-gray-900">Tempat, Tanggal
                            Lahir Ibu</label>
                        <input type="text" name="ttl_ibu" id="ttl_ibu" value="{{ old('ttl_ibu') }}"
                            placeholder="Contoh: Bandung, 02-02-1982"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="pendidikan_ibu" class="block text-sm font-medium leading-6 text-gray-900">Pendidikan
                            Ibu</label>
                        <input type="text" name="pendidikan_ibu" id="pendidikan_ibu"
                            value="{{ old('pendidikan_ibu') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="pekerjaan_ibu" class="block text-sm font-medium leading-6 text-gray-900">Pekerjaan
                            Ibu</label>
                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu"
                            value="{{ old('pekerjaan_ibu') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="hp_ibu" class="block text-sm font-medium leading-6 text-gray-900">No. HP Ibu</label>
                        <input type="text" name="hp_ibu" id="hp_ibu" value="{{ old('hp_ibu') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="email_ibu" class="block text-sm font-medium leading-6 text-gray-900">Email Ibu</label>
                        <input type="email" name="email_ibu" id="email_ibu" value="{{ old('email_ibu') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                </div>
            </div>

            <!-- BAGIAN 4: DATA WALI (OPSIONAL) -->
            <div class="border-b border-gray-900/10 pb-12">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">4. Data Wali (Opsional)</h3>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">
                    <div class="md:col-span-3">
                        <label for="nama_wali" class="block text-sm font-medium leading-6 text-gray-900">Nama Wali</label>
                        <input type="text" name="nama_wali" id="nama_wali" value="{{ old('nama_wali') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="ttl_wali" class="block text-sm font-medium leading-6 text-gray-900">Tempat, Tanggal
                            Lahir Wali</label>
                        <input type="text" name="ttl_wali" id="ttl_wali" value="{{ old('ttl_wali') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="pekerjaan_wali" class="block text-sm font-medium leading-6 text-gray-900">Pekerjaan
                            Wali</label>
                        <input type="text" name="pekerjaan_wali" id="pekerjaan_wali"
                            value="{{ old('pekerjaan_wali') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-6">
                        <label for="alamat_wali" class="block text-sm font-medium leading-6 text-gray-900">Alamat
                            Wali</label>
                        <textarea id="alamat_wali" name="alamat_wali" rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('alamat_wali') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 5: ALAMAT ORANG TUA -->
            <div class="pb-12">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">5. Alamat Orang Tua</h3>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">
                    <div class="md:col-span-6">
                        <label for="alamat_orangtua" class="block text-sm font-medium leading-6 text-gray-900">Alamat
                            Lengkap</label>
                        <textarea id="alamat_orangtua" name="alamat_orangtua" rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('alamat_orangtua') }}</textarea>
                    </div>
                    <div class="md:col-span-3">
                        <label for="kelurahan"
                            class="block text-sm font-medium leading-6 text-gray-900">Kelurahan/Desa</label>
                        <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="kecamatan" class="block text-sm font-medium leading-6 text-gray-900">Kecamatan</label>
                        <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label for="kota"
                            class="block text-sm font-medium leading-6 text-gray-900">Kabupaten/Kota</label>
                        <input type="text" name="kota" id="kota" value="{{ old('kota') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="provinsi" class="block text-sm font-medium leading-6 text-gray-900">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label for="kodepos" class="block text-sm font-medium leading-6 text-gray-900">Kode Pos</label>
                        <input type="text" name="kodepos" id="kodepos" value="{{ old('kodepos') }}"
                            class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm">
                    </div>
                </div>
            </div>

        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('siswa.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
            <button type="submit"
                class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Simpan Data Siswa
            </button>
        </div>
    </form>
@endsection
