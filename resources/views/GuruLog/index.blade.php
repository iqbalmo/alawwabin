@extends('layouts.app')

@section('title', 'Dashboard Guru | SITU Al-Awwabin')

@section('content')

{{-- Welcome Banner --}}
<div class="mb-8">
    <div class="bg-gradient-to-r from-[#2C5F2D] to-[#1e3f20] rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
                <p class="mt-1 text-sm text-green-100">Ini adalah halaman dashboard Anda. Silakan catat aktivitas harian Anda.</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Main Column --}}
    <div class="lg:col-span-2 flex flex-col gap-6">
        
        {{-- Today's Schedule --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-[#2C5F2D]">Jadwal Mengajar Hari Ini</h3>
                <p class="text-sm text-gray-600 mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            
            @if ($jadwalHariIni->isEmpty())
                <div class="p-12 text-center">
                    <div class="mx-auto h-16 w-16 text-gray-300 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Tidak ada jadwal</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ada jadwal mengajar hari ini. Nikmati hari Anda!</p>
                </div>
            @else
                {{-- Desktop Table View --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Mata Pelajaran</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Kelas</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($jadwalHariIni as $jadwal)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 pl-6 pr-3 text-sm">
                                        <div class="font-semibold text-[#2C5F2D]">{{ $jadwal->mapel->nama_mapel }}</div>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-700">
                                        {{ $jadwal->kelas->tingkat }} - {{ $jadwal->kelas->nama_kelas }}
                                    </td>
                                    <td class="px-3 py-4 text-sm">
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card View --}}
                <div class="md:hidden divide-y divide-gray-200">
                    @foreach ($jadwalHariIni as $jadwal)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-[#2C5F2D] truncate">{{ $jadwal->mapel->nama_mapel }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $jadwal->kelas->tingkat }} - {{ $jadwal->kelas->nama_kelas }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>



        {{-- Today's Events Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1">
            <div class="bg-[#F0E6D2] px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-[#2C5F2D]">Agenda Hari Ini</h3>
            </div>
            <div class="p-4">
                @if($todayEvents->count() > 0)
                    <div class="space-y-3">
                        @foreach($todayEvents as $event)
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="w-1 h-full min-h-[2rem] bg-[#C8963E] rounded-full"></div>
                                <div>
                                    <h4 class="font-medium text-gray-900 text-sm">{{ $event->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @if($event->start_time)
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                            @if($event->end_time) - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} @endif
                                        @else
                                            Sepanjang hari
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-gray-500">
                        <p class="text-sm">Tidak ada agenda kegiatan hari ini.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Sidebar Column --}}
    <div class="lg:col-span-1 space-y-6">
        
        {{-- Calendar Widget --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2C5F2D] to-[#1e3f20] px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Kalender Kegiatan</h3>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="kalender-wrapper">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>



    </div>

</div>

{{-- Event Modal --}}
<div id="event-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div id="modal-overlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative w-full max-w-lg bg-white rounded-xl shadow-xl p-6">
        <div class="flex items-start justify-between mb-4">
            <h3 id="modal-title" class="text-xl font-semibold text-[#2C5F2D]">Detail Kegiatan</h3>
            <button id="modal-close-btn" type="button" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div>
            <div id="modal-no-events" class="text-center text-gray-500 py-8 hidden">
                <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <p class="font-medium text-gray-900">Tidak ada kegiatan</p>
                <p class="text-sm mt-1">Tidak ada kegiatan yang dijadwalkan pada tanggal ini.</p>
                <a href="#" id="modal-add-event-link" class="mt-3 inline-flex items-center text-[#C8963E] hover:text-[#b58937] text-sm font-medium transition-colors">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kegiatan
                </a>
            </div>

            <ul id="modal-event-list" class="space-y-2 max-h-96 overflow-y-auto">
                {{-- JavaScript will populate this --}}
            </ul>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />

    <style>
        /* Calendar Wrapper */
        .kalender-wrapper {
            all: revert;
            font-family: inherit;
        }

        .kalender-wrapper a {
            text-decoration: none !important;
            color: inherit !important;
        }

        #calendar {
            max-width: 100%;
            margin: 0 auto;
            font-size: 0.875rem;
        }

        /* Toolbar */
        .fc-header-toolbar {
            padding: 0.75rem 0.5rem !important;
            margin-bottom: 0.5rem !important;
            background: transparent;
            border-bottom: 1px solid #e5e7eb;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .fc-toolbar-title {
            font-size: 1rem !important;
            font-weight: 600;
            color: #2C5F2D !important;
            margin: 0;
        }

        .fc-button {
            background: white !important;
            border: 1px solid #d1d5db !important;
            color: #333 !important;
            font-size: 0.75rem !important;
            padding: 0.35rem 0.6rem !important;
            border-radius: 0.375rem !important;
            text-transform: capitalize;
            box-shadow: none !important;
            transition: all 0.2s;
        }

        .fc-button:hover {
            background: #f3f4f6 !important;
            border-color: #9ca3af !important;
        }

        .fc-button-primary:not(:disabled).fc-button-active,
        .fc-button-primary:not(:disabled):active {
            background: #C8963E !important;
            border-color: #C8963E !important;
            color: #333 !important;
        }

        .fc-today-button {
            background: #2C5F2D !important;
            border-color: #2C5F2D !important;
            color: white !important;
        }

        .fc-today-button:hover {
            background: #214621 !important;
            border-color: #214621 !important;
        }

        /* Day Headers */
        .fc-col-header-cell {
            background: transparent !important;
            border: none !important;
            padding: 0.5rem 0 !important;
        }

        .fc-col-header-cell-cushion {
            color: #6b7280;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Day Cells */
        .fc-daygrid-day {
            background: transparent;
            height: 5rem !important;
            position: relative;
            border: 1px solid #e5e7eb !important;
        }

        .fc-daygrid-day-number {
            position: absolute;
            top: 0.4rem;
            right: 0.4rem;
            font-size: 0.75rem;
            color: #333;
            font-weight: 500;
            z-index: 10;
        }

        .fc-day-other .fc-daygrid-day-number {
            color: #9ca3af;
        }

        /* Today */
        .fc-day-today {
            background: #f0fdf4 !important;
            border: 2px solid #2C5F2D !important;
        }

        .fc-day-today .fc-daygrid-day-number {
            background: #2C5F2D !important;
            color: white !important;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.75rem;
            top: 0.3rem;
            right: 0.3rem;
        }

        /* Sembunyikan semua event default dari FullCalendar */
        .fc-event,
        .fc-daygrid-event,
        .fc-daygrid-event-harness,
        .fc-daygrid-block-event,
        .fc-h-event {
            display: none !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .fc-header-toolbar {
                flex-direction: column;
                align-items: center;
            }

            .fc-toolbar-chunk {
                margin: 0.25rem 0;
            }

            .fc-button {
                font-size: 0.7rem !important;
                padding: 0.3rem 0.5rem !important;
            }

            .fc-daygrid-day {
                height: 4rem !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            const canManageEvents = @json(Auth::user()->can('manage events'));
            const today = new Date().toISOString().split('T')[0];

            // Helper: Check if event is on date
            const isEventOnDate = (event, targetDateStr) => {
                const startStr = event.startStr.split('T')[0];
                if (!event.end) return startStr === targetDateStr;
                const endStr = event.endStr.split('T')[0];
                return targetDateStr >= startStr && targetDateStr < endStr;
            };

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: canManageEvents ? 'addEventButton' : ''
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    list: 'Daftar'
                },
                customButtons: canManageEvents ? {
                    addEventButton: {
                        text: '+ Tambah',
                        click: () => window.location.href = '{{ route('events.create') }}'
                    }
                } : {},

                events: {!! $eventsJson !!},

                // Sembunyikan event default
                eventContent: function() {
                    return { html: '' };
                },

                dateClick: function(info) {
                    showModal(info.date);
                },

                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    showModal(info.event.start);
                },

                // Render custom dots
                eventsSet: function() {
                    renderEventDots();
                },
                
                datesSet: function() {
                    renderEventDots();
                }
            });

            // Debounce timer
            let renderTimeout = null;
            
            // Fungsi untuk render dots
            function renderEventDots() {
                if (renderTimeout) clearTimeout(renderTimeout);
                
                renderTimeout = setTimeout(() => {
                    document.querySelectorAll('.custom-event-dot').forEach(el => el.remove());
                    
                    document.querySelectorAll('.fc-daygrid-day').forEach(dayEl => {
                        const dateStr = dayEl.getAttribute('data-date');
                        if (!dateStr) return;
                        
                        if (dayEl.querySelector('.custom-event-dot')) return;
                        
                        const eventsOnDay = calendar.getEvents().filter(event => isEventOnDate(event, dateStr));
                        
                        if (eventsOnDay.length > 0) {
                            const lineContainer = document.createElement('div');
                            lineContainer.className = 'custom-event-dot absolute bottom-1 left-0 right-0 flex items-center justify-center gap-1';
                            lineContainer.style.cssText = 'cursor: pointer; height: 12px;';
                            
                            const line = document.createElement('div');
                            line.className = 'w-6 h-0.5 bg-[#C8963E] rounded-full flex-shrink-0';
                            
                            if (eventsOnDay.length > 1) {
                                const badge = document.createElement('span');
                                badge.className = 'text-[10px] font-bold text-[#C8963E] leading-none';
                                badge.textContent = `${eventsOnDay.length}`;
                                lineContainer.appendChild(line);
                                lineContainer.appendChild(badge);
                            } else {
                                lineContainer.appendChild(line);
                            }
                            
                            const dayFrame = dayEl.querySelector('.fc-daygrid-day-frame');
                            if (dayFrame) {
                                dayFrame.style.position = 'relative';
                                dayFrame.appendChild(lineContainer);
                            }
                            
                            lineContainer.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const date = new Date(dateStr + 'T00:00:00');
                                showModal(date);
                            });
                        }
                    });
                }, 100);
            }

            calendar.render();

            // Modal
            const modal = document.getElementById('event-modal');
            const closeModal = () => modal.classList.add('hidden');
            document.getElementById('modal-close-btn').onclick = closeModal;
            document.getElementById('modal-overlay').onclick = closeModal;

            window.showModal = function(date) {
                const formatted = date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                document.getElementById('modal-title').textContent = `Kegiatan pada ${formatted}`;

                const dateStr = date.toISOString().split('T')[0];
                const addEventLink = document.getElementById('modal-add-event-link');
                
                if (canManageEvents) {
                    addEventLink.href = '{{ route('events.create') }}?date=' + dateStr;
                    addEventLink.style.display = 'inline-flex';
                } else {
                    addEventLink.style.display = 'none';
                }

                const eventList = document.getElementById('modal-event-list');
                const noEvents = document.getElementById('modal-no-events');
                eventList.innerHTML = '';

                const events = calendar.getEvents().filter(e =>
                    new Date(e.start).toDateString() === date.toDateString()
                );

                if (events.length > 0) {
                    noEvents.classList.add('hidden');
                    eventList.classList.remove('hidden');
                    events.forEach(e => {
                        const li = document.createElement('li');
                        li.className = 'p-3 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-lg border border-amber-100 hover:shadow-sm transition-shadow';
                        
                        // Gunakan extendedProps jika ada, atau fallback ke default
                        let time = '';
                        if (e.extendedProps && e.extendedProps.start_time) {
                            time = e.extendedProps.start_time;
                            if (e.extendedProps.end_time) {
                                time += ' - ' + e.extendedProps.end_time;
                            }
                        } else if (e.start) {
                            time = e.start.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                            if (e.end) {
                                time += ' - ' + e.end.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                            }
                        }

                        li.innerHTML = `
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:${e.backgroundColor || '#C8963E'}"></div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-900">${e.title}</div>
                                ${time ? `<div class="text-xs text-gray-600 mt-1">${time}</div>` : ''}
                            </div>
                        </div>
                    `;
                        eventList.appendChild(li);
                    });
                } else {
                    noEvents.classList.remove('hidden');
                    eventList.classList.add('hidden');
                }

                modal.classList.remove('hidden');
            };
        });
    </script>
@endpush
