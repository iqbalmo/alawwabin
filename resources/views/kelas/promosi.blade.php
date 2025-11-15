@extends('layouts.app')

@section('title', 'Alat Kenaikan Kelas')

@section('header-title', 'Alat Kenaikan Kelas')

@section('content')

{{-- 1. Header Halaman --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Pilih Kelas</h2>
        <p class="mt-2 text-sm text-gray-600">
            Pilih kelas yang ingin Anda proses kenaikan kelas atau kelulusannya.
        </p>
    </div>
</div>

{{-- 2. Daftar Kelompok Kelas --}}
<div class="mt-8 space-y-10">

    @forelse($groupedKelas as $tingkat => $kelasList)
        
        <div>
            <!-- Judul Kelompok -->
            <h3 class="text-xl font-semibold leading-7 text-[#2C5F2D] border-b border-gray-300 pb-2">
                Kelompok Kelas {{ $tingkat }}
            </h3>

            <!-- Daftar Card Kelas -->
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($kelasList as $kelas)
                    <a href="{{ route('kelas.showPromotionForm', $kelas->id) }}" 
                       class="block rounded-lg bg-white p-6 shadow-sm border border-gray-200 hover:border-green-500 hover:shadow-md transition-all">
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-semibold text-green-800">{{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</p>
                            
                            {{-- Tampilkan status tingkat akhir --}}
                            @if($kelas->tingkat == 9) {{-- Asumsi 9 tingkat akhir --}}
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                    Tingkat Akhir
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                    Naik Kelas
                                </span>
                            @endif
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Wali: {{ $kelas->wali?->nama ?? 'N/A' }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Jumlah: <strong>{{ $kelas->siswa_count }} Siswa</strong>
                        </p>
                    </a>
                @endforeach
            </div>
        </div>

    @empty
        <div class="py-8 text-center text-gray-500">
            Belum ada data kelas yang bisa dipromosikan.
        </div>
    @endforelse

</div>
@endsection