<div>
    {{-- 
      Livewire Component: SearchGuru
      Theme: Harmoni Klasik
      Features: Mobile Card View, Desktop Premium Table, Real-time Search
    --}}

    {{-- 1. Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Guru & Staf</h2>
            <p class="mt-1 text-sm text-gray-600">
                Kelola data guru dan staf pengajar yang terdaftar.
            </p>
        </div>
        @can('manage guru')
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('guru.create') }}" 
               class="inline-flex items-center justify-center rounded-lg bg-[#C8963E] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 transition-all duration-200">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Tambah Guru
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
                       placeholder="Cari nama, NIP, atau jabatan...">
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
            @forelse($guru as $g)
                <div wire:key="mobile-guru-{{ $g->id }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-base font-bold text-[#333333]">{{ $g->nama }} {{ $g->gelar }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">NIP: {{ $g->nip ?? '-' }}</p>
                        </div>
                        @if($g->status_kepegawaian == 'PNS')
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">PNS</span>
                        @elseif($g->status_kepegawaian == 'GTY')
                            <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">GTY</span>
                        @elseif($g->status_kepegawaian == 'GTT')
                            <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">GTT</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $g->status_kepegawaian ?? 'Lainnya' }}</span>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                        <div>
                            <span class="block text-xs text-gray-400">Jabatan</span>
                            {{ $g->jabatan ?? '-' }}
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400">Mapel Pengampu</span>
                            @if($g->mapels->count() > 0)
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($g->mapels as $mapel)
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-1.5 py-0.5 text-[10px] font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            {{ $mapel->nama_mapel }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    @if($g->wali)
                    <div class="bg-green-50 rounded-md p-2 text-xs text-green-800 border border-green-100">
                        <strong>Wali Kelas:</strong> {{ $g->wali->tingkat }} - {{ $g->wali->nama_kelas }}
                    </div>
                    @endif

                    <div class="pt-3 border-t border-gray-50 flex justify-end gap-3">
                        <a href="{{ route('guru.show', $g->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Detail</a>
                        @can('manage guru')
                            <a href="{{ route('guru.edit', $g->id) }}" class="text-sm font-medium text-[#C8963E] hover:text-[#a67c32]">Edit</a>
                            <button type="button" 
                                    wire:click="deleteGuru({{ $g->id }})"
                                    wire:confirm="Yakin ingin menghapus guru ini?"
                                    class="text-sm font-medium text-red-600 hover:text-red-800">
                                Hapus
                            </button>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Tidak ada data guru ditemukan.</p>
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
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">NIP / Jabatan</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Mapel</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Telepon</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-[#2C5F2D] uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($guru as $g)
                            <tr wire:key="desktop-guru-{{ $g->id }}" class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500">
                                    {{ ($guru->currentPage() - 1) * $guru->perPage() + $loop->iteration }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <div class="font-semibold text-[#333333]">{{ $g->nama }} {{ $g->gelar }}</div>
                                    @if($g->wali)
                                        <div class="text-xs text-green-600 font-medium mt-0.5">Wali Kelas {{ $g->wali->tingkat }} - {{ $g->wali->nama_kelas }}</div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div>{{ $g->nip ?? '-' }}</div>
                                    <div class="text-xs">{{ $g->jabatan ?? '-' }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    @if($g->mapels->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($g->mapels as $mapel)
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                    {{ $mapel->nama_mapel }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $g->telepon ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    @if($g->status_kepegawaian == 'PNS')
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">PNS</span>
                                    @elseif($g->status_kepegawaian == 'GTY')
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">GTY</span>
                                    @elseif($g->status_kepegawaian == 'GTT')
                                        <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">GTT</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $g->status_kepegawaian ?? '-' }}</span>
                                    @endif
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('guru.show', $g->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        @can('manage guru')
                                            <a href="{{ route('guru.edit', $g->id) }}" class="text-[#C8963E] hover:text-[#a67c32]">Edit</a>
                                            <button type="button" 
                                                    wire:click="deleteGuru({{ $g->id }})"
                                                    wire:confirm="Yakin ingin menghapus guru ini?"
                                                    class="text-red-600 hover:text-red-900">
                                                Hapus
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-gray-500">
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
            {{ $guru->links() }}
        </div>
    </div>
</div>