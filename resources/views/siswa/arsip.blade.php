@extends('layouts.app')

@section('title', 'Arsip Siswa Lulus | SITU Al-Awwabin')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Arsip Siswa Lulus</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Daftar siswa yang telah menyelesaikan studi, dikelompokkan berdasarkan tahun kelulusan.
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('siswa.index') }}" 
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2 transition-colors">
                   &larr; Kembali ke Siswa Aktif
                </a>
            </div>
        </div>

        <div class="space-y-12">
            @forelse($arsipPerTahun as $tahun => $siswaLulus)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Header Tahun --}}
                    <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-[#2C5F2D]">
                            Angkatan Lulus Tahun {{ $tahun }}
                        </h3>
                        <span class="inline-flex items-center rounded-full bg-white px-2.5 py-0.5 text-xs font-medium text-gray-800 shadow-sm">
                            {{ count($siswaLulus) }} Siswa
                        </span>
                    </div>

                    {{-- Mobile View (Cards) --}}
                    <div class="block sm:hidden p-4 space-y-4">
                        @foreach($siswaLulus as $siswa)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-[#333333]">{{ $siswa->nama }}</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">NIS: {{ $siswa->nis }}</p>
                                    </div>
                                    <span class="inline-flex items-center rounded-full bg-gray-200 px-2 py-1 text-xs font-medium text-gray-700">
                                        {{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mb-3">
                                    <p><span class="text-gray-400 text-xs">NISN:</span> {{ $siswa->nisn ?? '-' }}</p>
                                </div>
                                <div class="pt-3 border-t border-gray-200 flex justify-end">
                                    <a href="{{ route('siswa.show', $siswa->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop View (Table) --}}
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">NIS / NISN</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Nama Lengkap</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Jenis Kelamin</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-6">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($siswaLulus as $siswa)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm text-gray-500">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <div class="font-medium text-gray-900">{{ $siswa->nis }}</div>
                                            <div class="text-xs">{{ $siswa->nisn ?? '-' }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-[#333333]">
                                            {{ $siswa->nama }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                            <a href="{{ route('siswa.show', $siswa->id) }}" class="text-blue-600 hover:text-blue-900">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada data arsip</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada siswa yang tercatat lulus dalam sistem.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection