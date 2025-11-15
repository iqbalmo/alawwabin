@extends('layouts.app')

@section('title', 'Proses Kenaikan Kelas | SITU Al-Awwabin')

@section('header-title', 'Alat Kenaikan Kelas')

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
    <div class="sm:flex sm:items-center sm:justify-between">
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
               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
               Kembali ke Pilihan Kelas
            </a>
        </div>
    </div>

    {{-- 2. Daftar Siswa dengan Checkbox --}}
    <div class="mt-8 flow-root">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full">
                    <thead class="sticky top-0 bg-[#F0E6D2]">
                        <tr>
                            <th scope="col" class="relative py-3.5 pl-4 pr-3 sm:pl-6">
                                <input type="checkbox"
                                       x-model="selectAll"
                                       @click="toggleSelectAll()"
                                       class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            </th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Nama Siswa</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">NIS</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-[#333333] uppercase tracking-wider">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($kelas->siswa as $siswa)
                            <tr>
                                <td class="relative py-4 pl-4 pr-3 sm:pl-6">
                                    <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}"
                                           @click="updateSelected($event.target.value, $event.target.checked); updateSelectAllCheckbox();"
                                           class="siswa-checkbox h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                </td>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">{{ $siswa->nama }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $siswa->nis }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $siswa->jenis_kelamin }}</td>
                            </tr>
                        @empty
                             <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">
                                    Tidak ada siswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 
      =========================================
      Panel Aksi (Sticky di Bawah)
      =========================================
    --}}
    <div class="sticky bottom-0 mt-12 bg-white/90 backdrop-blur-sm border-t border-gray-300 p-4 shadow-lg">
        <div class="max-w-7xl mx-auto sm:flex sm:items-center sm:justify-between">
            <div class="flex-1 min-w-0">
                <h4 class="text-lg font-semibold text-gray-900">
                    Aksi Massal
                </h4>
                <p class="text-sm text-gray-500">
                    <span x-text="selectedSiswa.length">0</span> siswa dipilih.
                </p>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-3 sm:mt-0 sm:ml-4">
                
                {{-- Jika ini BUKAN kelas akhir (misal: 7 atau 8) --}}
                @if($kelas->tingkat < 9)
                    <div class="flex items-center space-x-2">
                        <label for="target_kelas_id" class="text-sm font-medium text-gray-700">Pindahkan ke:</label>
                        <select name="target_kelas_id" id="target_kelas_id"
                                :disabled="isTargetDisabled()"
                                class="block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm
                                       disabled:bg-gray-100 disabled:text-gray-400">
                            <option value="">-- Pilih Kelas Tujuan --</option>
                            @foreach($targetKelasList as $targetKelas)
                                <option value="{{ $targetKelas->id }}">
                                    {{ $targetKelas->tingkat }} - {{ $targetKelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" name="action" value="pindahkan"
                                :disabled="isTargetDisabled()"
                                class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621]
                                       disabled:bg-gray-300 disabled:cursor-not-allowed">
                            Pindahkan
                        </button>
                    </div>

                {{-- Jika ini ADALAH kelas akhir (misal: 9) --}}
                @else
                    <button type="submit" name="action" value="luluskan"
                            :disabled="isTargetDisabled()"
                            class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700
                                   disabled:bg-gray-300 disabled:cursor-not-allowed">
                        Luluskan <span x-text="selectedSiswa.length">0</span> Siswa Terpilih
                    </button>
                @endif
                
                {{-- Tombol "Tinggal Kelas" (untuk siswa yang TIDAK dicentang) --}}
                <button type="submit" name="action" value="tinggal"
                        class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Tinggal di Kelas
                </button>
            </div>
        </div>
    </div>
</form>
@endsection