@extends('layouts.app')

@section('title', 'Edit Agenda Mengajar | SITU Al-Awwabin')
@section('header-title', 'Edit Agenda Mengajar')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <form action="{{ route('agenda.update', $agenda->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6 md:p-8">
        @csrf
        @method('PUT')
        <div class="space-y-12">

            <!-- Header Form -->
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Edit Agenda Pertemuan</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Perbarui absensi atau materi yang diajarkan pada: <br>
                    <strong class="text-gray-800">{{ $agenda->jadwal->mapel->nama_mapel }}</strong> 
                    (Kelas: {{ $agenda->jadwal->kelas->nama_kelas }})
                </p>
            </div>

            <!-- BAGIAN 1: DETAIL JADWAL & MATERI -->
            <div class="border-b border-gray-900/10 pb-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 md:grid-cols-6">
                    
                    <div class="md:col-span-3">
                        <label for="tanggal" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Mengajar <span class="text-red-600">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $agenda->tanggal->format('Y-m-d')) }}"
                               class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm @error('tanggal') ring-red-500 @enderror">
                        @error('tanggal')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-6">
                        <label for="materi_diajarkan" class="block text-sm font-medium leading-6 text-gray-900">Materi yang Diajarkan / Catatan</label>
                        <textarea id="materi_diajarkan" name="materi_diajarkan" rows="4"
                                  class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm"
                                  placeholder="Contoh: Bab 3 - Halaman 50-55, Latihan Soal...">{{ old('materi_diajarkan', $agenda->materi_diajarkan) }}</textarea>
                    </div>

                </div>
            </div>

            <!-- BAGIAN 2: DAFTAR KEHADIRAN SISWA -->
            <div class="pb-12">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">Daftar Kehadiran Siswa <span class="text-red-600">*</span></h3>
                
                <div class="mt-6 flow-root">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">No</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nama Siswa</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($siswas as $siswa)
                                        @php
                                            // Ambil status lama dari data agenda
                                            $status_lama = $agenda->absensi_siswa[$siswa->id] ?? 'hadir';
                                        @endphp
                                        <tr>
                                            <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $siswa->no_absen ?? $loop->iteration }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-900 font-medium">{{ $siswa->nama }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-500">
                                                <input type="hidden" name="absensi_siswa[{{ $siswa->id }}]" value=""> <!-- fallback -->
                                                <fieldset>
                                                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                                                        <div class="flex items-center gap-x-1">
                                                            <input id="hadir-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="hadir" class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-600" {{ old('absensi_siswa.'.$siswa->id, $status_lama) == 'hadir' ? 'checked' : '' }}>
                                                            <label for="hadir-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Hadir</label>
                                                        </div>
                                                        <div class="flex items-center gap-x-1">
                                                            <input id="izin-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="izin" class="h-4 w-4 border-gray-300 text-yellow-600 focus:ring-yellow-600" {{ old('absensi_siswa.'.$siswa->id, $status_lama) == 'izin' ? 'checked' : '' }}>
                                                            <label for="izin-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Izin</label>
                                                        </div>
                                                        <div class="flex items-center gap-x-1">
                                                            <input id="sakit-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="sakit" class="h-4 w-4 border-gray-300 text-orange-600 focus:ring-orange-600" {{ old('absensi_siswa.'.$siswa->id, $status_lama) == 'sakit' ? 'checked' : '' }}>
                                                            <label for="sakit-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Sakit</label>
                                                        </div>
                                                        <div class="flex items-center gap-x-1">
                                                            <input id="alfa-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="alfa" class="h-4 w-4 border-gray-300 text-red-600 focus:ring-red-600" {{ old('absensi_siswa.'.$siswa->id, $status_lama) == 'alfa' ? 'checked' : '' }}>
                                                            <label for="alfa-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Alfa</label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-6 text-gray-500">
                                                Tidak ada siswa di kelas ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('agenda.show', $agenda->jadwal_id) }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
            <button type="submit"
                class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Update Agenda
            </button>
        </div>
    </form>
</div>
@endsection