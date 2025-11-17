@extends('layouts.app')

@section('title', 'Detail Guru: ' . $guru->nama)

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 md:p-8">

    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Detail Guru</h2>
            <p class="mt-2 text-sm text-gray-600">
                Data lengkap untuk guru atas nama <strong>{{ $guru->nama }}</strong>.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16">
            
            {{-- RBAC: Hanya user dengan izin 'manage guru' yang bisa lihat tombol Edit --}}
            @can('manage guru')
            <a href="{{ route('guru.edit', $guru->id) }}"
               class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
                Edit Data Guru
            </a>
            @endcan

            <a href="{{ route('guru.index') }}"
               class="ml-2 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="mt-10 space-y-12">

        <div class="border-b border-gray-900/10 pb-12">
            <h3 class="text-lg font-semibold leading-7 text-gray-900">1. Data Pribadi</h3>
            <dl class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-6">
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->nama ?? '-' }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Gelar</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->gelar ?? '-' }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">NIP</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->nip ?? '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Tempat Lahir</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->tempat_lahir ?? '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->tanggal_lahir ? $guru->tanggal_lahir->translatedFormat('d F Y') : '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : ($guru->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">No. Telepon/HP</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->telepon ?? '-' }}</dd>
                </div>
                <div class="md:col-span-6">
                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->alamat ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="pb-12">
            <h3 class="text-lg font-semibold leading-7 text-gray-900">2. Data Kepegawaian & Pendidikan</h3>
            <dl class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-6">
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->jabatan ?? '-' }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Mata Pelajaran Utama</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->mapel->nama_mapel ?? '-' }}</dd>
                </div>
                 <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Status Kepegawaian</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->status_kepegawaian ?? '-' }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Tahun Mulai Bekerja</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->tahun_mulai_bekerja ?? '-' }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Wali Kelas dari (jika ada)</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">
                        {{ $guru->wali ? ($guru->wali->tingkat . ' - ' . $guru->wali->nama_kelas) : '-' }}
                    </dd>
                </div>

                <div class="md:col-span-full"><h4 class="text-md font-medium text-gray-800 mt-6">Pendidikan Terakhir</h4></div>
                
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Perguruan Tinggi</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->pend_terakhir_univ ?? '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Jurusan</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->pend_terakhir_jurusan ?? '-' }}</dd>
                </div>
                <div class="md:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Tahun Lulus</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $guru->pend_terakhir_tahun ?? '-' }}</dd>
                </div>
            </dl>
        </div>

    </div>
</div>
@endsection