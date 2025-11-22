@extends('layouts.app')

@section('title', 'Proses Kenaikan Kelas | SIAP Al-Awwabin')

@section('content')

{{-- 
  Alpine.js untuk mengelola centang "Pilih Semua"
  dan mengaktifkan/menonaktifkan tombol aksi.
--}}
<form action="{{ route('kelas.processPromotion') }}" method="POST"
      x-data="{ 
        selectedSiswa: [],
        selectAll: false,
        
        toggleSelectAll() {
            this.selectAll = !this.selectAll;
            let checkboxes = document.querySelectorAll('.siswa-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = this.selectAll;
                this.updateSelected(cb.value, this.selectAll);
            });
        },
        updateSelected(siswaId, checked) {
            siswaId = parseInt(siswaId);
            if (checked) {
                if (!this.selectedSiswa.includes(siswaId)) {
                    this.selectedSiswa.push(siswaId);
                }
            } else {
                this.selectedSiswa = this.selectedSiswa.filter(id => id !== siswaId);
            }
        },
        isTargetDisabled() {
            return this.selectedSiswa.length === 0;
        },
        updateSelectAllCheckbox() {
            let allCheckboxes = document.querySelectorAll('.siswa-checkbox');
            let checkedCount = document.querySelectorAll('.siswa-checkbox:checked').length;
            this.selectAll = (allCheckboxes.length > 0 && checkedCount === allCheckboxes.length);
        }
      }"
      x-init="updateSelectAllCheckbox()">
    @csrf
    
    {{-- Hidden input untuk memberi tahu kelas mana yang sedang diproses --}}
    <input type="hidden" name="kelas_asal_id" value="{{ $kelas->id }}">

    {{-- 1. Header Halaman --}}
    <div class="mb-6 sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">
                Kelas {{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Pilih siswa yang akan diproses (naik kelas, lulus, atau tinggal kelas).
            </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16">
            <a href="{{ route('kelas.promotionTool') }}" 
               class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2 transition-colors">
               &larr; Kembali ke Pilihan Kelas
            </a>
        </div>
    </div>

    {{-- 2. Daftar Siswa dengan Checkbox --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-24"> {{-- mb-24 untuk memberi ruang panel sticky --}}
        <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-[#2C5F2D]">Daftar Siswa</h3>
            <span class="text-sm text-gray-600">Total: {{ $kelas->siswa->count() }} Siswa</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="relative py-3.5 pl-6 pr-3 w-12">
                            <input type="checkbox"
                                   x-model="selectAll"
                                   @click="toggleSelectAll()"
                                   class="h-4 w-4 rounded border-gray-300 text-[#2C5F2D] focus:ring-[#2C5F2D]">
                        </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Nama Siswa</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">NIS</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">L/P</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($kelas->siswa as $siswa)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer" @click="if($event.target.type !== 'checkbox') { $el.querySelector('.siswa-checkbox').click(); }">
                            <td class="relative py-4 pl-6 pr-3 w-12">
                                <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}"
                                       @click.stop="updateSelected($event.target.value, $event.target.checked); updateSelectAllCheckbox();"
                                       class="siswa-checkbox h-4 w-4 rounded border-gray-300 text-[#2C5F2D] focus:ring-[#2C5F2D]">
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">{{ $siswa->nama }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $siswa->nis }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $siswa->jenis_kelamin }}</td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="mt-2 text-sm font-medium">Tidak ada siswa di kelas ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 
      =========================================
      Panel Aksi (Sticky di Bawah)
      =========================================
    --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50 transition-transform duration-300"
         :class="{'translate-y-full': false}" {{-- Bisa ditambahkan logic hide/show jika perlu --}}>
        <div class="max-w-7xl mx-auto sm:flex sm:items-center sm:justify-between">
            <div class="flex-1 min-w-0 mb-4 sm:mb-0">
                <h4 class="text-base font-bold text-gray-900 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-[#2C5F2D] text-white text-xs">
                        <span x-text="selectedSiswa.length">0</span>
                    </span>
                    Siswa Dipilih
                </h4>
                <p class="text-xs text-gray-500 mt-1">
                    Pilih aksi untuk siswa yang dicentang.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3">
                
                {{-- Jika ini BUKAN kelas akhir (misal: 7 atau 8) --}}
                @if($kelas->tingkat < 9)
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select name="target_kelas_id" id="target_kelas_id"
                                :disabled="isTargetDisabled()"
                                class="block w-full sm:w-64 rounded-lg border-gray-300 text-sm focus:border-[#2C5F2D] focus:ring-[#2C5F2D] disabled:bg-gray-100 disabled:text-gray-400 transition-colors">
                            <option value="">-- Pilih Kelas Tujuan --</option>
                            @foreach($targetKelasList as $targetKelas)
                                <option value="{{ $targetKelas->id }}">
                                    Kelas {{ $targetKelas->tingkat }} - {{ $targetKelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" name="action" value="pindahkan"
                                :disabled="isTargetDisabled()"
                                class="whitespace-nowrap rounded-lg bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 disabled:bg-gray-300 disabled:cursor-not-allowed transition-all">
                            Pindahkan
                        </button>
                    </div>

                {{-- Jika ini ADALAH kelas akhir (misal: 9) --}}
                @else
                    <button type="submit" name="action" value="luluskan"
                            :disabled="isTargetDisabled()"
                            class="w-full sm:w-auto rounded-lg bg-red-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 disabled:bg-gray-300 disabled:cursor-not-allowed transition-all">
                        Luluskan Siswa
                    </button>
                @endif
                
                {{-- Tombol "Tinggal Kelas" (untuk siswa yang TIDAK dicentang) --}}
                <div class="border-l border-gray-300 pl-3 ml-1 hidden sm:block h-8"></div>
                
                <button type="submit" name="action" value="tinggal"
                        class="w-full sm:w-auto rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    Biarkan Tinggal
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
