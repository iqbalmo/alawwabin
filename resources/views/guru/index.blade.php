@extends('layouts.app')

@section('title', 'Daftar Guru - SITU Al-Awwabin')
@section('header-title', 'Data Guru')

@section('content')

{{-- 1. Header Halaman (Judul, Deskripsi, dan Tombol) --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Data Guru</h2>
        <p class="mt-2 text-sm text-gray-600">
            Daftar semua guru di akun Anda termasuk nama, mata pelajaran, dan gaji pokok.
        </p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('guru.create') }}" 
           class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
           + Tambah Guru
        </a>
    </div>
</div>

{{-- 2. Wrapper Tabel --}}
<div class="mt-8 flow-root">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full">
                
                {{-- 3. Header Tabel --}}
                <thead class="sticky top-0 bg-[#F0E6D2]">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider sm:pl-6">Nama</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Mata Pelajaran</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Telepon</th>
                        {{-- 👇 KOLOM BARU 👇 --}}
                        <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-[#333333] uppercase tracking-wider">Gaji Pokok (Rp)</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>

                {{-- 4. Body Tabel --}}
                <tbody class="text-gray-700 bg-white">
                    @forelse($gurus as $guru)
                        {{-- Hover effect untuk setiap baris --}}
                        <tr class="hover:bg-gray-50">
                            <td class="border-t border-gray-200 py-4 pl-4 pr-3 text-sm sm:pl-6">
                                <div class="font-bold text-[#333333]">{{ $guru->nama }}</div>
                                {{-- NIP bisa ditampilkan di bawah nama --}}
                                <div class="text-gray-500">{{ $guru->nip }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-4 text-sm whitespace-nowrap">{{ $guru->mapel->nama_mapel ?? '-' }}</td>
                            <td class="border-t border-gray-200 px-3 py-4 text-sm whitespace-nowrap">{{ $guru->telepon }}</td>
                            {{-- 👇 DATA BARU 👇 --}}
                            <td class="border-t border-gray-200 px-3 py-4 text-sm text-right whitespace-nowrap">
                                {{ number_format($guru->gaji_pokok, 0, ',', '.') }}
                            </td>
                            <td class="border-t border-gray-200 relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('guru.edit', $guru->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">
                                        Edit<span class="sr-only">, {{ $guru->nama }}</span>
                                    </a>
                                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus guru ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Hapus<span class="sr-only">, {{ $guru->nama }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan jika tidak ada data --}}
                        <tr>
                            {{-- 👇 Colspan diubah menjadi 5 👇 --}}
                            <td colspan="5" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                Tidak ada data guru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection