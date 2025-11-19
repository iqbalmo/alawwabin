@extends('layouts.app')

@section('title', 'Daftar Ekstrakurikuler | SITU Al-Awwabin')

@section('content')

    {{-- Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Ekstrakurikuler</h2>
            <p class="mt-2 text-sm text-gray-600">
                Kelola semua kegiatan ekstrakurikuler di sekolah.
            </p>
        </div>
        @can('manage ekskul')
        <div class="mt-4 sm:mt-0 sm:ml-16">
            <a href="{{ route('ekskul.create') }}" 
               class="inline-flex items-center justify-center rounded-lg bg-[#C8963E] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 transition-all">
               + Tambah Ekskul
            </a>
        </div>
        @endcan
    </div>

    {{-- Wrapper Konten --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        {{-- Tampilan Mobile (Card View) --}}
        <div class="block sm:hidden divide-y divide-gray-100">
            @forelse($ekskuls as $ekskul)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h4 class="text-base font-bold text-[#333333]">{{ $ekskul->nama_ekskul }}</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $ekskul->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            {{ $loop->iteration }}
                        </span>
                    </div>
                    
                    <div class="mt-2 text-sm text-gray-600">
                        <span class="font-medium">Pembina:</span> {{ $ekskul->pembina?->nama ?? '-' }}
                    </div>

                    <div class="mt-3 flex items-center justify-end gap-3 border-t border-gray-50 pt-3">
                        @can('manage ekskul')
                            <a href="{{ route('ekskul.show', $ekskul->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                Anggota
                            </a>
                            <a href="{{ route('ekskul.edit', $ekskul->id) }}" class="text-sm font-medium text-[#C8963E] hover:text-[#b58937]">
                                Edit
                            </a>
                            <form action="{{ route('ekskul.destroy', $ekskul->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus ekskul ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                    Hapus
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    Belum ada data ekstrakurikuler.
                </div>
            @endforelse
        </div>

        {{-- Tampilan Desktop (Tabel) --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#F0E6D2]">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-[#2C5F2D] uppercase tracking-wider w-16">No</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#2C5F2D] uppercase tracking-wider">Nama Ekstrakurikuler</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#2C5F2D] uppercase tracking-wider">Guru Pembina</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right text-sm font-semibold text-[#2C5F2D] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ekskuls as $ekskul)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-3 py-4 text-sm">
                                <div class="font-bold text-[#333333]">{{ $ekskul->nama_ekskul }}</div>
                                <div class="text-gray-500 text-xs truncate max-w-xs">{{ $ekskul->deskripsi }}</div>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-600">
                                {{ $ekskul->pembina?->nama ?? '-' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @can('manage ekskul')
                                <div class="flex items-center justify-end gap-4">
                                    <a href="{{ route('ekskul.show', $ekskul->id) }}" class="text-blue-600 hover:text-blue-800">Lihat Anggota</a>
                                    <a href="{{ route('ekskul.edit', $ekskul->id) }}" class="text-[#C8963E] hover:text-[#b58937]">Edit</a>
                                    <form action="{{ route('ekskul.destroy', $ekskul->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus ekskul ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500">
                                Tidak ada data ekstrakurikuler.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection