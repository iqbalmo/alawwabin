<div>
    {{-- 
      Livewire Component: SearchSiswa
      Theme: Harmoni Klasik
      Features: Mobile Card View, Desktop Premium Table, Real-time Search
    --}}

    {{-- 1. Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Siswa Aktif</h2>
            <p class="mt-1 text-sm text-gray-600">
                Kelola data siswa yang terdaftar di sistem.
            </p>
        </div>
        @can('manage siswa')
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('siswa.create') }}" 
               class="inline-flex items-center justify-center rounded-lg bg-[#C8963E] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 transition-all duration-200">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Tambah Siswa
            </a>
        </div>
        @endcan
    </div>

    {{-- 2. Controls (Search & Reset) --}}
    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-grow">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       id="search"
                       class="block w-full rounded-lg border-0 py-2.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#2C5F2D] sm:text-sm sm:leading-6 transition-shadow"
                       placeholder="Cari nama, NIS, atau NISN...">
            </div>
            <button type="button"
               wire:click="resetSearch"
               class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2 transition-colors">
                Reset
            </button>
        </div>
    </div>

    {{-- 3. Content --}}
    <div class="space-y-4">
        
        {{-- Mobile View (Card Layout) --}}
        <div class="grid grid-cols-1 gap-4 sm:hidden">
            @forelse($siswa as $s)
                <div wire:key="mobile-siswa-{{ $s->id }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-base font-bold text-[#333333]">{{ $s->nama }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">NIS: {{ $s->nis }} <span class="mx-1">•</span> {{ $s->kelas ? $s->kelas->tingkat . ' - ' . $s->kelas->nama_kelas : 'Tanpa Kelas' }}</p>
                        </div>
                        @if($s->status_mukim == 'MUKIM')
                            <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Mukim</span>
                        @elseif($s->status_mukim == 'PP')
                            <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PP</span>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                        <div>
                            <span class="block text-xs text-gray-400">Jenis Kelamin</span>
                            {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Wali / Ayah</span>
                            {{ $s->nama_ayah ?? '-' }}
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-50 flex justify-end gap-3">
                        <a href="{{ route('siswa.show', $s->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Detail</a>
                        @can('manage siswa')
                            <a href="{{ route('siswa.edit', $s->id) }}" class="text-sm font-medium text-[#C8963E] hover:text-[#a67c32]">Edit</a>
                            <button type="button" 
                                    wire:click="deleteSiswa({{ $s->id }})"
                                    wire:confirm="Hapus data siswa ini?"
                                    class="text-sm font-medium text-red-600 hover:text-red-800">
                                Hapus
                            </button>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Tidak ada data siswa ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop View (Table Layout) --}}
        <div class="hidden sm:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#F0E6D2]">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">No</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Nama Lengkap</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">NIS / NISN</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">L/P</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Kelas</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Orang Tua</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($siswa as $s)
                            <tr wire:key="desktop-siswa-{{ $s->id }}" class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500">
                                    {{ ($siswa->currentPage() - 1) * $siswa->perPage() + $loop->iteration }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <div class="font-semibold text-[#333333]">{{ $s->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $s->nik_siswa ?? '' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div>{{ $s->nis }}</div>
                                    <div class="text-xs">{{ $s->nisn ?? '-' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $s->jenis_kelamin }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $s->kelas ? $s->kelas->tingkat . ' - ' . $s->kelas->nama_kelas : '-' }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div>{{ $s->nama_ayah ?? '-' }}</div>
                                    <div class="text-xs">{{ $s->hp_ayah ?? '' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    @if($s->status_mukim == 'MUKIM')
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Mukim</span>
                                    @elseif($s->status_mukim == 'PP')
                                        <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PP</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('siswa.show', $s->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        @can('manage siswa')
                                            <a href="{{ route('siswa.edit', $s->id) }}" class="text-[#C8963E] hover:text-[#a67c32]">Edit</a>
                                            <button type="button" 
                                                    wire:click="deleteSiswa({{ $s->id }})"
                                                    wire:confirm="Yakin ingin menghapus siswa ini?"
                                                    class="text-red-600 hover:text-red-900">
                                                Hapus
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-10 text-center text-gray-500">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $siswa->links() }}
        </div>
    </div>
</div>
