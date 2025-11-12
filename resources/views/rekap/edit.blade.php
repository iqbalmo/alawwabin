@extends('layouts.app')

@section('title', 'Edit Rekap Absensi | SITU Al-Awwabin')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Edit Rekap Absensi</h2>
        <p class="mt-2 text-sm text-gray-600">Ubah data rekap absensi guru sesuai jadwal.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('rekap.index') }}" class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937]">
           &larr; Kembali
        </a>
    </div>
</div>

@if ($errors->any())
<div class="mt-6 rounded-md bg-red-100 p-4 border border-red-300">
    <ul class="list-disc pl-5 text-red-700">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('rekap.update', $rekap->id) }}" method="POST" class="mt-6">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="jadwal_id" class="block text-sm font-medium text-gray-700">Pilih Jadwal</label>
        <select id="jadwal_id" name="jadwal_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D]/50" required>
            <option value="">-- Pilih Jadwal --</option>
            @foreach($jadwals as $jadwal)
                <option value="{{ $jadwal->id }}" {{ $rekap->jadwal_id == $jadwal->id ? 'selected' : '' }}>
                    {{ $jadwal->mapel->nama_mapel }} | {{ $jadwal->kelas->nama_kelas }} | {{ $jadwal->guru->nama ?? '-' }} | {{ $jadwal->hari }} ({{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" value="{{ $rekap->tanggal->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D]/50" required>
    </div>

    <div id="siswa-container" class="mt-6">
        <table class="min-w-full mt-4 border border-gray-200">
            <thead class="bg-[#F0E6D2]">
                <tr>
                    <th class="px-3 py-2 text-left text-sm font-semibold">Nama Siswa</th>
                    <th class="px-3 py-2 text-left text-sm font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-gray-200">
                    <td class="px-3 py-2 text-sm">{{ $rekap->siswa->nama ?? '-' }}</td>
                    <td class="px-3 py-2 text-sm">
                        <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D]/50">
                            <option value="Hadir" {{ $rekap->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="Izin" {{ $rekap->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                            <option value="Sakit" {{ $rekap->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="Alpha" {{ $rekap->status == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <button type="submit" class="mt-4 inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-6 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937]">
        Simpan Perubahan
    </button>
</form>
@endsection
