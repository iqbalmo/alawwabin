@extends('layouts.app')

@section('title', 'Alat Kenaikan Kelas | SITU Al-Awwabin')

@section('content')

    {{-- Header Halaman --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Alat Kenaikan Kelas</h2>
        <p class="mt-2 text-sm text-gray-600">
            Pilih kelas yang ingin Anda proses kenaikan kelas atau kelulusannya.
        </p>
    </div>

    {{-- Daftar Kelompok Kelas --}}
    <div class="space-y-10">

        @forelse($groupedKelas as $tingkat => $kelasList)
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Judul Kelompok -->
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-[#2C5F2D]">
                        Kelompok Kelas {{ $tingkat }}
                    </h3>
                    <span class="inline-flex items-center rounded-md bg-white px-2.5 py-0.5 text-sm font-medium text-[#2C5F2D] shadow-sm ring-1 ring-inset ring-gray-300">
                        {{ $kelasList->count() }} Kelas
                    </span>
                </div>

                <!-- Daftar Card Kelas -->
                <div class="p-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($kelasList as $kelas)
                        <a href="{{ route('kelas.showPromotionForm', $kelas->id) }}" 
                           class="group relative block rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:border-[#2C5F2D] hover:ring-1 hover:ring-[#2C5F2D] hover:shadow-md transition-all duration-200">
                            
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-50 flex items-center justify-center text-[#2C5F2D] font-bold text-lg group-hover:bg-[#2C5F2D] group-hover:text-white transition-colors">
                                        {{ $kelas->tingkat }}
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 group-hover:text-[#2C5F2D] transition-colors">
                                            {{ $kelas->nama_kelas }}
                                        </h4>
                                    </div>
                                </div>
                                
                                {{-- Badge Status --}}
                                @if($kelas->tingkat == 9)
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                        Tingkat Akhir
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                        Naik Kelas
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-2 border-t border-gray-100 pt-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Wali Kelas</span>
                                    <span class="font-medium text-gray-900 truncate max-w-[120px]" title="{{ $kelas->wali?->nama }}">
                                        {{ $kelas->wali?->nama ?? '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Jumlah Siswa</span>
                                    <span class="font-medium text-gray-900">{{ $kelas->siswa_count }} Siswa</span>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex items-center text-sm font-medium text-[#C8963E] group-hover:text-[#b58937]">
                                Proses Kenaikan <span aria-hidden="true" class="ml-1">&rarr;</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak ada kelas</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada data kelas yang tersedia untuk diproses.</p>
            </div>
        @endforelse

    </div>
@endsection