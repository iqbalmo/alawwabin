@extends('layouts.app')

@section('title', 'Daftar Ekstrakurikuler | SITU Al-Awwabin')
@section('header-title', 'Ekstrakurikuler')

@section('content')

{{-- 1. Header Halaman --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Ekstrakurikuler</h2>
        <p class="mt-2 text-sm text-gray-600">
            Kelola semua kegiatan ekstrakurikuler di sekolah.
        </p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('ekskul.create') }}" 
           class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
           + Tambah Ekskul Baru
        </a>
    </div>
</div>

{{-- 2. Wrapper Tabel --}}
<div class="mt-8 flow-root">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full">
                <thead class="sticky top-0 bg-[#F0E6D2]">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">No</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Nama Ekstrakurikuler</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Guru Pembina</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($ekskuls as $ekskul)
                        <tr>
                            <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">{{ $loop->iteration }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                <div class="font-bold text-[#333333]">{{ $ekskul->nama_ekskul }}</div>
                                <div class="text-gray-500 truncate max-w-xs">{{ $ekskul->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                {{ $ekskul->pembina?->nama ?? '-' }}
                            </td>
                            <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex items-center justify-end space-x-4">
                                    
                                    {{-- --- TAMBAHKAN TOMBOL INI --- --}}
                                    <a href="{{ route('ekskul.show', $ekskul->id) }}" class="text-gray-600 hover:text-gray-900">
                                        Lihat Anggota<span class="sr-only">, {{ $ekskul->nama_ekskul }}</span>
                                    </a>
                                    {{-- ----------------------------- --}}

                                    <a href="{{ route('ekskul.edit', $ekskul->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">
                                        Edit<span class="sr-only">, {{ $ekskul->nama_ekskul }}</span>
                                    </a>
                                    <form action="{{ route('ekskul.destroy', $ekskul->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus ekskul ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Hapus<span class="sr-only">, {{ $ekskul->nama_ekskul }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                Belum ada data ekstrakurikuler.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection