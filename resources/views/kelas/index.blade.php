@extends('layouts.app')

@section('title', 'Daftar Kelas | SITU Al-Awwabin')

@section('content')

    {{-- 1. Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Kelas</h2>
            <p class="mt-2 text-sm text-gray-600">
                Daftar semua kelas yang terdaftar, dikelompokkan berdasarkan tingkat.
            </p>
        </div>
        @can('manage kelas')
            <div class="mt-4 sm:mt-0 sm:ml-16">
                <a href="{{ route('kelas.create') }}"
                    class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
                    + Tambah Kelas
                </a>
            </div>
        @endcan
    </div>

    {{-- 2. Wrapper Tabel yang Dikelompokkan --}}
    <div class="mt-8 space-y-10">

        @forelse($groupedKelas as $tingkat => $kelasDiTingkat)

            <div>
                <!-- Judul Kelompok -->
                <h3 class="text-xl font-semibold leading-7 text-[#2C5F2D] border-b border-gray-300 pb-2">
                    Kelompok Kelas {{ $tingkat }}
                </h3>

                <!-- Tabel untuk kelompok ini -->
                <div class="mt-4 flow-root">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full">
                                <thead class="sticky top-0 bg-[#F0E6D2]">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                            No</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                            Nama Kelas</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                            Wali Kelas</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                            Jumlah Siswa</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">

                                    @foreach ($kelasDiTingkat as $k)
                                        <tr>
                                            <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">
                                                {{ $loop->iteration }}</td>
                                            <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                                <div class="font-bold text-[#333333]">{{ $k->nama_kelas }}</div>
                                            </td>
                                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                                {{ $k->wali?->nama ?? '-' }}
                                            </td>

                                            {{-- --- INI ADALAH BARIS YANG DIPERBARUI --- --}}
                                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                                {{ $k->siswa_count }} Siswa
                                            </td>
                                            {{-- ------------------------------------- --}}

                                            <td
                                                class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                @can('manage kelas')
                                                    <div class="flex items-center justify-end space-x-4">
                                                        <a href="{{ route('kelas.show', $k->id) }}"
                                                            class="text-blue-600 hover:text-blue-800">
                                                            Lihat Siswa
                                                        </a>
                                                        <a href="{{ route('kelas.edit', $k->id) }}"
                                                            class="text-[#2C5F2D] hover:text-[#214621]">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus kelas ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div class="border-t border-gray-200 py-8 text-center text-gray-500">
                Belum ada data kelas.
                <a href="{{ route('kelas.create') }}"
                    class="text-sm font-medium text-[#C8963E] hover:text-[#b58937]">Tambah kelas baru.</a>
            </div>
        @endforelse

    </div>
@endsection
