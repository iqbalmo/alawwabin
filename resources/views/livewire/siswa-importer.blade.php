<div>
    {{-- Notifikasi Sukses / Error --}}
    @if ($importSuccess)
        <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">Impor data siswa berhasil!</p>
                </div>
            </div>
        </div>
    @endif
    @if (count($importErrors) > 0)
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Impor Gagal. Ditemukan {{ count($importErrors) }}
                        error:</h3>
                    <ul role="list" class="list-disc space-y-1 pl-5 mt-2 text-sm text-red-700">
                        @foreach ($importErrors as $failure)
                            <li>
                                Baris {{ $failure['row'] }}:
                                {{ $failure['errors'][0] }}
                                (Kolom: {{ $failure['attribute'] }})
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    @endif
    @error('file')
        <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
    @enderror


    {{-- LANGKAH 1: UPLOAD FILE --}}
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold leading-7 text-gray-900">Langkah 1: Upload File Excel</h3>
        <p class="mt-1 text-sm text-gray-600">Pilih file Excel (.xlsx) atau .csv yang berisi data siswa Anda.</p>

        <div class="mt-4">
            <div wire:loading wire:target="file" class="text-sm text-gray-500">
                <svg class="animate-spin h-5 w-5 text-gray-400 inline-block" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Sedang membaca file...
            </div>

            <div wire:loading.remove wire:target="file">
                <input type="file" id="file" wire:model="file"
                    class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-green-50 file:text-green-700
                    hover:file:bg-green-100
                " />
            </div>
        </div>
    </div>


    {{-- LANGKAH 2: MAPPING KOLOM (Hanya muncul jika file sudah di-upload) --}}
    @if (count($friendlyHeaders) > 0)
        <div class="mt-8">
            <h3 class="text-lg font-semibold leading-7 text-gray-900">Langkah 2: Petakan Kolom</h3>
            <p class="mt-1 text-sm text-gray-600">Cocokkan kolom di database Anda (kiri) dengan judul kolom dari file
                Excel Anda (kanan). Kami sudah mencoba menebaknya untuk Anda.</p>

            {{-- --- TAMPILAN BARU YANG DIKELOMPOKKAN --- --}}
            <div class="space-y-10 mt-6">
                {{-- Loop luar untuk GRUP (Cth: "Data Inti Siswa") --}}
                @foreach ($dbColumns as $groupName => $columns)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                        <h4 class="text-md font-semibold text-gray-800">{{ $groupName }}</h4>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            {{-- Loop dalam untuk KOLOM (Cth: "Nama Lengkap") --}}
                            @foreach ($columns as $dbCol => $label)
                                <div>
                                    <label for="mapping.{{ $dbCol }}"
                                        class="block text-sm font-medium leading-6 text-gray-900">
                                        {{ $label }}
                                        {{-- Tanda bintang untuk kolom wajib --}}
                                        @if (in_array($dbCol, ['nama', 'nis', 'tingkat', 'nama_kelas']))
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>

                                    {{-- --- INI ADALAH DROPDOWN YANG DIPERBARUI --- --}}
                                    <select id="mapping.{{ $dbCol }}" wire:model="mapping.{{ $dbCol }}"
                                        {{-- 1. Menggunakan style baru dari Anda + 'mt-2' --}}
                                        class="mt-2 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 shadow-sm focus:outline-none focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm
                                                   {{-- 2. Menjaga logika border merah jika wajib & belum dipilih --}}
                                                   @if (in_array($dbCol, ['nama', 'nis', 'tingkat', 'nama_kelas'])) {{ $mapping[$dbCol] ?? '' ? 'border-gray-300' : 'border-red-400 ring-1 ring-red-400' }} @endif">
                                        <option value="">-- Pilih Kolom Excel --</option>

                                        @foreach ($friendlyHeaders as $originalHeader => $friendlyName)
                                            <option value="{{ $originalHeader }}">{{ $friendlyName }}</option>
                                        @endforeach
                                    </select>
                                    {{-- ----------------------------------------- --}}

                                    @error("mapping.$dbCol")
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- --------------------------------- --}}
        </div>

        {{-- LANGKAH 3: TOMBOL PROSES --}}
        <div class="mt-8 flex justify-end">
            <button type="button" wire:click="import" wire:loading.attr="disabled"
                class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] 
                           disabled:bg-gray-400 disabled:cursor-wait">
                <span wire:loading.remove wire:target="import">
                    Proses dan Impor Data Siswa
                </span>
                <span wire:loading wire:target="import">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </div>
    @endif
</div>
