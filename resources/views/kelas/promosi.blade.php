@extends('layouts.app')

@section('title', 'Alat Kenaikan Kelas | SITU Al-Awwabin')

@section('content')

<form action="{{ route('kelas.processPromotion') }}" method="POST" onsubmit="return confirm('PERINGATAN: Anda akan memindahkan atau meluluskan ratusan siswa sekaligus. Aksi ini tidak dapat dibatalkan. Apakah Anda yakin ingin melanjutkan?');">
    @csrf
    
    {{-- 1. Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Alat Kenaikan Kelas & Kelulusan</h2>
            <p class="mt-2 text-sm text-gray-600">
                Petakan kelas lama ke kelas baru atau luluskan siswa. Untuk yang tidak naik kelas/lulus perlu dipetakan secara manual.
            </p>
        </div>
    </div>

    {{-- 2. Wrapper Alat Pemetaan (Tampilan Card Baru) --}}
    <div class="mt-8 space-y-10">

        @forelse($groupedKelas as $tingkat => $kelasList)
            
            <div>
                <!-- Judul Kelompok -->
                <h3 class="text-xl font-semibold leading-7 text-[#2C5F2D] border-b border-gray-300 pb-2">
                    Kelompok Kelas {{ $tingkat }} (Saat Ini)
                </h3>

                <!-- Daftar Card Pemetaan -->
                <div class="mt-4 divide-y divide-gray-200">
                    @foreach($kelasList as $kelas)
                        {{-- Ini adalah satu 'Card' --}}
                        <div class="py-5 sm:flex sm:items-center sm:justify-between">
                            
                            {{-- Info Kelas (Sebelah Kiri) --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-lg font-semibold text-green-800">{{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</p>
                                <p class="mt-1 text-sm text-gray-500 truncate">
                                    Wali: {{ $kelas->wali?->nama ?? 'N/A' }}
                                </p>
                                <p class="mt-1 text-sm text-gray-500 truncate">
                                    Jumlah: <strong>{{ $kelas->siswa_count }} Siswa</strong>
                                </p>
                            </div>

                            {{-- Aksi (Sebelah Kanan) --}}
                            <div class="mt-4 flex items-center space-x-3 sm:mt-0 sm:ml-6">
                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>

                                <select name="promosi[{{ $kelas->id }}]" 
                                        class="block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                    
                                    {{-- Opsi 1: Tinggal Kelas (Default) --}}
                                    <option value="jangan_pindahkan" selected>
                                        -- Tahan Siswa di Kelas Ini --
                                    </option>
                                    
                                    {{-- Opsi 2: Luluskan (Hanya tampil jika kelas 9) --}}
                                    @if($kelas->tingkat == 9) {{-- Asumsi 9 adalah tingkat akhir (sesuaikan jika perlu) --}}
                                        <option value="luluskan" class="font-bold text-red-600">
                                            LULUSKAN SEMUA SISWA
                                        </option>
                                    
                                    {{-- Opsi 3: Naik Kelas (Hanya tampil jika BUKAN kelas 9) --}}
                                    @else
                                        @php
                                            $targetTingkat = (int)$kelas->tingkat + 1;
                                        @endphp
                                        
                                        <optgroup label="Pindahkan ke Kelas {{ $targetTingkat }}">
                                            @foreach($targetKelasList as $targetKelas)
                                                {{-- Filter: Hanya tampilkan kelas di tingkat target --}}
                                                @if($targetKelas->tingkat == $targetTingkat)
                                                    <option value="{{ $targetKelas->id }}">
                                                        Pindah ke: {{ $targetKelas->tingkat }} - {{ $targetKelas->nama_kelas }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endif
                                    
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @empty
            <div class="py-8 text-center text-gray-500">
                Belum ada data kelas yang bisa dipromosikan.
            </div>
        @endforelse

    </div>

    {{-- Tombol Aksi Bawah --}}
    <div class="mt-12 flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
        <a href="{{ route('kelas.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
            Batal
        </a>
        <button type="submit" 
           class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
           PROSES KENAIKAN KELAS
        </button>
    </div>
</form>
@endsection