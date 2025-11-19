@extends('layouts.app')

@section('title', 'Isi Agenda Mengajar | SITU Al-Awwabin')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('agenda.index') }}" class="text-gray-400 hover:text-[#2C5F2D] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-[#2C5F2D]">Isi Agenda Mengajar</h2>
        </div>
        <p class="ml-8 text-sm text-gray-600">Catat absensi siswa dan materi yang diajarkan</p>
    </div>

    <form action="{{ route('agenda.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Pilih Jadwal --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">1. Pilih Jadwal</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="jadwal_id" class="block text-sm font-medium text-gray-700 mb-2">Jadwal <span class="text-red-600">*</span></label>
                    <select name="jadwal_id" id="jadwal_id" 
                            class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm"
                            onchange="this.form.submit()" required>
                        <option value="">-- Pilih Jadwal --</option>
                        @foreach($jadwals as $j)
                            <option value="{{ $j->id }}" {{ $selectedJadwalId == $j->id ? 'selected' : '' }}>
                                {{ $j->hari }} - {{ $j->mapel->nama_mapel }} ({{ $j->kelas->tingkat }} - {{ $j->kelas->nama_kelas }})
                            </option>
                        @endforeach
                    </select>
                    @error('jadwal_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mengajar <span class="text-red-600">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                           class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm" required>
                    @error('tanggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="materi_diajarkan" class="block text-sm font-medium text-gray-700 mb-2">Materi yang Diajarkan / Catatan</label>
                <textarea id="materi_diajarkan" name="materi_diajarkan" rows="3"
                          class="block w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm"
                          placeholder="Contoh: Bab 3 - Halaman 50-55, Latihan Soal...">{{ old('materi_diajarkan') }}</textarea>
            </div>
        </div>

        {{-- Daftar Kehadiran --}}
        @if($siswas->isNotEmpty())
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
                        @foreach($siswas as $siswa)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 pl-6 pr-3 text-sm font-medium text-gray-900">{{ $siswa->no_absen ?? $loop->iteration }}</td>
                                <td class="px-3 py-4 text-sm font-medium text-gray-900">{{ $siswa->nama }}</td>
                                <td class="px-3 py-4 pr-6">
                                    <input type="hidden" name="absensi_siswa[{{ $siswa->id }}]" value="">
                                    <fieldset>
                                        <div class="flex flex-wrap gap-x-4 gap-y-2">
                                            <div class="flex items-center gap-x-2">
                                                <input id="hadir-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="hadir" class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-600" {{ old('absensi_siswa.'.$siswa->id, 'hadir') == 'hadir' ? 'checked' : '' }}>
                                                <label for="hadir-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Hadir</label>
                                            </div>
                                            <div class="flex items-center gap-x-2">
                                                <input id="izin-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="izin" class="h-4 w-4 border-gray-300 text-yellow-600 focus:ring-yellow-600" {{ old('absensi_siswa.'.$siswa->id) == 'izin' ? 'checked' : '' }}>
                                                <label for="izin-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Izin</label>
                                            </div>
                                            <div class="flex items-center gap-x-2">
                                                <input id="sakit-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="sakit" class="h-4 w-4 border-gray-300 text-orange-600 focus:ring-orange-600" {{ old('absensi_siswa.'.$siswa->id) == 'sakit' ? 'checked' : '' }}>
                                                <label for="sakit-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Sakit</label>
                                            </div>
                                            <div class="flex items-center gap-x-2">
                                                <input id="alfa-{{$siswa->id}}" name="absensi_siswa[{{ $siswa->id }}]" type="radio" value="alfa" class="h-4 w-4 border-gray-300 text-red-600 focus:ring-red-600" {{ old('absensi_siswa.'.$siswa->id) == 'alfa' ? 'checked' : '' }}>
                                                <label for="alfa-{{$siswa->id}}" class="text-sm font-medium text-gray-900">Alfa</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Pilih Jadwal Terlebih Dahulu</h3>
            <p class="mt-1 text-sm text-gray-500">Silakan pilih jadwal di atas untuk menampilkan daftar siswa.</p>
        </div>
        @endif

        {{-- Actions --}}
        @if($siswas->isNotEmpty())
        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
                Simpan Agenda
            </button>
            <a href="{{ route('agenda.index') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                Batal
            </a>
        </div>
        @endif
    </form>
</div>

<script>
// Auto-submit form when jadwal is selected to load students
document.getElementById('jadwal_id').addEventListener('change', function() {
    if (this.value) {
        window.location.href = '{{ route("agenda.create") }}?jadwal_id=' + this.value;
    }
});
</script>
@endsection
