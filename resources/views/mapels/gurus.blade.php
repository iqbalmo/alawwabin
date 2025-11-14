@extends('layouts.app')

@section('title', 'Guru Pengajar | SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')
<div class="max-w-4xl mx-auto">
    
    {{-- Header Halaman --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#2C5F2D]">Guru Pengajar Mata Pelajaran</h2>
        <p class="text-lg text-[#C8963E] font-semibold">{{ $mapel->nama_mapel }}</p>
    </div>

    {{-- Kontainer Daftar (diubah ke style light mode) --}}
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <div class="p-4 sm:p-6">
            @if($mapel->gurus->isNotEmpty())
                <ul class="divide-y divide-gray-200">
                    @foreach($mapel->gurus as $guru)
                        <li class="py-4 flex items-center justify-between">
                            <div>
                                <p class="text-lg font-medium text-[#333333]">{{ $guru->nama }}</p>
                                <p class="text-sm text-gray-600">NIP: {{ $guru->nip }}</p>
                            </div>
                            <div>
                                {{-- Link diubah ke Hijau Utama --}}
                                <a href="{{ route('guru.edit', $guru->id) }}" class="text-[#2C5F2D] hover:text-[#214621] text-sm font-medium">
                                    Lihat Detail
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">Belum ada guru yang ditugaskan untuk mengajar mata pelajaran ini.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Tombol Kembali (diubah ke style light mode) --}}
    <div class="mt-6">
        <a href="{{ route('mapels.index') }}" 
           class="bg-transparent hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-300 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
           &larr; Kembali ke Daftar Mata Pelajaran
        </a>
    </div>
</div>
@endsection