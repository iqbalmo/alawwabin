<div>
    {{-- 
      Ini adalah file view untuk komponen Livewire.
      Semua HTML dari ekskul/show.blade.php dipindahkan ke sini.
    --}}

    {{-- Notifikasi (wajib untuk Livewire) --}}
    @if (session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif


    {{-- 1. Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">{{ $ekskul->nama_ekskul }}</h2>
            <p class="mt-2 text-sm text-gray-600">
                Pembina: <strong>{{ $ekskul->pembina?->nama ?? 'Belum Ditentukan' }}</strong>
            </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16">
            <a href="{{ route('ekskul.index') }}"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                Kembali ke Daftar Ekskul
            </a>
        </div>
    </div>

    {{-- 2. Form Tambah Siswa (DI-WIRE) --}}
    @can('manage ekskul')
    <div class="mt-8">
        {{-- 
          PERUBAHAN: 
          - <form action... method="POST"> diubah menjadi <form wire:submit="attachSiswa">
        --}}
        <form wire:submit="attachSiswa"
            class="sm:flex sm:items-start sm:space-x-4 p-6 bg-gray-50 rounded-lg shadow-sm border">
            <div class="flex-1 min-w-0">
                <label for="siswa_id_to_add" class="block text-sm font-medium text-gray-700 mb-1">Tambahkan Siswa ke
                    Ekskul Ini</label>
                {{-- 
                  PERUBAHAN: 
                  - name="siswa_id" diubah menjadi wire:model="siswa_id_to_add"
                --}}
                <select wire:model="siswa_id_to_add" id="siswa_id_to_add"
                    class="block w-full border-0 border-b-2 border-gray-200 bg-gray-50 px-3 py-1.5 focus:border-green-600 focus:ring-0 sm:text-sm"
                    required>
                    <option value="">-- Pilih Siswa (Hanya siswa yang belum terdaftar) --</option>
                    @forelse($siswaTersedia as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->nama }} (NIS: {{ $siswa->nis }})</option>
                    @empty
                        <option value="" disabled>Semua siswa aktif sudah terdaftar.</option>
                    @endforelse
                </select>
                @error('siswa_id_to_add')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4 sm:mt-5">
                <button type="submit"
                    class="inline-flex w-full sm:w-auto items-center rounded-md border border-transparent bg-[#2C5F2D] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#214621]">
                    + Tambahkan
                </button>
            </div>
        </form>
    </div>
    @endcan


    {{-- 3. Wrapper Tabel Anggota Terdaftar (DI-WIRE) --}}
    <div class="mt-8 flow-root">
        <h3 class="text-lg font-semibold leading-7 text-gray-900 mb-4">Daftar Anggota Saat Ini
            ({{ $ekskul->siswas->count() }})</h3>
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full">
                    <thead class="sticky top-0 bg-[#F0E6D2]">
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                No</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                Nama Siswa</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                NIS</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">
                                Kelas</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($ekskul->siswas as $siswa)
                            {{-- wire:key sangat penting untuk list --}}
                            <tr wire:key="siswa-{{ $siswa->id }}">
                                <td class="border-t border-gray-200 py-5 pl-4 pr-3 text-sm">{{ $loop->iteration }}</td>
                                <td class="border-t border-gray-200 px-3 py-5 text-sm">
                                    <div class="font-bold text-[#333333]">{{ $siswa->nama }}</div>
                                </td>
                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                    {{ $siswa->nis }}
                                </td>
                                <td class="border-t border-gray-200 px-3 py-5 text-sm whitespace-nowrap">
                                    {{ $siswa->kelas?->tingkat }} - {{ $siswa->kelas?->nama_kelas ?? 'N/A' }}
                                </td>
                                <td
                                    class="border-t border-gray-200 relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    {{-- 
                                      PERUBAHAN: 
                                      - <form> diubah menjadi <button>
                                      - Aksi diubah menjadi wire:click="detachSiswa(...)"
                                    --}}
                                    <button type="button" wire:click="detachSiswa({{ $siswa->id }})"
                                        wire:confirm="Yakin ingin mengeluarkan siswa ini dari ekskul?"
                                        class="text-red-600 hover:text-red-800">
                                        Keluarkan
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border-t border-gray-200 py-8 text-center text-gray-500">
                                    Belum ada siswa yang terdaftar di ekskul ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
