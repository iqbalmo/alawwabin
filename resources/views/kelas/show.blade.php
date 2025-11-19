@extends('layouts.app')

@section('title', 'Detail Kelas: ' . $kelas->tingkat . ' ' . $kelas->nama_kelas)

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- Header Halaman --}}
        <div class="mb-6 sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#2C5F2D]">Kelas {{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</h1>
                <p class="mt-2 text-sm text-gray-600 flex items-center gap-3">
                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                        Wali Kelas: {{ $kelas->wali?->nama ?? 'Belum ditentukan' }}
                    </span>
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                        {{ $kelas->siswa->count() }} Siswa
                    </span>
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('kelas.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2 transition-colors">
                   &larr; Kembali
                </a>
                
                <form action="{{ route('kelas.reorderAbsen', $kelas->id) }}" method="POST" onsubmit="return confirm('Ini akan mengganti semua nomor absen siswa di kelas ini berdasarkan urutan abjad. Lanjutkan?');">
                    @csrf
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2 transition-colors">
                        Urutkan Absen
                    </button>
                </form>

                @can('manage kelas')
                <a href="{{ route('kelas.edit', $kelas->id) }}"
                   class="inline-flex items-center justify-center rounded-lg bg-[#C8963E] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 transition-colors">
                   Edit Kelas
                </a>
                @endcan
            </div>
        </div>

        {{-- Daftar Siswa --}}
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-[#2C5F2D]">Daftar Siswa</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Absen</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">L/P</th>
                            <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($kelas->siswa as $siswa)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    {{ $siswa->no_absen ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $siswa->nis ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-[#333333]">{{ $siswa->nama }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $siswa->jenis_kelamin }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('siswa.show', $siswa->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="mt-2 text-sm font-medium">Belum ada siswa di kelas ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
