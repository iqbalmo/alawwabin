@extends('layouts.app')

@section('title', 'Daftar Kelas | SITU Al-Awwabin')

@section('content')
    {{-- Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Kelas</h2>
            <p class="mt-2 text-sm text-gray-600">
                Daftar semua kelas yang terdaftar, dikelompokkan berdasarkan tingkat.
            </p>
        </div>
        @can('manage kelas')
            <div class="mt-4 sm:mt-0 sm:ml-16">
                <a href="{{ route('kelas.create') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-[#C8963E] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 transition-all">
                    + Tambah Kelas
                </a>
            </div>
        @endcan
    </div>

    {{-- Wrapper Tabel yang Dikelompokkan --}}
    <div class="space-y-10">

        @forelse($groupedKelas as $tingkat => $kelasDiTingkat)

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Judul Kelompok -->
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-[#2C5F2D]">
                        Kelompok Kelas {{ $tingkat }}
                    </h3>
                    <span class="inline-flex items-center rounded-md bg-white px-2.5 py-0.5 text-sm font-medium text-[#2C5F2D] shadow-sm ring-1 ring-inset ring-gray-300">
                        {{ $kelasDiTingkat->count() }} Kelas
                    </span>
                </div>

                <!-- Tampilan Mobile (Card View) -->
                <div class="block sm:hidden divide-y divide-gray-100">
                    @foreach ($kelasDiTingkat as $k)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-[#2C5F2D] font-bold text-sm">
                                        {{ $k->tingkat }}
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-[#333333]">{{ $k->nama_kelas }}</h4>
                                        <p class="text-xs text-gray-500">Wali: {{ $k->wali?->nama ?? 'Belum ada' }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                    {{ $k->siswa_count }} Siswa
                                </span>
                            </div>
                            
                            <div class="mt-3 flex items-center justify-end gap-3 border-t border-gray-50 pt-3">
                                @can('manage kelas')
                                    <a href="{{ route('kelas.edit', $k->id) }}" class="text-sm font-medium text-[#C8963E] hover:text-[#b58937]">
                                        Edit
                                    </a>
                                    <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                                <a href="{{ route('kelas.show', $k->id) }}" class="inline-flex items-center justify-center rounded-md bg-[#2C5F2D] px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-[#214621]">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tampilan Desktop (Tabel) -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wali Kelas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Siswa</th>
                                <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($kelasDiTingkat as $k)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-9 w-9 rounded-full bg-green-100 flex items-center justify-center text-[#2C5F2D] font-bold text-xs mr-3">
                                                {{ $k->tingkat }}
                                            </div>
                                            <div class="text-sm font-bold text-[#333333]">{{ $k->nama_kelas }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $k->wali?->nama ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            {{ $k->siswa_count }} Siswa
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('kelas.show', $k->id) }}" class="text-blue-600 hover:text-blue-800">Lihat</a>
                                            @can('manage kelas')
                                                <a href="{{ route('kelas.edit', $k->id) }}" class="text-[#C8963E] hover:text-[#b58937]">Edit</a>
                                                <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada data kelas</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan kelas baru.</p>
                <div class="mt-6">
                    <a href="{{ route('kelas.create') }}" class="inline-flex items-center rounded-md bg-[#C8963E] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        + Tambah Kelas
                    </a>
                </div>
            </div>
        @endforelse

    </div>
@endsection
