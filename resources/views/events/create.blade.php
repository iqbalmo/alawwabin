@extends('layouts.app')

@section('title', 'Tambah Event | SIAP Al-Awwabin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#2C5F2D]">Tambah Event Baru</h1>
        <p class="mt-1 text-sm text-gray-600">Jadwalkan kegiatan atau acara sekolah baru.</p>
    </div>

    <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-[#2C5F2D]">Detail Event</h3>
            </div>
            
            <div class="p-6 space-y-6">
                {{-- Judul Event --}}
                <div>
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Judul Event <span class="text-red-600">*</span></label>
                    <div class="mt-2">
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Contoh: Rapat Guru, Libur Nasional" required
                               class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                    {{-- Tanggal Mulai --}}
                    <div>
                        <label for="start_date" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Mulai <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                   class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div>
                        <label for="end_date" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Selesai (Opsional)</label>
                        <div class="mt-2">
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                   class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika hanya 1 hari.</p>
                    </div>
                </div>

                {{-- Waktu (hanya muncul jika event 1 hari) --}}
                <div id="time-fields" class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                    {{-- Jam Mulai --}}
                    <div>
                        <label for="start_time" class="block text-sm font-medium leading-6 text-gray-900">Jam Mulai (Opsional)</label>
                        <div class="mt-2">
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                                   class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            @error('start_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Jam Selesai --}}
                    <div>
                        <label for="end_time" class="block text-sm font-medium leading-6 text-gray-900">Jam Selesai (Opsional)</label>
                        <div class="mt-2">
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                                   class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#C8963E] sm:text-sm sm:leading-6">
                            @error('end_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Biarkan kosong untuk acara sepanjang hari.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-x-4">
            <a href="{{ route('events.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-[#C8963E] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#b58937] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600 transition-all">
                Simpan Event
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Toggle time fields visibility based on end_date
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const timeFields = document.getElementById('time-fields');

    function toggleTimeFields() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        
        // Tampilkan time fields jika:
        // 1. End date kosong (event 1 hari), ATAU
        // 2. Start date sama dengan end date
        if (!endDate || (startDate && endDate && startDate === endDate)) {
            timeFields.style.display = 'grid';
        } else {
            timeFields.style.display = 'none';
            // Clear time values jika multi-day
            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value = '';
        }
    }

    // Listen to changes
    startDateInput.addEventListener('change', toggleTimeFields);
    endDateInput.addEventListener('change', toggleTimeFields);

    // Initial check
    toggleTimeFields();
</script>
@endpush
@endsection
