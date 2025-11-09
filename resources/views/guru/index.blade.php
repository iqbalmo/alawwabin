@extends('layouts.app')

@section('title', 'Daftar Guru - SITU Al-Awwabin')

@section('content')

{{-- 1. Header Halaman --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Guru</h2>
        <p class="mt-2 text-sm text-gray-600">
            Daftar semua guru yang terdaftar di dalam sistem.
        </p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('guru.create') }}" 
           class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
           + Tambah Guru
        </a>
    </div>
</div>

{{-- 2. Wrapper Tabel --}}
<div class="mt-8 flow-root">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full">
                
                {{-- 3. Header Tabel (Diperbarui) --}}
                <thead class="sticky top-0 bg-[#F0E6D2]">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">No</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">NIP</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Jabatan</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Mapel Utama</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>

                {{-- 4. Body Tabel (Diperbarui) --}}
                <tbody class="text-gray-700">
                    @forelse($guru as $g)
                        <tr>
                            <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">{{ $loop->iteration + ($guru->currentPage() - 1) * $guru->perPage() }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                <div class="font-bold text-[#333333]">{{ $g->nama }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $g->nip ?? '-' }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $g->jabatan ?? '-' }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                {{ $g->mapel->nama_mapel ?? '-' }}
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                @if($g->status_kepegawaian == 'PNS')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">PNS</span>
                                @elseif($g->status_kepegawaian == 'Swasta')
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Swasta</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex items-center justify-end space-x-4">
                                    {{-- Nanti Anda bisa buatkan halaman 'show' untuk guru jika perlu --}}
                                    {{-- <a href="#" class="text-gray-600 hover:text-gray-900">Detail</a> --}}
                                    <a href="{{ route('guru.edit', $g->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">
                                        Edit<span class="sr-only">, {{ $g->nama }}</span>
                                    </a>
                                    <form action="{{ route('guru.destroy', $g->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus guru ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Hapus<span class="sr-only">, {{ $g->nama }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                Tidak ada data guru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- 5. Paginasi --}}
            <div class="mt-4">
                {{ $guru->links() }}
            </div>
        </div>
    </div>
</div>
@endsection