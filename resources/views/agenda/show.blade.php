@extends('layouts.app')

@section('title', 'Riwayat Agenda | SITU Al-Awwabin')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Halaman -->
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Riwayat Agenda Mengajar</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Menampilkan riwayat untuk:
                    <strong class="text-gray-800">{{ $jadwal->mapel->nama_mapel }}</strong>
                    (Kelas: {{ $jadwal->kelas->tingkat }} - {{ $jadwal->kelas->nama_kelas }})
                </p>
                @hasrole('admin')
                    <p class="mt-1 text-sm text-blue-600 font-medium">
                        Guru: {{ $jadwal->guru->nama ?? 'N/A' }}
                    </p>
                @endhasrole
            </div>

            <div class="mt-4 sm:mt-0 sm:ml-16">
                <a href="{{ route('agenda.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    &larr; Kembali ke Agenda
                </a>
            </div>
        </div>

        <!-- Wrapper Tabel -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="flow-root">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full">
                            <thead class="sticky top-0 bg-[#F0E6D2]">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                        Tanggal</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                        Materi Diajarkan (Catatan)</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                        Absensi</th>
                                    @can('manage agenda')
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse($agendas as $agenda)
                                    <tr>
                                        <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">
                                            <div class="font-medium text-gray-900">
                                                {{ $agenda->tanggal->translatedFormat('d M Y') }}</div>
                                        </td>
                                        <td class="border-t border-gray-200 px-3 py-5 text-sm text-gray-500">
                                            <div class="prose prose-sm">
                                                {!! nl2br(e($agenda->materi_diajarkan)) !!}
                                            </div>
                                        </td>
                                        <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                            @php
                                                $counts = collect($agenda->absensi_siswa)->countBy();
                                            @endphp
                                            <div class="flex flex-col gap-1 text-xs">
                                                <span class="font-medium text-green-600">Hadir:
                                                    {{ $counts['hadir'] ?? 0 }}</span>
                                                <span class="font-medium text-yellow-600">Izin:
                                                    {{ $counts['izin'] ?? 0 }}</span>
                                                <span class="font-medium text-orange-600">Sakit:
                                                    {{ $counts['sakit'] ?? 0 }}</span>
                                                <span class="font-medium text-red-600">Alfa:
                                                    {{ $counts['alfa'] ?? 0 }}</span>
                                            </div>
                                        </td>
                                        @can('manage agenda')
                                            <td
                                                class="border-t border-gray-200 whitespace-nowrap py-5 pl-3 pr-12 text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-6">
                                                    <a href="{{ route('agenda.edit', $agenda->id) }}"
                                                        class="text-[#2C5F2D] hover:text-[#214621]">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('agenda.destroy', $agenda->id) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus agenda pertemuan ini?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                            Belum ada riwayat agenda mengajar untuk jadwal ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="p-4">
                            {{ $agendas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
