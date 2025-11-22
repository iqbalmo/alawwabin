@extends('layouts.app')

@section('title', 'Riwayat Rekap Absensi | SIAP Al-Awwabin')

@section('content')
<h2 class="text-2xl font-bold text-[#2C5F2D] mb-4">Riwayat Rekap Absensi</h2>

<table class="min-w-full border border-gray-200">
    <thead class="bg-[#F0E6D2]">
        <tr>
            <th class="px-3 py-2 text-left text-sm font-semibold">Tanggal</th>
            <th class="px-3 py-2 text-left text-sm font-semibold">Guru</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Tingkat</th>
            <th class="px-3 py-2 text-left text-sm font-semibold">Kelas</th>
            <th class="px-3 py-2 text-left text-sm font-semibold">Mata Pelajaran</th>
            <th class="px-3 py-2 text-left text-sm font-semibold">Jumlah Siswa</th>
            <th class="px-3 py-2 text-left text-sm font-semibold">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rekaps as $rekap)
            <tr class="border-t border-gray-200">
                <td class="px-3 py-2 text-sm">{{ \Carbon\Carbon::parse($rekap->tanggal)->translatedFormat('d F Y') }}</td>
                <td class="px-3 py-2 text-sm">{{ $rekap->jadwal->guru->nama ?? '-' }}</td>
                <td class="px-3 py-4 text-sm text-gray-900">{{ $rekap->jadwal->kelas->tingkat ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">{{ $rekap->jadwal->kelas->nama_kelas ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">{{ $rekap->jadwal->mapel->nama_mapel ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">
                    {{ $rekap->siswa ? 1 : 0 }}
                </td>
                <td class="px-3 py-2 text-sm">
                    <a href="{{ route('riwayat.show', $rekap->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">Detail</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-3 py-4 text-center text-gray-500">Belum ada riwayat rekap absensi.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
