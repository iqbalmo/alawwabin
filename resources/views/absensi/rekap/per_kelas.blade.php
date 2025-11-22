@extends('layouts.app')

@section('title', 'Rekap Absensi ' . $kelas->nama_kelas . ' | SIAP Al-Awwabin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('absensi.rekap.index') }}" class="hover:text-[#C8963E]">Rekap Absensi</a>
                <span>→</span>
                <span class="text-gray-900 font-medium">{{ $kelas->nama_kelas }}</span>
            </div>
            <h1 class="text-2xl font-bold text-[#2C5F2D]">Rekap Absensi {{ $kelas->nama_kelas }}</h1>
            <p class="mt-1 text-sm text-gray-600">Periode: {{ \Carbon\Carbon::parse("$tahun-$bulan-01")->translatedFormat('F') }} {{ $tahun }}</p>
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

    {{-- Student List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-[#2C5F2D]">Daftar Siswa</h3>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sakit</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Izin</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Alpa</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($siswaStats as $index => $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $data['siswa']->nama }}</div>
                                        <div class="text-xs text-gray-500">NIS: {{ $data['siswa']->nis }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-600 font-medium">
                                {{ $data['stats']['hadir'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-600 font-medium">
                                {{ $data['stats']['sakit'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-blue-600 font-medium">
                                {{ $data['stats']['izin'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <span class="{{ $data['stats']['alpa'] > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                    {{ $data['stats']['alpa'] }}
                                </span>
                                @if($data['stats']['alpa'] > ($data['stats']['total'] * 0.05))
                                    <span class="ml-1 text-red-500" title="Alpa lebih dari 5%">⚠️</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 font-medium">
                                {{ $data['stats']['total'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $data['stats']['persentase_hadir'] >= 90 ? 'bg-green-100 text-green-800' : 
                                       ($data['stats']['persentase_hadir'] >= 75 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $data['stats']['persentase_hadir'] }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <a href="{{ route('absensi.rekap.siswa', ['siswa' => $data['siswa']->id, 'bulan' => $bulan, 'tahun' => $tahun, 'tahun_ajaran_id' => $selectedTahunAjaran?->id]) }}" 
                                   class="text-[#C8963E] hover:text-[#b58937] font-medium">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden p-4 space-y-4">
            @forelse($siswaStats as $index => $data)
                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $data['siswa']->nama }}</h4>
                            <p class="text-xs text-gray-500">NIS: {{ $data['siswa']->nis }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $data['stats']['persentase_hadir'] >= 90 ? 'bg-green-100 text-green-800' : 
                               ($data['stats']['persentase_hadir'] >= 75 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $data['stats']['persentase_hadir'] }}%
                        </span>
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
                    @if($data['stats']['alpa'] > ($data['stats']['total'] * 0.05))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-2 text-xs text-red-700">
                            ⚠️ Alpa lebih dari 5%
                        </div>
                    @endif
                    <a href="{{ route('absensi.rekap.siswa', ['siswa' => $data['siswa']->id, 'bulan' => $bulan, 'tahun' => $tahun, 'tahun_ajaran_id' => $selectedTahunAjaran?->id]) }}" 
                       class="block text-center py-2 bg-[#C8963E] text-white rounded-lg hover:bg-[#b58937] transition-colors text-sm font-medium">
                        Lihat Detail
                    </a>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">Tidak ada data siswa.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
