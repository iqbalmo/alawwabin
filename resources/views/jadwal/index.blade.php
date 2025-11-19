@extends('layouts.app')

@section('title', 'Jadwal Pelajaran | SITU Al-Awwabin')

@section('content')

{{-- Header --}}
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Jadwal Pelajaran</h2>
        <p class="mt-2 text-sm text-gray-600">
            Lihat jadwal pelajaran mingguan berdasarkan hari atau berdasarkan kelas.
        </p>
    </div>
    @can('manage jadwal')
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('jadwal.create') }}" 
           class="inline-flex items-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
            + Tambah Jadwal
        </a>
    </div>
    @endcan
</div>

{{-- Tab Filter --}}
<div class="mb-8">
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Pilih tampilan</label>
        <select id="tabs" name="tabs" onchange="window.location.href = this.value;"
                class="block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
            <option value="{{ route('jadwal.index', ['view' => 'hari']) }}" {{ $viewType == 'hari' ? 'selected' : '' }}>Tampilan per Hari</option>
            <option value="{{ route('jadwal.index', ['view' => 'kelas']) }}" {{ $viewType == 'kelas' ? 'selected' : '' }}>Tampilan per Kelas</option>
        </select>
    </div>
    <div class="hidden sm:block">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="{{ route('jadwal.index', ['view' => 'hari']) }}"
                   class="{{ $viewType == 'hari' ? 'border-[#2C5F2D] text-[#2C5F2D]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                   Tampilan per Hari
                </a>
                <a href="{{ route('jadwal.index', ['view' => 'kelas']) }}"
                   class="{{ $viewType == 'kelas' ? 'border-[#2C5F2D] text-[#2C5F2D]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                   Tampilan per Kelas
                </a>
            </nav>
        </div>
    </div>
</div>

{{-- Content --}}
<div class="space-y-8">
    @if($viewType == 'hari')
        {{-- View by Day --}}
        @forelse($orderedJadwals as $hari => $jadwalsDiHariIni)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-[#2C5F2D]">{{ $hari }}</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Jam</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Mata Pelajaran</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Kelas</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Guru Pengampu</th>
                                @can('manage jadwal')
                                <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right text-sm font-semibold text-gray-900 uppercase tracking-wider">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($jadwalsDiHariIni as $jadwal)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 pl-6 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-700">{{ $jadwal->mapel?->nama_mapel ?? '-' }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-700">
                                        {{ $jadwal->kelas ? $jadwal->kelas->tingkat . ' - ' . $jadwal->kelas->nama_kelas : '-' }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-700">{{ $jadwal->guru?->nama ?? '-' }}</td>
                                    @can('manage jadwal')
                                    <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium pr-6">
                                        <div class="flex items-center justify-end gap-4">
                                            <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="text-[#2C5F2D] hover:text-[#214621] font-medium transition-colors">Edit</a>
                                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors">Hapus</button>
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
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Belum ada jadwal</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada data jadwal pelajaran.</p>
            </div>
        @endforelse

    @else
        {{-- View by Class --}}
        @forelse($semuaKelas as $kelas)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-[#2C5F2D]">Kelas {{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</h3>
                </div>
                
                @if(isset($jadwalsByKelas[$kelas->id]) && $jadwalsByKelas[$kelas->id]->isNotEmpty())
                    <div class="p-6 space-y-6">
                        @foreach($jadwalsByKelas[$kelas->id] as $hari => $jadwalsDiHariIni)
                            <div>
                                <h4 class="text-md font-semibold text-gray-800 mb-3">{{ $hari }}</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Jam</th>
                                                <th scope="col" class="px-3 py-3 text-left text-sm font-semibold text-gray-900">Mata Pelajaran</th>
                                                <th scope="col" class="px-3 py-3 text-left text-sm font-semibold text-gray-900">Guru Pengampu</th>
                                                @can('manage jadwal')
                                                <th scope="col" class="relative py-3 pl-3 pr-4 text-right text-sm font-semibold text-gray-900">Aksi</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @foreach($jadwalsDiHariIni as $jadwal)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="py-3 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                    </td>
                                                    <td class="px-3 py-3 text-sm text-gray-700">{{ $jadwal->mapel?->nama_mapel ?? '-' }}</td>
                                                    <td class="px-3 py-3 text-sm text-gray-700">{{ $jadwal->guru?->nama ?? '-' }}</td>
                                                    @can('manage jadwal')
                                                    <td class="px-3 py-3 whitespace-nowrap text-right text-sm font-medium pr-4">
                                                        <div class="flex items-center justify-end gap-4">
                                                            <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="text-[#2C5F2D] hover:text-[#214621] font-medium">Edit</a>
                                                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
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
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-gray-500">
                        <p class="text-sm">Belum ada jadwal untuk kelas ini.</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <h3 class="text-lg font-semibold text-gray-900">Belum ada kelas</h3>
                <p class="mt-1 text-sm text-gray-500">Tambahkan kelas terlebih dahulu.</p>
            </div>
        @endforelse
    @endif
</div>
@endsection