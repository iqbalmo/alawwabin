@extends('layouts.app')

@section('title', 'Manajemen Tahun Ajaran | SIAP Al-Awwabin')

@section('content')

    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Manajemen Tahun Ajaran</h2>
            <p class="mt-2 text-sm text-gray-600">
                Kelola tahun ajaran dan tentukan tahun ajaran aktif untuk sistem absensi.
            </p>
        </div>
        @can('manage siswa')
            <div class="mt-4 sm:mt-0 sm:ml-16">
                <a href="{{ route('tahun-ajaran.create') }}"
                    class="inline-flex items-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
                    + Tambah Tahun Ajaran
                </a>
            </div>
        @endcan
    </div>

    {{-- Active Academic Year Card --}}
    @if ($activeTahunAjaran)
        <div class="mb-6 bg-gradient-to-r from-[#2C5F2D] to-[#1e3f20] rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold">Tahun Ajaran Aktif</h3>
                    <p class="mt-1 text-2xl font-bold">{{ $activeTahunAjaran->nama }}</p>
                    <p class="mt-1 text-sm text-green-100">
                        {{ \Carbon\Carbon::parse($activeTahunAjaran->tanggal_mulai)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($activeTahunAjaran->tanggal_selesai)->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Academic Years List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-[#2C5F2D]">Daftar Tahun Ajaran</h3>
        </div>

        @if ($tahunAjarans->isEmpty())
            <div class="p-12 text-center">
                <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Belum ada tahun ajaran</h3>
                <p class="mt-1 text-sm text-gray-500">Tambahkan tahun ajaran pertama untuk memulai.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                Tahun Ajaran</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                Periode</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                Status</th>
                            @can('manage siswa')
                                <th scope="col"
                                    class="relative py-3.5 pl-3 pr-6 text-right text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                    Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($tahunAjarans as $tahunAjaran)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 pl-6 pr-3 text-sm">
                                    <div class="font-semibold text-[#2C5F2D]">{{ $tahunAjaran->nama }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($tahunAjaran->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($tahunAjaran->tanggal_selesai)->format('d M Y') }}
                                </td>
                                <td class="px-3 py-4 text-sm">
                                    @if ($tahunAjaran->is_active)
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-50 px-3 py-1 text-sm font-medium text-gray-600 ring-1 ring-inset ring-gray-500/20">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                @can('manage siswa')
                                    <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium pr-6">
                                        <div class="flex items-center justify-end gap-3">
                                            @if (!$tahunAjaran->is_active)
                                                <form action="{{ route('tahun-ajaran.set-active', $tahunAjaran->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-[#C8963E] hover:text-[#b58937] font-medium transition-colors">
                                                        Aktifkan
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('tahun-ajaran.edit', $tahunAjaran->id) }}"
                                                class="text-[#2C5F2D] hover:text-[#214621] font-medium transition-colors">Edit</a>
                                            <form action="{{ route('tahun-ajaran.destroy', $tahunAjaran->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini? Data absensi yang terkait akan tetap tersimpan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 font-medium transition-colors">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
