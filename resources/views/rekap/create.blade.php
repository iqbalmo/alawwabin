@extends('layouts.app')

@section('title', 'Tambah Rekap Absensi | SITU Al-Awwabin')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Tambah Rekap Absensi Guru</h2>
        <p class="mt-2 text-sm text-gray-600">Isi data rekap absensi guru berdasarkan jadwal mengajar.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('rekap.index') }}" class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937]">
           &larr; Kembali
        </a>
    </div>
</div>

@if ($errors->any())
<div class="mt-6 rounded-md bg-red-100 p-4 border border-red-300">
    <ul class="list-disc pl-5 text-red-700">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('rekap.store') }}" method="POST" class="mt-6">
    @csrf
    <div class="mb-4">
        <label for="jadwal_id" class="block text-sm font-medium text-gray-700">Pilih Jadwal</label>
        <select id="jadwal_id" name="jadwal_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D]/50" required>
            <option value="">-- Pilih Jadwal --</option>
            @foreach($jadwals as $jadwal)
                <option value="{{ $jadwal->id }}">
                    {{ $jadwal->mapel->nama_mapel }} | {{ $jadwal->kelas->nama_kelas }} | {{ $jadwal->guru->nama ?? '-' }} | {{ $jadwal->hari }} ({{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D]/50" required>
    </div>

    <div id="siswa-container" class="mt-6"></div>

    <button type="submit" class="mt-4 inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-6 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937]">
        Simpan Rekap
    </button>
</form>

<script>
document.getElementById('jadwal_id').addEventListener('change', function() {
    const jadwalId = this.value;
    const container = document.getElementById('siswa-container');
    container.innerHTML = '<p class="text-gray-500">Loading siswa...</p>';

    if (!jadwalId) {
        container.innerHTML = '';
        return;
    }

    fetch(`/rekap/get-siswa-by-jadwal/${jadwalId}`)
        .then(res => res.json())
        .then(data => {
            if (!data.length) {
                container.innerHTML = '<p class="text-gray-500">Tidak ada siswa di kelas ini.</p>';
                return;
            }

            let html = '<table class="min-w-full mt-4 border border-gray-200">';
            html += '<thead class="bg-[#F0E6D2]">';
            html += '<tr><th class="px-3 py-2 text-left text-sm font-semibold">Nama Siswa</th><th class="px-3 py-2 text-left text-sm font-semibold">Status</th><th class="px-3 py-2 text-left text-sm font-semibold">Catatan</th></tr></thead><tbody>';

           data.forEach(siswa => {
            html += `<tr class="border-t border-gray-200">
                <td class="px-3 py-2 text-sm">${siswa.nama}</td>
                <td class="px-3 py-2 text-sm">
                <select name="status[${siswa.id}]" class="rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D]/50">
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alpha">Alpha</option>
                </select>
                </td>
                <td class="px-3 py-2 text-sm">
                <input type="text" name="catatan[${siswa.id}]" placeholder="Catatan guru..." class="rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D]/50">
        </td>
    </tr>`;
});


            html += '</tbody></table>';
            container.innerHTML = html;
        })
        .catch(err => {
            container.innerHTML = '<p class="text-red-500">Gagal memuat siswa.</p>';
            console.error(err);
        });
});
</script>
@endsection
