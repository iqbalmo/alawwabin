@extends('layouts.app')

@section('title', 'Anggota Ekskul: ' . $ekskul->nama_ekskul)
@section('header-title', 'Manajemen Anggota Ekskul')

@section('content')

{{-- 1. Header Halaman --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">{{ $ekskul->nama_ekskul }}</h2>
        <p class="mt-2 text-sm text-gray-600">
            Pembina: <strong>{{ $ekskul->pembina?->nama ?? 'Belum Ditentukan' }}</strong>
        </p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('ekskul.index') }}" 
           class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
           Kembali ke Daftar Ekskul
        </a>
    </div>
</div>

{{-- 2. Form Tambah Siswa --}}
<div class="mt-8">
    <form action="{{ route('ekskul.attachSiswa', $ekskul->id) }}" method="POST" class="sm:flex sm:items-start sm:space-x-4 p-6 bg-gray-50 rounded-lg shadow-sm border">
        @csrf
        <div class="flex-1 min-w-0">
            <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-1">Tambahkan Siswa ke Ekskul Ini</label>
            <select id="siswa_id" name="siswa_id" 
                    class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm" required>
                <option value="">-- Pilih Siswa (Hanya siswa yang belum terdaftar) --</option>
                @forelse($siswaTersedia as $siswa)
                    <option value="{{ $siswa->id }}">{{ $siswa->nama }} (NIS: {{ $siswa->nis }})</option>
                @empty
                    <option value="" disabled>Semua siswa aktif sudah terdaftar.</option>
                @endforelse
            </select>
        </div>
        <div class="mt-4 sm:mt-5">
            <button type="submit"
                    class="inline-flex w-full sm:w-auto items-center rounded-md border border-transparent bg-[#2C5F2D] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#214621]">
                + Tambahkan
            </button>
        </div>
    </form>
</div>


{{-- 3. Wrapper Tabel Anggota Terdaftar --}}
<div class="mt-8 flow-root">
    <h3 class="text-lg font-semibold leading-7 text-gray-900 mb-4">Daftar Anggota Saat Ini ({{ $ekskul->siswas->count() }})</h3>
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full">
                <thead class="sticky top-0 bg-[#F0E6D2]">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">No</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Nama Siswa</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">NIS</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($ekskul->siswas as $siswa)
                        <tr>
                            <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">{{ $loop->iteration }}</td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                <div class="font-bold text-[#333333]">{{ $siswa->nama }}</div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                {{ $siswa->nis }}
                            </td>
                            <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                {{ $siswa->kelas?->tingkat }} - {{ $siswa->kelas?->nama_kelas ?? 'N/A' }}
                            </td>
                            <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <form action="{{ route('ekskul.detachSiswa', ['ekskul' => $ekskul->id, 'siswa' => $siswa->id]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengeluarkan siswa ini dari ekskul?');">
                                    @csrf
                                    {{-- Kita gunakan method POST, tapi Laravel akan mengartikannya sbg DELETE/POST --}}
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Keluarkan<span class="sr-only">, {{ $siswa->nama }}</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                Belum ada siswa yang terdaftar di ekskul ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection