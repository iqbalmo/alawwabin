@extends('layouts.app')

@section('title', 'Arsip Siswa Lulus | SITU Al-Awwabin')

@section('content')

{{-- 1. Header Halaman --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Arsip Siswa Lulus</h2>
        <p class="mt-2 text-sm text-gray-600">
            Daftar siswa yang telah lulus, dikelompokkan berdasarkan tahun kelulusan.
        </p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('siswa.index') }}" 
           class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
           Kembali ke Daftar Siswa Aktif
        </a>
    </div>
</div>

{{-- 2. Wrapper Tabel yang Dikelompokkan --}}
<div class="mt-8 space-y-10">

    @forelse($arsipPerTahun as $tahun => $siswaLulus)
        
        <div>
            <!-- Judul Kelompok Tahun -->
            <h3 class="text-xl font-semibold leading-7 text-[#2C5F2D] border-b border-gray-300 pb-2">
                Angkatan Lulus Tahun {{ $tahun }}
            </h3>

            <!-- Tabel untuk kelompok ini -->
            <div class="mt-4 flow-root">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full">
                            <thead class="sticky top-0 bg-[#F0E6D2]">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">NIS</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">NISN</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Nama Siswa</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Jenis Kelamin</th>
                                    {{-- <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Tgl. Lulus</th> --}} {{-- <-- DIHAPUS --}}
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                
                                @foreach($siswaLulus as $siswa)
                                    <tr>
                                        <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">{{ $loop->iteration }}</td>
                                        <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $siswa->nis }}</td>
                                        <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $siswa->nisn ?? '-' }}</td>
                                        <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                            <div class="font-bold text-[#333333]">{{ $siswa->nama }}</div>
                                        </td>
                                        <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                            {{ $siswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                        </td>
                                        {{-- <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">{{ $siswa->updated_at->translatedFormat('d M Y') }}</td> --}} {{-- <-- DIHAPUS --}}
                                        <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                            <a href="{{ route('siswa.show', $siswa->id) }}" class="text-gray-600 hover:text-gray-900">
                                                Lihat Detail<span class="sr-only">, {{ $siswa->nama }}</span>
                                            </a>
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
        {{-- Tampilan jika tidak ada data lulusan sama sekali --}}
        <div class="border-t border-gray-200 py-8 text-center text-gray-500">
            Belum ada data siswa yang diluluskan.
        </div>
    @endforelse

</div>
@endsection