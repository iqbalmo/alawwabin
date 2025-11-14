@extends('layouts.app')

@section('title', 'Daftar Siswa | SITU Al-Awwabin')
@section('header-title', 'Daftar Siswa')

@section('content')

{{-- 1. Header Halaman (Judul, Deskripsi, dan Tombol) --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Siswa</h2>
        <p class="mt-2 text-sm text-gray-600">
            Daftar semua siswa yang terdaftar di dalam sistem.
        </p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('siswa.create') }}" 
           class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
           + Tambah Siswa
        </a>
    </div>
</div>

<div class="mt-6">
    <form action="{{ route('siswa.index') }}" method="GET" class="flex items-center space-x-3 w-full">
        <div class="flex-grow max-w-sm">
            <label for="search" class="sr-only">Cari siswa</label>
            <input type="text" name="search" id="search"
                   class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm"
                   placeholder="Cari berdasarkan nama atau NIS..."
                   value="{{ $search ?? '' }}">
        </div>

        <button type="submit"
                class="inline-flex items-center rounded-md border border-transparent bg-[#2C5F2D] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#214621]">
            Cari
        </button>

        <a href="{{ route('siswa.index') }}"
           class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
            Reset
        </a>
    </form>
</div>


{{-- 2. Wrapper Tabel untuk Responsivitas --}}
<div class="mt-8 flow-root">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full">
                
                {{-- 3. Header Tabel --}}
                <thead class="sticky top-0 bg-[#F0E6D2]">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">No</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">NIS / NISN</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Jenis Kelamin</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Kontak Ayah</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>

                {{-- 4. Body Tabel --}}
                <tbody class="text-gray-700">
                    @forelse($siswa as $s)
                        <tr>
                            <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">
                                {{-- Penomoran untuk paginasi --}}
                                {{ ($siswa->currentPage() - 1) * $siswa->perPage() + $loop->iteration }}
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                <div class="font-bold text-[#333333]">{{ $s->nama }}</div>
                                <div class="text-gray-500">{{ $s->nik_siswa ?? 'NIK: -' }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                <div class="font-medium text-[#333333]">NIS: {{ $s->nis }}</div>
                                <div class="text-gray-500">NISN: {{ $s->nisn ?? '-' }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : ($s->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                {{ $s->kelas->tingkat ?? '' }} - {{ $s->kelas->nama_kelas ?? '-' }}
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                <div>{{ $s->nama_ayah ?? 'Ayah' }}</div>
                                <div class="text-gray-500">{{ $s->hp_ayah ?? '-' }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                @if($s->status_mukim == 'MUKIM')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                        Mukim
                                    </span>
                                @elseif($s->status_mukim == 'NON MUKIM')
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                        Non Mukim
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                        -
                                    </span>
                                @endif
                            </td>
                            <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex items-center justify-end space-x-4">
                                    {{-- TOMBOL DETAIL BARU --}}
                                    <a href="{{ route('siswa.show', $s->id) }}" class="text-blue-600 hover:text-blue-800">
                                        Detail<span class="sr-only">, {{ $s->nama }}</span>
                                    </a>
                                    
                                    <a href="{{ route('siswa.edit', $s->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">
                                        Edit<span class="sr-only">, {{ $s->nama }}</span>
                                    </a>
                                    <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini? Seluruh data terkait (nilai, dll) akan ikut terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Hapus<span class="sr-only">, {{ $s->nama }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan jika tidak ada data --}}
                        <tr>
                            <td colspan="8" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                Belum ada data siswa. <a href="{{ route('siswa.create') }}" class="font-medium text-[#2C5F2D] hover:text-[#214621]">Tambah siswa baru</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Link Paginasi --}}
            <div class="mt-8">
                {{ $siswa->links() }}
            </div>

        </div>
    </div>
</div>
@endsection