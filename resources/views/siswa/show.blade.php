@extends('layouts.app')

@section('title', 'Detail Siswa: ' . $siswa->nama)
@section('header-title', 'Detail Data Siswa')

@section('content')
<div class="overflow-hidden bg-white shadow sm:rounded-lg">
    {{-- Header Halaman Detail --}}
    <div class="px-4 py-5 sm:px-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-2xl font-semibold leading-6 text-gray-900">{{ $siswa->nama }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn ?? '-' }}</p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('siswa.edit', $siswa->id) }}"
                   class="inline-flex items-center rounded-md border border-transparent bg-[#2C5F2D] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#214621] focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2">
                   Edit Data
                </a>
                <a href="{{ route('siswa.index') }}"
                   class="ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2">
                   Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    {{-- Fungsi Bantuan untuk Menampilkan Data --}}
    @php
    function renderDetail($label, $value, $default = '-') {
        echo '<div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">';
        echo '<dt class="text-sm font-medium text-gray-500">' . e($label) . '</dt>';
        echo '<dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">' . ($value ? e($value) : $default) . '</dd>';
        echo '</div>';
    }
    @endphp

    <div class="border-t border-gray-200">
        <dl>
            {{-- BAGIAN 1: DATA DIRI SISWA --}}
            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                <h4 class="text-lg font-medium text-gray-900">Data Diri Siswa</h4>
            </div>
            @php
            renderDetail('Nama Lengkap', $siswa->nama);
            renderDetail('Kelas', ($siswa->kelas ? $siswa->kelas->tingkat . ' - ' . $siswa->kelas->nama_kelas : '-'));
            renderDetail('No. Absen', $siswa->no_absen);
            renderDetail('NIS (Lokal)', $siswa->nis);
            renderDetail('NISN', $siswa->nisn);
            renderDetail('NIK Siswa', $siswa->nik_siswa);
            renderDetail('Tempat Lahir', $siswa->tempat_lahir);
            renderDetail('Tanggal Lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->translatedFormat('d F Y') : '-');
            renderDetail('Jenis Kelamin', $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-'));
            renderDetail('Anak Ke-', $siswa->anak_ke);
            renderDetail('Jumlah Saudara', $siswa->jumlah_saudara);
            renderDetail('No. Kartu Keluarga', $siswa->no_kk);
            renderDetail('Sekolah Asal', $siswa->sekolah_asal);
            renderDetail('Status Mukim', $siswa->status_mukim);
            @endphp

            {{-- BAGIAN 2: DATA ORANG TUA --}}
            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                <h4 class="text-lg font-medium text-gray-900">Data Orang Tua</h4>
            </div>
            @php
            renderDetail('Nama Ayah', $siswa->nama_ayah);
            renderDetail('TTL Ayah', $siswa->ttl_ayah);
            renderDetail('Pendidikan Ayah', $siswa->pendidikan_ayah);
            renderDetail('Pekerjaan Ayah', $siswa->pekerjaan_ayah);
            renderDetail('Nama Ibu', $siswa->nama_ibu);
            renderDetail('TTL Ibu', $siswa->ttl_ibu);
            renderDetail('Pendidikan Ibu', $siswa->pendidikan_ibu);
            renderDetail('Pekerjaan Ibu', $siswa->pekerjaan_ibu);
            @endphp

            {{-- BAGIAN 3: ALAMAT & KONTAK ORANG TUA --}}
            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                <h4 class="text-lg font-medium text-gray-900">Alamat & Kontak Orang Tua</h4>
            </div>
            @php
            renderDetail('Alamat Orang Tua', $siswa->alamat_orangtua);
            renderDetail('Kelurahan/Desa', $siswa->kelurahan);
            renderDetail('Kecamatan', $siswa->kecamatan);
            renderDetail('Kabupaten/Kota', $siswa->kota);
            renderDetail('Provinsi', $siswa->provinsi);
            renderDetail('Kode Pos', $siswa->kodepos);
            renderDetail('No. HP Ayah', $siswa->hp_ayah);
            renderDetail('No. HP Ibu', $siswa->hp_ibu);
            renderDetail('Email Ayah', $siswa->email_ayah);
            renderDetail('Email Ibu', $siswa->email_ibu);
            @endphp
            
            {{-- BAGIAN 4: DATA WALI (OPSIONAL) --}}
            {{-- Hanya tampilkan bagian ini jika nama wali diisi --}}
            @if($siswa->nama_wali)
                <div class="bg-gray-50 px-4 py-3 sm:px-6">
                    <h4 class="text-lg font-medium text-gray-900">Data Wali (Opsional)</h4>
                </div>
                @php
                renderDetail('Nama Wali', $siswa->nama_wali);
                renderDetail('TTL Wali', $siswa->ttl_wali);
                renderDetail('Pekerjaan Wali', $siswa->pekerjaan_wali);
                renderDetail('Alamat Wali', $siswa->alamat_wali);
                @endphp
            @endif

        </dl>
    </div>
</div>
@endsection