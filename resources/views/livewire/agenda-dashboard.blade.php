<div>
    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Agenda Mengajar</h2>
            
            <p class="mt-2 text-sm text-gray-600">
                @if($selectedGuruId && $allGurus->isNotEmpty())
                    Menampilkan agenda untuk guru: <strong>{{ $allGurus->find($selectedGuruId)->nama ?? '' }}</strong>
                @else
                    @hasrole('admin')
                        Menampilkan progres semua guru. Gunakan filter untuk melihat guru spesifik.
                    @else
                        Daftar jadwal tetap Anda per hari. Klik "Isi Agenda" untuk mencatat absensi dan materi.
                    @endhasrole
                @endif
            </p>
        </div>
    </div>

    {{-- Filter (Admin Only) --}}
    @hasrole('admin')
    <div class="mb-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row sm:items-end gap-4">
            <div class="flex-grow">
                <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-2">Filter Berdasarkan Guru</label>
                
                <select id="guru_id" wire:model.live="selectedGuruId" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring-[#2C5F2D] sm:max-w-xs sm:text-sm">
                    <option value="">-- Tampilkan Semua Guru --</option>
                    @foreach($allGurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-shrink-0">
                <button type="button" wire:click="resetFilter" 
                        class="inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    Reset
                </button>
            </div>
        </div>
    </div>
    @endhasrole

    {{-- Loading Indicator --}}
    <div wire:loading.delay.short>
        <div class="w-full text-center py-12">
            <svg class="animate-spin h-8 w-8 text-[#2C5F2D] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="mt-2 text-sm text-gray-500">Memuat jadwal...</p>
        </div>
    </div>

    {{-- Content --}}
    <div wire:loading.remove>
        @if($orderedJadwals->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Tidak Ada Jadwal</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($selectedGuruId)
                        Guru ini tidak memiliki jadwal mengajar.
                    @else
                        @hasrole('admin')
                            Belum ada jadwal yang dibuat di sistem.
                        @else
                            Anda belum ditugaskan untuk mengajar jadwal apapun. Hubungi Admin.
                        @endhasrole
                    @endif
                </p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orderedJadwals as $hari => $jadwals)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2C5F2D]">{{ $hari }}</h3>
                        </div>
                        
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($jadwals as $jadwal)
                            <li class="p-6" wire:key="{{ $jadwal->id }}">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    {{-- Info Jadwal --}}
                                    <div class="flex-grow">
                                        <p class="text-lg font-bold text-gray-900">{{ $jadwal->mapel->nama_mapel }}</p>
                                        <p class="text-md text-gray-700 font-medium">
                                            Kelas: {{ $jadwal->kelas->tingkat }} - {{ $jadwal->kelas->nama_kelas }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Waktu: {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </p>
                                        @hasrole('admin')
                                        <p class="text-sm text-[#C8963E] font-medium pt-1">
                                            Guru: {{ $jadwal->guru->nama ?? 'N/A' }}
                                        </p>
                                        @endhasrole
                                    </div>
                                    
                                    {{-- Progres --}}
                                    <div class="flex-shrink-0 text-left md:text-right">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Progres Mengajar:</p>
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            {{ $jadwal->agendas_count }} Pertemuan Tercatat
                                        </span>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex-shrink-0 flex items-center gap-2 w-full md:w-auto">
                                        @if(Auth::user()->can('manage agenda') && (Auth::user()->hasRole('admin') || $jadwal->guru_id == Auth::user()->guru_id))
                                        <a href="{{ route('agenda.create', ['jadwal_id' => $jadwal->id]) }}" 
                                           class="flex-1 md:flex-none text-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] transition-all">
                                            + Isi Agenda
                                        </a>
                                        @endif
                                        
                                        <a href="{{ route('agenda.show', $jadwal->id) }}" 
                                           class="flex-1 md:flex-none text-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                                            Lihat Riwayat
                                        </a>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>