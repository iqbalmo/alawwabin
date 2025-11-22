@extends('layouts.app')

@section('title', 'Edit Agenda Mengajar | SIAP Al-Awwabin')

@section('content')
<div class="max-w-5xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('agenda.show', $agenda->jadwal_id) }}" class="text-gray-400 hover:text-[#2C5F2D] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-[#2C5F2D]">Edit Agenda Pertemuan</h2>
        </div>
        <p class="ml-8 text-sm text-gray-600">
            Perbarui absensi atau materi yang diajarkan pada: <strong class="text-gray-800">{{ $agenda->jadwal->mapel->nama_mapel }}</strong> (Kelas: {{ $agenda->jadwal->kelas->tingkat }} - {{ $agenda->jadwal->kelas->nama_kelas }})
        </p>
    </div>

    <form action="{{ route('agenda.update', $agenda->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Detail Jadwal & Materi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">1. Detail Pertemuan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mengajar <span class="text-red-600">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $agenda->tanggal->format('Y-m-d')) }}"
                           class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm @error('tanggal') ring-red-500 @enderror">
                    @error('tanggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="materi_diajarkan" class="block text-sm font-medium text-gray-700 mb-2">Materi yang Diajarkan / Catatan</label>
                <textarea id="materi_diajarkan" name="materi_diajarkan" rows="3"
                          class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm"
                          placeholder="Contoh: Bab 3 - Halaman 50-55, Latihan Soal...">{{ old('materi_diajarkan', $agenda->materi_diajarkan) }}</textarea>
            </div>
        </div>

        {{-- Daftar Kehadiran --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-semibold text-[#2C5F2D]">2. Daftar Kehadiran Siswa <span class="text-red-600">*</span></h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 w-16">No</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nama Siswa</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 pr-6">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($siswas as $siswa)
                            @php
                                $status_lama = $agenda->absensi_siswa[$siswa->id] ?? 'hadir';
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 pl-6 pr-3 text-sm font-medium text-gray-900">{{ $siswa->no_absen ?? $loop->iteration }}</td>
                                <td class="px-3 py-4 text-sm font-medium text-gray-900">{{ $siswa->nama }}</td>
                                <td class="px-3 py-4 pr-6">
                                    <input type="hidden" name="absensi_siswa[{{ $siswa->id }}]" value="">
                                    <fieldset>
                                        <div class="flex flex-wrap gap-x-4 gap-y-2">
                                            <div class="flex items-center gap-x-2">
                                                <input id="hadir-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="hadir" class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-600" {{ old('absensi_siswa.'.$siswa->id, $status_lama) == 'hadir' ? 'checked' : '' }}>
                                                <label for="hadir-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Hadir</label>
                                            </div>
                                            <div class="flex items-center gap-x-2">
                                                <input id="izin-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="izin" class="h-4 w-4 border-gray-300 text-yellow-600 focus:ring-yellow-600" {{ old('absensi_siswa.'.$siswa->id, $status_lama) == 'izin' ? 'checked' : '' }}>
                                                <label for="izin-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Izin</label>
                                            </div>
                                            <div class="flex items-center gap-x-2">
                                                <input id="sakit-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="sakit" class="h-4 w-4 border-gray-300 text-orange-600 focus:ring-orange-600" {{ old('absensi_siswa.'.$siswa->id, $status_lama) == 'sakit' ? 'checked' : '' }}>
                                                <label for="sakit-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Sakit</label>
                                            </div>
                                            <div class="flex items-center gap-x-2">
                                                <input id="alfa-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="alfa" class="h-4 w-4 border-gray-300 text-red-600 focus:ring-red-600" {{ old('absensi_siswa.'.$siswa->id, $status_lama) == 'alfa' ? 'checked' : '' }}>
                                                <label for="alfa-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Alfa</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-8 text-gray-500">
                                    Tidak ada siswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
                Update Agenda
            </button>
            <a href="{{ route('agenda.show', $agenda->jadwal_id) }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
