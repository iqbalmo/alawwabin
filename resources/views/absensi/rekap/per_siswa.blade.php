@extends('layouts.app')

@section('title', 'Rekap Absensi ' . $siswa->nama . ' | SITU Al-Awwabin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('absensi.rekap.index') }}" class="hover:text-[#C8963E]">Rekap Absensi</a>
                <span>→</span>
                <a href="{{ route('absensi.rekap.kelas', ['kelas' => $siswa->kelas_id, 'bulan' => $bulan, 'tahun' => $tahun, 'tahun_ajaran_id' => $selectedTahunAjaran?->id]) }}" class="hover:text-[#C8963E]">{{ $siswa->kelas->nama_kelas }}</a>
                <span>→</span>
                <span class="text-gray-900 font-medium">{{ $siswa->nama }}</span>
            </div>
            <h1 class="text-2xl font-bold text-[#2C5F2D]">{{ $siswa->nama }}</h1>
            <p class="mt-1 text-sm text-gray-600">NIS: {{ $siswa->nis }} | {{ $siswa->kelas->nama_kelas }}</p>
            <p class="text-sm text-gray-600">Periode: {{ \Carbon\Carbon::parse("$tahun-$bulan-01")->translatedFormat('F') }} {{ $tahun }}</p>
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
                        {{ \Carbon\Carbon::parse("2025-$i-01")->translatedFormat('F') }}
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

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['hadir'] }}</div>
            <div class="text-sm text-gray-600 mt-1">Hadir</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['sakit'] }}</div>
            <div class="text-sm text-gray-600 mt-1">Sakit</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $stats['izin'] }}</div>
            <div class="text-sm text-gray-600 mt-1">Izin</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="text-3xl font-bold text-red-600">{{ $stats['alpa'] }}</div>
            <div class="text-sm text-gray-600 mt-1">Alpa</div>
        </div>
        <div class="bg-[#F0E6D2] rounded-xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="text-3xl font-bold text-[#2C5F2D]">{{ $stats['persentase_hadir'] }}%</div>
            <div class="text-sm text-gray-600 mt-1">Kehadiran</div>
        </div>
    </div>

    {{-- Attendance History --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-[#2C5F2D]">Riwayat Absensi</h3>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendanceRecords as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->tanggal->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $record->tanggal->translatedFormat('l') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = [
                                        'hadir' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Hadir'],
                                        'sakit' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Sakit'],
                                        'izin' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Izin'],
                                        'alpa' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Alpa'],
                                    ];
                                    $config = $statusConfig[$record->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => ucfirst($record->status)];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                                    {{ $config['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $record->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada data absensi untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden p-4 space-y-3">
            @forelse($attendanceRecords as $record)
                <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $record->tanggal->translatedFormat('d F Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $record->tanggal->translatedFormat('l') }}</div>
                        </div>
                        @php
                            $statusConfig = [
                                'hadir' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Hadir'],
                                'sakit' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Sakit'],
                                'izin' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Izin'],
                                'alpa' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Alpa'],
                            ];
                            $config = $statusConfig[$record->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => ucfirst($record->status)];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                            {{ $config['label'] }}
                        </span>
                    </div>
                    @if($record->keterangan)
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Keterangan:</span> {{ $record->keterangan }}
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">Tidak ada data absensi untuk periode ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
