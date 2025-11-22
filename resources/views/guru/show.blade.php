@extends('layouts.app')

@section('title', 'Detail Guru: ' . $guru->nama)

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header Halaman --}}
        <div class="mb-6 sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#2C5F2D]">{{ $guru->nama }} {{ $guru->gelar }}</h1>
                <p class="mt-2 text-sm text-gray-600 flex items-center gap-3">
                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                        NIP: {{ $guru->nip ?? '-' }}
                    </span>
                    <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                        {{ $guru->status_kepegawaian ?? 'Status Tidak Diketahui' }}
                    </span>
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('guru.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2 transition-colors">
                   &larr; Kembali
                </a>
                @can('manage guru')
                <a href="{{ route('guru.edit', $guru->id) }}"
                   class="inline-flex items-center justify-center rounded-lg bg-[#C8963E] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 transition-colors">
                   Edit Data
                </a>
                @endcan
            </div>
        </div>

        <div class="space-y-6">
            {{-- BAGIAN 1: DATA PRIBADI --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D]">Data Pribadi</h3>
                </div>
                <div class="border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-medium">{{ $guru->nama }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Gelar Akademik</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->gelar ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ $guru->tempat_lahir }}, {{ $guru->tanggal_lahir ? $guru->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                            </dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->alamat ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">No. Telepon / HP</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->telepon ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- BAGIAN 2: KEPEGAWAIAN & PENDIDIKAN --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D]">Data Kepegawaian & Pendidikan</h3>
                </div>
                <div class="border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->jabatan ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Mata Pelajaran Pengampu</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-medium text-[#2C5F2D]">
                                @if($guru->mapels->count() > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($guru->mapels as $mapel)
                                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                {{ $mapel->nama_mapel }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Tahun Mulai Bekerja</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->tahun_mulai_bekerja ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Tugas Tambahan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                @if($guru->wali)
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                        Wali Kelas {{ $guru->wali->tingkat }} - {{ $guru->wali->nama_kelas }}
                                    </span>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        
                        {{-- Pendidikan --}}
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors bg-gray-50/50">
                            <dt class="text-sm font-semibold text-gray-800">Pendidikan Terakhir</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"></dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">Perguruan Tinggi</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->pend_terakhir_univ ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">Jurusan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->pend_terakhir_jurusan ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">Tahun Lulus</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $guru->pend_terakhir_tahun ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>
    </div>
@endsection
