@extends('layouts.app')

@section('title', 'Daftar Rekap | SIAP Al-Awwabin')

@section('content')

<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Rekap Absensi</h2>
        <p class="mt-2 text-sm text-gray-600">Semua rekap absensi guru berdasarkan jadwal mengajar.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('rekap.create') }}"
           class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
           + Tambah Rekap
        </a>
    </div>
</div>

{{-- Pesan sukses --}}
@if(session('success'))
<div class="mt-6 rounded-md bg-green-500/20 p-4 border border-green-500/30">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

{{-- Tabel rekap --}}
<div class="mt-8 flow-root">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#F0E6D2] sticky top-0">
                    <tr>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Tanggal</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Guru</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Tingkat</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Kelas</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="relative px-3 py-3.5 text-right text-sm font-semibold text-[#333333] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rekaps as $rekap)
                        <tr>
                            <td class="px-3 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($rekap->tanggal)->translatedFormat('d F Y') }}</td>
                            <td class="px-3 py-4 text-sm text-gray-900">{{ $rekap->jadwal->guru->nama ?? '-' }}</td>
                            <td class="px-3 py-4 text-sm text-gray-900">{{ $rekap->jadwal->kelas->tingkat ?? '-' }}</td>
                            <td class="px-3 py-4 text-sm text-gray-900">{{ $rekap->jadwal->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-3 py-4 text-sm text-gray-900">{{ $rekap->jadwal->mapel->nama_mapel ?? '-' }}</td>
                            <td class="px-3 py-4 text-sm text-right space-x-2">
                            <a href="{{ route('rekap.edit', $rekap->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">Edit</a>
                            <form action="{{ route('rekap.destroy', $rekap->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-gray-500">Belum ada data rekap.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
