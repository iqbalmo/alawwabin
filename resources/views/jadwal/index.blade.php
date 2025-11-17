@extends('layouts.app')

@section('title', 'Jadwal Pelajaran | SITU Al-Awwabin')

@section('content')

{{-- 1. Header Halaman --}}
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Jadwal Pelajaran</h2>
        <p class="mt-2 text-sm text-gray-600">
            Lihat jadwal pelajaran mingguan berdasarkan hari atau berdasarkan kelas.
        </p>
    </div>
    @can('manage jadwal')
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('jadwal.create') }}" 
           class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
           + Tambah Jadwal
        </a>
    </div>
    @endcan
</div>

{{-- 2. Tombol Filter (Tab) --}}
<div class="mt-6">
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Pilih tampilan</label>
        <select id="tabs" name="tabs" onchange="window.location.href = this.value;"
                class="block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
            <option value="{{ route('jadwal.index', ['view' => 'hari']) }}" {{ $viewType == 'hari' ? 'selected' : '' }}>Tampilan per Hari</option>
            <option value="{{ route('jadwal.index', ['view' => 'kelas']) }}" {{ $viewType == 'kelas' ? 'selected' : '' }}>Tampilan per Kelas</option>
        </select>
    </div>
    <div class="hidden sm:block">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <!-- Tombol Tampilan per Hari -->
                <a href="{{ route('jadwal.index', ['view' => 'hari']) }}" wire:navigate
                   class="{{ $viewType == 'hari' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                   Tampilan per Hari
                </a>
                <!-- Tombol Tampilan per Kelas -->
                <a href="{{ route('jadwal.index', ['view' => 'kelas']) }}" wire:navigate
                   class="{{ $viewType == 'kelas' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                   Tampilan per Kelas
                </a>
            </nav>
        </div>
    </div>
</div>


{{-- 3. Wrapper Konten (Menampilkan salah satu dari dua layout) --}}
<div class="mt-8">

    {{-- ====================================================== --}}
    {{-- A. TAMPILAN JIKA DIKELOMPOKKAN BERDASARKAN HARI        --}}
    {{-- ====================================================== --}}
    @if($viewType == 'hari')
        <div class="space-y-10">
            @forelse($orderedJadwals as $hari => $jadwalsDiHariIni)
                <div>
                    <!-- Judul Kelompok Hari -->
                    <h3 class="text-xl font-semibold leading-7 text-[#2C5F2D] border-b border-gray-300 pb-2">
                        Hari {{ $hari }}
                    </h3>
                    <!-- Tabel untuk hari ini -->
                    <div class="mt-4 flow-root">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full">
                                    <thead class="sticky top-0 bg-[#F0E6D2]">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Jam</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Mata Pelajaran</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Kelas</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Guru Pengampu</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                <span class="sr-only">Aksi</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                        @foreach($jadwalsDiHariIni as $jadwal)
                                            <tr>
                                                <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm whitespace-nowrap">
                                                    <div class="font-bold text-[#333333]">
                                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                    </div>
                                                </td>
                                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                                    {{ $jadwal->mapel?->nama_mapel ?? '-' }}
                                                </td>
                                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                                    {{ $jadwal->kelas ? $jadwal->kelas->tingkat . ' - ' . $jadwal->kelas->nama_kelas : '-' }}
                                                </td>
                                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                                    {{ $jadwal->guru?->nama ?? '-' }}
                                                </td>
                                                @can('manage jadwal')
                                                <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                    <div class="flex items-center justify-end space-x-4">
                                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">Edit</a>
                                                        <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                @endcan
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
                    Belum ada data jadwal pelajaran.
                </div>
            @endforelse
        </div>

    {{-- ====================================================== --}}
    {{-- B. TAMPILAN JIKA DIKELOMPOKKAN BERDASARKAN KELAS      --}}
    {{-- ====================================================== --}}
    @else
        <div class="space-y-10">
            @forelse($semuaKelas as $kelas)
                <div>
                    <!-- Judul Kelompok Kelas -->
                    <h3 class="text-xl font-semibold leading-7 text-[#2C5F2D] border-b border-gray-300 pb-2">
                        Kelas {{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}
                    </h3>
                    
                    {{-- Cek apakah kelas ini punya jadwal --}}
                    @if(isset($jadwalsByKelas[$kelas->id]) && $jadwalsByKelas[$kelas->id]->isNotEmpty())
                        
                        {{-- Loop Sub-Grup per Hari (Senin, Selasa, dst.) --}}
                        @foreach($jadwalsByKelas[$kelas->id] as $hari => $jadwalsDiHariIni)
                            <h4 class="text-md font-semibold text-gray-800 mt-4 mb-2">Hari {{ $hari }}</h4>
                            <div class="flow-root">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <table class="min-w-full">
                                            <thead class="bg-gray-50"> {{-- Header lebih simpel --}}
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Jam</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Mata Pelajaran</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Guru Pengampu</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                        <span class="sr-only">Aksi</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-700">
                                                @foreach($jadwalsDiHariIni as $jadwal)
                                                    <tr>
                                                        <td class="border-t border-gray-200 py-4 pl-4 pr-3 text-sm whitespace-nowrap">
                                                            <div class="font-bold text-gray-800">
                                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                            </div>
                                                        </td>
                                                        <td class="border-t border-gray-200 px-3 py-4 text-sm whitespace-nowrap">
                                                            {{ $jadwal->mapel?->nama_mapel ?? '-' }}
                                                        </td>
                                                        <td class="border-t border-gray-200 px-3 py-4 text-sm whitespace-nowrap">
                                                            {{ $jadwal->guru?->nama ?? '-' }}
                                                        </td>
                                                        <td class="border-t border-gray-200 relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                            <div class="flex items-center justify-end space-x-4">
                                                                <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">Edit</a>
                                                                <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="mt-4 text-sm text-gray-500">Belum ada jadwal yang ditambahkan untuk kelas ini.</p>
                    @endif
                </div>
            @empty
                <div class="border-t border-gray-200 py-8 text-center text-gray-500">
                    Belum ada data kelas. Tambahkan kelas terlebih dahulu.
                </div>
            @endforelse
        </div>
    @endif

</div>
@endsection