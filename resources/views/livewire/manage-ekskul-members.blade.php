<div>
    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200 shadow-sm flex items-start gap-3">
            <svg class="h-5 w-5 text-green-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-200 shadow-sm flex items-start gap-3">
            <svg class="h-5 w-5 text-red-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('ekskul.index') }}" class="text-gray-400 hover:text-[#2C5F2D] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                    </svg>
                </a>
                <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">{{ $ekskul->nama_ekskul }}</h2>
            </div>
            <p class="ml-8 text-sm text-gray-600">
                Pembina: <span class="font-medium text-gray-900">{{ $ekskul->pembina?->nama ?? 'Belum Ditentukan' }}</span>
            </p>
        </div>
    </div>

    {{-- Form Tambah Siswa --}}
    @can('manage ekskul')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <h3 class="text-base font-semibold leading-7 text-gray-900 mb-4">Tambah Anggota Baru</h3>
        <form wire:submit="attachSiswa" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            
            {{-- Filter Kelas --}}
            <div class="sm:col-span-4">
                <label for="selectedKelasId" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                <select wire:model.live="selectedKelasId" id="selectedKelasId"
                    class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-[#2C5F2D] sm:text-sm sm:leading-6">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Siswa --}}
            <div class="sm:col-span-6">
                <label for="siswa_id_to_add" class="block text-sm font-medium text-gray-700 mb-1">Pilih Siswa</label>
                <div class="relative">
                    <select wire:model="siswa_id_to_add" id="siswa_id_to_add"
                        class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-[#2C5F2D] sm:text-sm sm:leading-6 disabled:bg-gray-100 disabled:text-gray-400"
                        {{ empty($selectedKelasId) ? 'disabled' : '' }}
                        required>
                        
                        @if(empty($selectedKelasId))
                            <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        @else
                            <option value="">-- Pilih Siswa --</option>
                            @forelse($siswaTersedia as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }} (NIS: {{ $siswa->nis }})</option>
                            @empty
                                <option value="" disabled>Tidak ada siswa tersedia di kelas ini.</option>
                            @endforelse
                        @endif
                    </select>
                </div>
                @error('siswa_id_to_add')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="sm:col-span-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all disabled:bg-gray-300 disabled:cursor-not-allowed"
                    {{ empty($siswa_id_to_add) ? 'disabled' : '' }}>
                    + Tambah
                </button>
            </div>
        </form>
    </div>
    @endcan

    {{-- Tabel Anggota --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-[#2C5F2D]">Daftar Anggota</h3>
            <span class="inline-flex items-center rounded-md bg-white px-2.5 py-0.5 text-sm font-medium text-[#2C5F2D] shadow-sm ring-1 ring-inset ring-gray-300">
                {{ $ekskul->siswas->count() }} Siswa
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider w-16">No</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Nama Siswa</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">NIS</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right text-sm font-semibold text-gray-900 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($ekskul->siswas as $siswa)
                        <tr wire:key="siswa-{{ $siswa->id }}" class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-3 py-4 text-sm font-medium text-gray-900">{{ $siswa->nama }}</td>
                            <td class="px-3 py-4 text-sm text-gray-500">{{ $siswa->nis }}</td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                {{ $siswa->kelas?->tingkat }} - {{ $siswa->kelas?->nama_kelas ?? '-' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium pr-6">
                                <button type="button" wire:click="detachSiswa({{ $siswa->id }})"
                                    wire:confirm="Yakin ingin mengeluarkan {{ $siswa->nama }} dari ekskul ini?"
                                    class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                    Keluarkan
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                    </svg>
                                </div>
                                <p class="text-base font-medium text-gray-900">Belum ada anggota</p>
                                <p class="mt-1 text-sm text-gray-500">Tambahkan siswa menggunakan form di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
