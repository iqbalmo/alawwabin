@extends('layouts.app')

@section('title', 'Daftar Siswa - SITU Al-Awwabin') {{-- Judul Tab Browser --}}

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
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">NIS</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Tanggal Lahir</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>

                {{-- 4. Body Tabel --}}
                <tbody class="text-gray-700">
                    @forelse($siswa as $s)
                        <tr>
                            {{-- Border diubah ke abu-abu muda --}}
                            <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">{{ $loop->iteration }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                <div class="font-bold text-[#333333]">{{ $s->nama }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $s->nis }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $s->tanggal_lahir }}</td>
                            <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('siswa.edit', $s->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">
                                        Edit<span class="sr-only">, {{ $s->nama }}</span>
                                    </a>
                                    <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
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
                            <td colspan="6" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                Tidak ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection