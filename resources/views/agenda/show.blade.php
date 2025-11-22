@extends('layouts.app')

@section('title', 'Riwayat Agenda | SIAP Al-Awwabin')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('agenda.index') }}" class="text-gray-400 hover:text-[#2C5F2D] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                    </svg>
                </a>
                <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Riwayat Agenda Mengajar</h2>
            </div>
            <p class="ml-8 text-sm text-gray-600">
                Menampilkan riwayat untuk: <strong class="text-gray-800">{{ $jadwal->mapel->nama_mapel }}</strong> (Kelas: {{ $jadwal->kelas->tingkat }} - {{ $jadwal->kelas->nama_kelas }})
            </p>
            @hasrole('admin')
                <p class="ml-8 mt-1 text-sm text-[#C8963E] font-medium">
                    Guru: {{ $jadwal->guru->nama ?? 'N/A' }}
                </p>
            @endhasrole
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-[#2C5F2D]">Daftar Pertemuan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Materi Diajarkan</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Absensi</th>
                        @can('manage agenda')
                            <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right text-sm font-semibold text-gray-900 uppercase tracking-wider">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($agendas as $agenda)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $agenda->tanggal->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-700">
                                <div class="prose prose-sm max-w-none">
                                    {!! nl2br(e($agenda->materi_diajarkan)) !!}
                                </div>
                            </td>
                            <td class="px-3 py-4 text-sm">
                                @php
                                    $counts = collect($agenda->absensi_siswa)->countBy();
                                @endphp
                                <div class="flex flex-col gap-1 text-xs">
                                    <span class="font-medium text-green-600">Hadir: {{ $counts['hadir'] ?? 0 }}</span>
                                    <span class="font-medium text-yellow-600">Izin: {{ $counts['izin'] ?? 0 }}</span>
                                    <span class="font-medium text-orange-600">Sakit: {{ $counts['sakit'] ?? 0 }}</span>
                                    <span class="font-medium text-red-600">Alfa: {{ $counts['alfa'] ?? 0 }}</span>
                                </div>
                            </td>
                            @can('manage agenda')
                                <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium pr-6">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('agenda.edit', $agenda->id) }}" class="text-[#2C5F2D] hover:text-[#214621] font-medium transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('agenda.destroy', $agenda->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus agenda pertemuan ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Belum ada riwayat</h3>
                                <p class="mt-1 text-sm text-gray-500">Belum ada riwayat agenda mengajar untuk jadwal ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($agendas->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $agendas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
