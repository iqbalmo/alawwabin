@extends('layouts.app')

@section('title', 'Detail Siswa: ' . $siswa->nama)

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- Header Halaman --}}
        <div class="mb-6 sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#2C5F2D]">{{ $siswa->nama }}</h1>
                <p class="mt-2 text-sm text-gray-600 flex items-center gap-3">
                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                        NIS: {{ $siswa->nis }}
                    </span>
                    <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                        NISN: {{ $siswa->nisn ?? '-' }}
                    </span>
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('siswa.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2 transition-colors">
                   &larr; Kembali
                </a>
                @can('manage siswa')
                <a href="{{ route('siswa.edit', $siswa->id) }}"
                   class="inline-flex items-center justify-center rounded-lg bg-[#C8963E] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 transition-colors">
                   Edit Data
                </a>
                @endcan
            </div>
        </div>

        <div class="space-y-6">
            {{-- BAGIAN 1: DATA DIRI --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D]">Data Diri Siswa</h3>
                </div>
                <div class="border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-medium">{{ $siswa->nama }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->kelas ? $siswa->kelas->tingkat . ' - ' . $siswa->kelas->nama_kelas : '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">No. Absen</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->no_absen ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                            </dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">NIK Siswa</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->nik_siswa ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">No. Kartu Keluarga</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->no_kk ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Status Mukim</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                @if($siswa->status_mukim == 'MUKIM')
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Mukim</span>
                                @elseif($siswa->status_mukim == 'PP')
                                    <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PP (Pulang Pergi)</span>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Anak Ke-</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->anak_ke ?? '-' }} dari {{ $siswa->jumlah_saudara ?? '-' }} bersaudara</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Sekolah Asal</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->sekolah_asal ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- BAGIAN 2: DATA ORANG TUA --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D]">Data Orang Tua</h3>
                </div>
                <div class="border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        {{-- Ayah --}}
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors bg-gray-50/50">
                            <dt class="text-sm font-semibold text-gray-800">Data Ayah</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"></dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">Nama Ayah</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-medium">{{ $siswa->nama_ayah ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">No. HP Ayah</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->hp_ayah ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">Pekerjaan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->pekerjaan_ayah ?? '-' }}</dd>
                        </div>

                        {{-- Ibu --}}
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors bg-gray-50/50">
                            <dt class="text-sm font-semibold text-gray-800">Data Ibu</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"></dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">Nama Ibu</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-medium">{{ $siswa->nama_ibu ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">No. HP Ibu</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->hp_ibu ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500 pl-4 border-l-2 border-gray-200">Pekerjaan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->pekerjaan_ibu ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- BAGIAN 3: ALAMAT --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D]">Alamat & Kontak</h3>
                </div>
                <div class="border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Alamat Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->alamat_orangtua ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Kelurahan / Desa</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->kelurahan ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Kecamatan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->kecamatan ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Kabupaten / Kota</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->kota ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Provinsi</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->provinsi ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Kode Pos</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->kodepos ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- BAGIAN 4: WALI (Jika Ada) --}}
            @if($siswa->nama_wali)
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D]">Data Wali</h3>
                </div>
                <div class="border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Nama Wali</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-medium">{{ $siswa->nama_wali }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Pekerjaan Wali</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->pekerjaan_wali ?? '-' }}</dd>
                        </div>
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                            <dt class="text-sm font-medium text-gray-500">Alamat Wali</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $siswa->alamat_wali ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            @endif

            {{-- BAGIAN 5: EKSTRAKURIKULER --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C5F2D]">Ekstrakurikuler</h3>
                </div>
                <div class="p-6">
                    @if($siswa->ekstrakurikulers->isEmpty())
                        <p class="text-sm text-gray-500 italic">Siswa ini belum mengikuti ekstrakurikuler apapun.</p>
                    @else
                        <div class="flex flex-wrap gap-3">
                            @foreach($siswa->ekstrakurikulers as $ekskul)
                                <a href="{{ route('ekskul.show', $ekskul->id) }}"
                                   class="inline-flex items-center rounded-full bg-green-50 px-3 py-1.5 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20 hover:bg-green-100 transition-colors">
                                    {{ $ekskul->nama_ekskul }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
