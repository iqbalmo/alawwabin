{{-- resources/views/jadwal/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Jadwal | SITU Al-Awwabin') {{-- Judul Tab Browser --}}

@section('content')

{{-- 1. Header Halaman (Judul, Deskripsi, dan Tombol) --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Jadwal Guru</h2>
        <p class="mt-2 text-sm text-gray-600">
            Daftar lengkap jadwal mengajar guru di semua kelas.
        </p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('jadwal.create') }}" 
           class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
           + Tambah Jadwal
        </a>
    </div>
</div>

{{-- 2. Pesan Sukses (jika ada) - Disesuaikan untuk tema terang --}}
@if(session('success'))
    <div class="mt-6 rounded-md bg-green-500/20 p-4 border border-green-500/30">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

{{-- 3. Wrapper Tabel untuk Responsivitas --}}
<div class="mt-8 flow-root">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full">
                
                {{-- 4. Header Tabel --}}
                <thead class="sticky top-0 bg-[#F0E6D2]">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Hari</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Jam</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Mata Pelajaran</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Guru</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>

                {{-- 5. Body Tabel --}}
                <tbody class="text-gray-700">
                    @forelse($jadwals as $jadwal)
                        <tr>
                            <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">
                                <div class="font-bold text-[#333333]">{{ $jadwal->hari }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $jadwal->mapel->nama_mapel ?? '-' }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $jadwal->guru->nama ?? '-' }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $jadwal->kelas->nama_kelas ?? '-' }}</td>
                            <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex items-center justify-end space-x-4">
                                    {{-- (Tambahkan link Edit & Hapus di sini nanti) --}}
                                    <a href="#" class="text-[#2C5F2D] hover:text-[#214621]">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                Belum ada data jadwal.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection