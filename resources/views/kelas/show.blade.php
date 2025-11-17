@extends('layouts.app')

@section('title', 'Detail Kelas: ' . $kelas->tingkat . ' ' . $kelas->nama_kelas)

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">

        <!-- Header Halaman -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Detail Kelas: {{ $kelas->tingkat }}
                    {{ $kelas->nama_kelas }}</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Data detail kelas dan daftar siswa yang terdaftar di dalamnya.
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 flex flex-shrink-0 items-center space-x-3">

                <!-- Tombol Edit Kelas (Primer) -->
                @can('manage kelas')
                <a href="{{ route('kelas.edit', $kelas->id) }}"
                    class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
                    Edit Kelas
                </a>
                @endcan

                <!-- Tombol Urutkan Absen (Sekunder) -->
                <!-- Form ini akan menjadi 'flex item' dan berbaris rapi -->
                <form action="{{ route('kelas.reorderAbsen', $kelas->id) }}" method="POST"
                    onsubmit="return confirm('Ini akan mengganti semua nomor absen siswa di kelas ini berdasarkan urutan abjad. Lanjutkan?');">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Urutkan No. Absen
                    </button>
                </form>

                <!-- Tombol Kembali (Sekunder) -->
                <!-- 'ml-2' tidak diperlukan lagi karena sudah diatur oleh 'space-x-3' -->
                <a href="{{ route('kelas.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Kembali ke Daftar
                </a>

            </div>
        </div>

        <!-- Info Kelas (Wali & Jumlah) -->
        <div class="mt-6 border-t border-gray-200">
            <dl class="grid grid-cols-1 sm:grid-cols-2">
                <div class="border-b sm:border-b-0 sm:border-r border-gray-200 px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500">Wali Kelas</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $kelas->wali?->nama ?? 'Belum Ditentukan' }}
                    </dd>
                </div>
                <div class="border-b sm:border-b-0 border-gray-200 px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500">Jumlah Siswa</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $kelas->siswa->count() }} Siswa</dd>
                </div>
            </dl>
        </div>

        <!-- Tabel Daftar Siswa -->
        <div class="mt-8 flow-root">
            <h3 class="text-lg font-semibold leading-7 text-gray-900">Daftar Siswa di Kelas {{ $kelas->tingkat }}
                {{ $kelas->nama_kelas }}</h3>
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 mt-4">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full">
                        <thead class="sticky top-0 bg-[#F0E6D2]">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                    No. Absen</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                    NIS</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                    Nama Siswa</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                    Jenis Kelamin</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($kelas->siswa as $siswa)
                                <tr>
                                    <td class="border-t border-gray-200 py-4 pl-4 pr-3 text-sm whitespace-nowrap">
                                        {{ $siswa->no_absen ?? '-' }}</td>
                                    <td class="border-t border-gray-200 px-3 py-4 text-sm whitespace-nowrap">
                                        {{ $siswa->nis ?? '-' }}</td>
                                    <td class="border-t border-gray-200 px-3 py-4 text-sm">
                                        <div class="font-bold text-[#333333]">{{ $siswa->nama }}</div>
                                    </td>
                                    <td class="border-t border-gray-200 px-3 py-4 text-sm whitespace-nowrap">
                                        {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                                    </td>
                                    <td
                                        class="border-t border-gray-200 relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <a href="{{ route('siswa.show', $siswa->id) }}"
                                            class="text-[#2C5F2D] hover:text-[#214621]">
                                            Lihat Detail Siswa<span class="sr-only">, {{ $siswa->nama }}</span>
                                        </a>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                        Belum ada siswa yang terdaftar di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
