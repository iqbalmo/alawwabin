<div>
    {{-- 1. Header Halaman (Judul, Deskripsi, dan Tombol) --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Daftar Guru dan Staf</h2>
            <p class="mt-2 text-sm text-gray-600">Daftar semua guru dan staf pengajar yang terdaftar di sistem.</p>
        </div>
        
        {{-- RBAC: Hanya user dengan izin 'manage guru' yang bisa lihat tombol ini --}}
        @can('manage guru')
        <div class="mt-4 sm:mt-0 sm:ml-16">
            <a href="{{ route('guru.create') }}" 
               class="inline-flex items-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-white">
                + Tambah Guru
            </a>
        </div>
        @endcan

    </div>

    {{-- 2. Form Pencarian (Dihubungkan ke Livewire) --}}
    <div class="mt-6">
        <div class="flex items-center space-x-3 w-full">
            <div class="flex-grow max-w-sm">
                <label for="search" class="sr-only">Cari guru</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       id="search"
                       class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm"
                       placeholder="Cari berdasarkan nama atau NIP...">
            </div>
            
            <button type="button"
               wire:click="resetSearch"
               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                Reset
            </button>
        </div>
    </div>


    {{-- 3. Wrapper Tabel untuk Responsivitas --}}
    <div class="mt-8 flow-root">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full">
                    
                    {{-- 4. Header Tabel --}}
                    <thead class="sticky top-0 bg-[#F0E6D2]">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">No</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">NIP / Jabatan</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Mapel Diampu</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Telepon</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>

                    {{-- 5. Body Tabel --}}
                    <tbody class="text-gray-700">
                        @forelse($guru as $g)
                            <tr wire:key="guru-{{ $g->id }}">
                                <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">
                                    {{ ($guru->currentPage() - 1) * $guru->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                    <div class="font-bold text-[#333333]">{{ $g->nama ?? '-' }} {{ $g->gelar ?? '' }}</div>
                                    <div class="text-gray-500">{{ $g->wali?->nama_kelas ? 'Wali Kelas: ' . $g->wali->nama_kelas : '' }}</div>
                                </td>
                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                    <div class="font-medium text-[#333333]">NIP: {{ $g->nip ?? '-' }}</div>
                                    <div class="text-gray-500">{{ $g->jabatan ?? '-' }}</div>
                                </td>
                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                    {{ $g->mapel?->nama_mapel ?? '-' }}
                                </td>
                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                    {{ $g->telepon ?? '-' }}
                                </td>
                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                    @if($g->status_kepegawaian == 'PNS')
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                            PNS
                                        </span>
                                    @elseif($g->status_kepegawaian == 'GTY')
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                            GTY
                                        </span>
                                    @elseif($g->status_kepegawaian == 'GTT')
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                            GTT
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                            {{ $g->status_kepegawaian }}
                                        </span>
                                    @endif
                                </td>
                                <td class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    
                                    <div class="flex items-center justify-end space-x-4">
                                        {{-- Tombol Detail bisa dilihat semua --}}
                                        <a href="{{ route('guru.show', $g->id) }}" class="text-blue-600 hover:text-blue-800">
                                            Detail
                                        </a>

                                        {{-- RBAC: Hanya user dengan izin 'manage guru' yang bisa lihat Edit & Hapus --}}
                                        @can('manage guru')
                                        <a href="{{ route('guru.edit', $g->id) }}" class="text-[#2C5F2D] hover:text-[#214621]">
                                            Edit
                                        </a>
                                        
                                        <button type="button" 
                                                wire:click="deleteGuru({{ $g->id }})"
                                                wire:confirm="Yakin ingin menghapus guru ini? Akun login terkait (jika ada) akan ikut terhapus."
                                                class="text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                        @endcan

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                    @if($search)
                                        Guru dengan nama atau NIP "{{ $search }}" tidak ditemukan.
                                    @else
                                        Tidak ada data guru.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- 6. Link Paginasi --}}
                <div class="mt-8">
                    {{ $guru->links() }}
                </div>

            </div>
        </div>
    </div>
</div>