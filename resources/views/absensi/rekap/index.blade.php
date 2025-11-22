@extends('layouts.app')

@section('title', 'Rekap Absensi | SITU Al-Awwabin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#2C5F2D]">Rekap Absensi Sekolah</h1>
            <p class="mt-1 text-sm text-gray-600">Statistik kehadiran siswa per kelas</p>
        </div>

        {{-- Filter --}}
        <form method="GET" class="flex flex-wrap gap-2">
            <select name="tahun_ajaran_id" class="rounded-lg border-gray-300 text-sm focus:ring-[#C8963E] focus:border-[#C8963E]">
                @foreach($tahunAjarans as $ta)
                    <option value="{{ $ta->id }}" {{ $selectedTahunAjaran && $selectedTahunAjaran->id == $ta->id ? 'selected' : '' }}>
                        {{ $ta->nama }} @if($ta->is_active) ⭐ @endif
                    </option>
                @endforeach
            </select>
            <select name="bulan" class="rounded-lg border-gray-300 text-sm focus:ring-[#C8963E] focus:border-[#C8963E]">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="rounded-lg border-gray-300 text-sm focus:ring-[#C8963E] focus:border-[#C8963E]">
                @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="px-4 py-2 bg-[#C8963E] text-white rounded-lg hover:bg-[#b58937] transition-colors text-sm font-medium">
                Filter
            </button>
        </form>
    </div>

    {{-- Dashboard Statistics --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        {{-- 1. Ringkasan Hari Ini (Full Width on Mobile, 1 Col on Desktop) --}}
        <div class="lg:col-span-3">
            <h2 class="text-lg font-semibold text-[#2C5F2D] mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                Ringkasan Absensi Hari Ini
                <span class="text-xs font-normal text-gray-500 ml-2">({{ \Carbon\Carbon::now()->translatedFormat('d F Y') }})</span>
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-green-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Hadir</p>
                        <p class="text-2xl font-bold text-green-600">{{ $todayStats['hadir'] }}</p>
                    </div>
                    <div class="bg-green-50 p-2 rounded-lg">
                        <span class="text-green-600 text-xs font-bold">H</span>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-yellow-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sakit</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $todayStats['sakit'] }}</p>
                    </div>
                    <div class="bg-yellow-50 p-2 rounded-lg">
                        <span class="text-yellow-600 text-xs font-bold">S</span>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-blue-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Izin</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $todayStats['izin'] }}</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded-lg">
                        <span class="text-blue-600 text-xs font-bold">I</span>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-red-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Alpa</p>
                        <p class="text-2xl font-bold text-red-600">{{ $todayStats['alpa'] }}</p>
                    </div>
                    <div class="bg-red-50 p-2 rounded-lg">
                        <span class="text-red-600 text-xs font-bold">A</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Insight Bulanan --}}
        <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Kelas Terajin --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-[#F0E6D2]/30 flex justify-between items-center">
                    <h3 class="font-semibold text-[#2C5F2D]">🏆 Kelas Terajin</h3>
                    <span class="text-xs text-gray-500">Bulan Ini</span>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($topClasses as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full {{ $loop->iteration == 1 ? 'bg-yellow-100 text-yellow-700' : ($loop->iteration == 2 ? 'bg-gray-100 text-gray-700' : 'bg-orange-100 text-orange-700') }} text-xs font-bold">
                                    {{ $loop->iteration }}
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item['kelas']->nama_kelas }}</p>
                                    <p class="text-xs text-gray-500">{{ $item['kelas']->siswa_count }} Siswa</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-[#2C5F2D]">{{ $item['stats']['persentase_hadir'] }}%</span>
                                <p class="text-[10px] text-gray-400">Kehadiran</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada data.</p>
                    @endforelse
                </div>
            </div>

            {{-- Siswa Perlu Perhatian --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-red-50/30 flex justify-between items-center">
                    <h3 class="font-semibold text-red-700">⚠️ Perlu Perhatian</h3>
                    <span class="text-xs text-gray-500">Top Alpa Bulan Ini</span>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($topAbsentees as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-600 text-xs font-bold">
                                    {{ substr($item['siswa']->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ Str::limit($item['siswa']->nama, 20) }}</p>
                                    <p class="text-xs text-gray-500">{{ $item['siswa']->kelas->nama_kelas ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-red-600">{{ $item['jumlah_alpa'] }}</span>
                                <p class="text-[10px] text-gray-400">Alpa</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Tidak ada siswa dengan Alpa.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Class List --}}
    <div class="space-y-6">
        @forelse($kelasData as $tingkat => $kelasGroup)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-[#2C5F2D] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-white">Tingkat {{ $tingkat }}</h3>
                </div>

                {{-- Desktop Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sakit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Izin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alpa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($kelasGroup as $data)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-medium text-gray-900">{{ $data['kelas']->nama_kelas }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $data['kelas']->siswa_count }} siswa
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                        {{ $data['stats']['hadir'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-medium">
                                        {{ $data['stats']['sakit'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                                        {{ $data['stats']['izin'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">
                                        {{ $data['stats']['alpa'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $data['stats']['persentase_hadir'] >= 90 ? 'bg-green-100 text-green-800' : 
                                               ($data['stats']['persentase_hadir'] >= 75 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $data['stats']['persentase_hadir'] }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('absensi.rekap.kelas', ['kelas' => $data['kelas']->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" 
                                           class="text-[#C8963E] hover:text-[#b58937] font-medium">
                                            Lihat Detail →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="md:hidden p-4 space-y-4">
                    @foreach($kelasGroup as $data)
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="font-semibold text-gray-900">{{ $data['kelas']->nama_kelas }}</h4>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $data['stats']['persentase_hadir'] >= 90 ? 'bg-green-100 text-green-800' : 
                                       ($data['stats']['persentase_hadir'] >= 75 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $data['stats']['persentase_hadir'] }}%
                                </span>
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $data['kelas']->siswa_count }} siswa
                            </div>
                            <div class="grid grid-cols-4 gap-2 text-center text-sm">
                                <div>
                                    <p class="text-green-600 font-semibold">{{ $data['stats']['hadir'] }}</p>
                                    <p class="text-xs text-gray-500">Hadir</p>
                                </div>
                                <div>
                                    <p class="text-yellow-600 font-semibold">{{ $data['stats']['sakit'] }}</p>
                                    <p class="text-xs text-gray-500">Sakit</p>
                                </div>
                                <div>
                                    <p class="text-blue-600 font-semibold">{{ $data['stats']['izin'] }}</p>
                                    <p class="text-xs text-gray-500">Izin</p>
                                </div>
                                <div>
                                    <p class="text-red-600 font-semibold">{{ $data['stats']['alpa'] }}</p>
                                    <p class="text-xs text-gray-500">Alpa</p>
                                </div>
                            </div>
                            <a href="{{ route('absensi.rekap.kelas', ['kelas' => $data['kelas']->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" 
                               class="block text-center py-2 bg-[#C8963E] text-white rounded-lg hover:bg-[#b58937] transition-colors text-sm font-medium">
                                Lihat Detail
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <p class="text-gray-500">Tidak ada data kelas.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
