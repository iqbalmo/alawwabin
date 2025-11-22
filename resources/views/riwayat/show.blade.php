@extends('layouts.app')

@section('title', 'Detail Rekap Absensi | SIAP Al-Awwabin')

@section('content')
<h2 class="text-2xl font-bold text-[#2C5F2D] mb-4">Detail Rekap Absensi</h2>

<p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($rekap->tanggal)->translatedFormat('d F Y') }}</p>
<p><strong>Guru:</strong> {{ $rekap->jadwal->guru->nama ?? '-' }}</p>
<p><strong>Tingkat:</strong> {{ $rekap->jadwal->kelas->tingkat ?? '-' }}</p>
<p><strong>Kelas:</strong> {{ $rekap->jadwal->kelas->nama_kelas ?? '-' }}</p>
<p><strong>Mata Pelajaran:</strong> {{ $rekap->jadwal->mapel->nama_mapel ?? '-' }}</p>

<table class="min-w-full border border-gray-200 mt-4">
    <thead class="bg-[#F0E6D2]">
        <tr>
            <th class="px-3 py-2 text-left text-sm font-semibold">Nama Siswa</th>
            <th class="px-3 py-2 text-left text-sm font-semibold">Status</th>
            <th class="px-3 py-2 text-left text-sm font-semibold">Catatan</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-t border-gray-200">
            <td class="px-3 py-2 text-sm">{{ $rekap->siswa->nama ?? '-' }}</td>
            <td class="px-3 py-2 text-sm">{{ $rekap->status }}</td>
            <td class="px-3 py-2 text-sm">{{ $rekap->catatan ?? '-' }}</td>
        </tr>
    </tbody>
</table>

<a href="{{ route('riwayat.index') }}" class="inline-block mt-4 text-[#C8963E] hover:text-[#b58937]">&larr; Kembali</a>
@endsection
