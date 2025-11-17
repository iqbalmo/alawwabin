<div>  {{-- <-- ELEMEN PEMBUNGKUS TUNGGAL (ROOT) --}}

    <!-- Header Halaman -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">
                Agenda Mengajar
            </h2>
            
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

    {{-- Form Filter Livewire --}}
    @hasrole('admin')
    <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-end gap-4">
            <div class="flex-grow">
                <label for="guru_id" class="block text-sm font-medium leading-6 text-gray-900">Filter Berdasarkan Guru</label>
                
                <select id="guru_id" wire:model.live="selectedGuruId" 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:max-w-xs sm:text-sm sm:leading-6">
                    <option value="">-- Tampilkan Semua Guru --</option>
                    @foreach($allGurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-shrink-0 flex gap-x-2">
                <button type="button" wire:click="resetFilter" 
                        class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Reset
                </button>
            </div>
        </div>
    </div>
    @endhasrole

    {{-- Indikator Loading (Muncul saat filter berubah) --}}
    <div wire:loading.delay.short>
        <div class="w-full text-center py-10 text-gray-500">
            <svg class="animate-spin h-8 w-8 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memuat jadwal...
        </div>
    </div>

    {{-- Konten Utama (Hanya tampil saat tidak loading) --}}
    <div wire:loading.remove>
        @if($orderedJadwals->isEmpty())
            <div class="text-center bg-white shadow-md rounded-lg p-12">
                <h3 class="text-lg font-semibold text-gray-800">Tidak Ada Jadwal</h3>
                <p class="mt-2 text-sm text-gray-500">
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
            <div class="space-y-8">
                {{-- Loop per HARI (Senin, Selasa, ...) --}}
                @foreach($orderedJadwals as $hari => $jadwals)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b bg-gray-50">
                            <h3 class="text-xl font-semibold text-[#2C5F2D]">{{ $hari }}</h3>
                        </div>
                        
                        <ul role="list" class="divide-y divide-gray-200">
                            {{-- Loop per JADWAL di hari itu --}}
                            @foreach($jadwals as $jadwal)
                            <li class="p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4" wire:key="{{ $jadwal->id }}">
                                <!-- Info Jadwal -->
                                <div class="flex-grow">
                                    <p class="text-lg font-bold text-gray-900">
                                        {{ $jadwal->mapel->nama_mapel }}
                                    </p>
                                    <p class="text-md text-gray-700 font-medium">
                                        Kelas: {{ $jadwal->kelas->tingkat }} - {{ $jadwal->kelas->nama_kelas }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Waktu: {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </p>
                                    @hasrole('admin')
                                    <p class="text-sm text-blue-600 font-medium pt-1">
                                        Guru: {{ $jadwal->guru->nama ?? 'N/A' }}
                                    </p>
                                    @endhasrole
                                </div>
                                
                                <!-- Info Progres -->
                                <div class="flex-shrink-0 text-left md:text-right">
                                    <p class="text-sm font-medium text-gray-700">Progres Mengajar:</p>
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                                        {{ $jadwal->agendas_count }} Pertemuan Tercatat
                                    </span>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex-shrink-0 flex items-center gap-x-2 w-full md:w-auto">
                                    @if(Auth::user()->can('manage agenda') && (Auth::user()->hasRole('admin') || $jadwal->guru_id == Auth::user()->guru_id))
                                    <a href="{{ route('agenda.create', ['jadwal_id' => $jadwal->id]) }}" 
                                       class="flex-1 w-full text-center rounded-md border border-transparent bg-[#C8963E] px-4 py-2 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937]">
                                       + Isi Agenda
                                    </a>
                                    @endif
                                    
                                    <a href="{{ route('agenda.show', $jadwal->id) }}" 
                                       class="flex-1 w-full text-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                       Lihat Riwayat
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div> {{-- <-- AKHIR DARI ELEMEN PEMBUNGKUS TUNGGAL --}}