@extends('layouts.app')

@section('title', 'Guru Pengajar | SIAP Al-Awwabin')

@section('content')
<div class="max-w-5xl mx-auto">
    
    {{-- Header Halaman --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('mapels.index') }}" class="text-gray-400 hover:text-[#2C5F2D] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-[#2C5F2D]">Guru Pengajar</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 uppercase tracking-wide font-semibold">Mata Pelajaran</p>
            <h1 class="text-3xl font-bold text-[#333333] mt-1">{{ $mapel->nama_mapel }}</h1>
        </div>
    </div>

    {{-- Daftar Guru --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($mapel->gurus as $guru)
            <div class="group relative bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md hover:border-[#2C5F2D] transition-all duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center text-[#2C5F2D] font-bold text-xl">
                            {{ substr($guru->nama, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#2C5F2D] transition-colors">
                                {{ $guru->nama }}
                            </h3>
                            <p class="text-sm text-gray-500 font-medium">NIP: {{ $guru->nip }}</p>
                        </div>
                    </div>
                    <a href="{{ route('guru.edit', $guru->id) }}" class="text-gray-400 hover:text-[#C8963E] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                    </a>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between text-sm">
                    <span class="text-gray-500">Status</span>
                    <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                        Aktif Mengajar
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="mx-auto h-12 w-12 text-gray-300 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Belum ada guru</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada guru yang ditugaskan untuk mata pelajaran ini.</p>
                @can('manage mapel')
                <div class="mt-6">
                    <a href="{{ route('mapels.edit', $mapel->id) }}" class="inline-flex items-center rounded-md bg-[#2C5F2D] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                        Edit Mapel & Assign Guru
                    </a>
                </div>
                @endcan
            </div>
        @endforelse
    </div>
</div>
@endsection
