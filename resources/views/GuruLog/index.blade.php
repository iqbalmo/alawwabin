@extends('layouts.app')

{{-- 
  File ini sekarang berfungsi sebagai "Dashboard" untuk Guru,
  mirip dengan home.blade.php untuk Admin.
--}}

@section('title', 'Dashboard Guru | SITU Al-Awwabin')
@section('header-title', 'Dashboard Guru')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- KOLOM UTAMA (KIRI) --}}
        <div class="md:col-span-2 space-y-8">

            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-[#2C5F2D]">Selamat Datang, {{ Auth::user()->name }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Ini adalah halaman dashboard Anda. Silakan catat aktivitas harian Anda.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg flex flex-col flex-grow">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Jadwal Mengajar Anda Hari Ini
                    ({{ now()->translatedFormat('l, d F Y') }})</h3>
            </div>
            @if ($jadwalHariIni->isEmpty())
                <div class="p-6 text-center text-gray-500">
                    Tidak ada jadwal mengajar hari ini.
                </div>
            @else
                <ul role="list" class="divide-y divide-gray-200 flex-grow overflow-y-auto">
                    @foreach ($jadwalHariIni as $jadwal)
                        <li class="flex items-center justify-between px-6 py-4">
                            <div class="flex-grow">
                                <p class="text-md font-semibold text-[#2C5F2D]">
                                    {{ $jadwal->mapel->nama_mapel }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $jadwal->kelas->tingkat }} - {{ $jadwal->kelas->nama_kelas }}
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        </div>

        {{-- KOLOM SIDEBAR (KANAN) --}}
        {{-- GANTI BAGIAN KALENDER DI KOLOM KANAN --}}
        <div class="md:col-span-1 space-y-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b bg-gradient-to-r from-[#2C5F2D] to-[#1e3f20]">
                    <h3 class="text-lg font-semibold text-white">Kalender Kegiatan</h3>
                </div>
                <div class="p-3 bg-gray-50">
                    <div class="kalender-wrapper">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- 
==================================================================
PERBAIKAN: Tambahkan Modal HTML dari home.blade.php
==================================================================
--}}
    <div id="event-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div id="modal-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="relative w-full max-w-lg bg-white rounded-lg shadow-xl p-6">
            <div class="flex items-start justify-between">
                <h3 id="modal-title" class="text-xl font-semibold text-[#2C5F2D]">
                    Detail Kegiatan
                </h3>
                <button id="modal-close-btn" type="button" class="text-gray-400 hover:text-gray-700">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-4">
                <div id="modal-no-events" class="text-center text-gray-500 py-4 hidden">
                    <p>Tidak ada kegiatan yang dijadwalkan.</p>
                    <a href="#" id="modal-add-event-link"
                        class="mt-2 inline-block text-[#C8963E] hover:text-[#b58937] text-sm">
                        + Tambah Kegiatan
                    </a>
                </div>

                <ul id="modal-event-list" class="space-y-3 max-h-60 overflow-y-auto">
                    {{-- JavaScript akan mengisi ini --}}
                </ul>
            </div>
        </div>
    </div>
@endsection


{{-- 
==================================================================
PERBAIKAN: Tambahkan @push('styles') dari home.blade.php
==================================================================
--}}
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />

    <style>
        /* RESET & WRAPPER */
        .kalender-wrapper {
            all: revert;
            font-family: inherit;
        }

        .kalender-wrapper a {
            text-decoration: none !important;
            color: inherit !important;
        }

        /* KALENDER CONTAINER */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
            font-size: 0.875rem;
        }

        /* TOOLBAR */
        .fc-header-toolbar {
            padding: 0.75rem 0.5rem !important;
            margin-bottom: 0.5rem !important;
            background: transparent;
            border-bottom: 1px solid #e5e7eb;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .fc-toolbar-title {
            font-size: 1.1rem !important;
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
        }

        .fc-button:hover {
            background: #f3f4f6 !important;
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

        /* HARI & TANGGAL */
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

        .fc-daygrid-day {
            background: transparent;
            height: 5.5rem !important;
            position: relative;
            border: 1px solid #e5e7eb !important;
        }

        .fc-daygrid-day-number {
            position: absolute;
            top: 0.4rem;
            right: 0.4rem;
            font-size: 0.8rem;
            color: #333;
            font-weight: 500;
            z-index: 10;
        }

        .fc-day-other .fc-daygrid-day-number {
            color: #9ca3af;
        }

        /* HARI INI */
        .fc-day-today {
            background: #f0fdf4 !important;
            border: 2px solid #2C5F2D !important;
            border-radius: 0.5rem;
        }

        .fc-day-today .fc-daygrid-day-number {
            background: #2C5F2D !important;
            color: white !important;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
            top: 0.3rem;
            right: 0.3rem;
            position: absolute;
            z-index: 20;
        }

        /* EVENT */
        .fc-event {
            margin: 1px 2px;
            padding: 1px 4px !important;
            font-size: 0.68rem !important;
            border-radius: 0.375rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
            border: none !important;
        }

        .fc-daygrid-event-harness {
            margin-top: 1.8rem;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .fc-header-toolbar {
                flex-direction: column;
                align-items: center;
            }

            .fc-toolbar-chunk {
                margin: 0.25rem 0;
            }

            .fc-button {
                font-size: 0.7rem;
                padding: 0.3rem 0.5rem;
            }
        }
    </style>
@endpush
{{-- ================================================================== --}}



@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            const canManageEvents = @json(Auth::user()->can('manage events'));
            const today = new Date().toISOString().split('T')[0];

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: canManageEvents ?
                        'dayGridMonth,timeGridWeek,listWeek addEventButton' :
                        'dayGridMonth,timeGridWeek,listWeek'
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

                dateClick: function(info) {
                    showModal(info.date);
                },

                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    showModal(info.event.start);
                },

                eventContent: function(arg) {
                    const title = arg.event.title;
                    const time = arg.timeText ?
                        `<small style="opacity:0.8; margin-left:4px;">${arg.timeText}</small>` : '';
                    return {
                        html: `<div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-weight:500; font-size:0.7rem;">
                             ${title}${time}
                           </div>`
                    };
                },

                eventDidMount: function(info) {
                    info.el.style.backgroundColor = info.event.backgroundColor || '#C8963E';
                    info.el.style.borderColor = info.event.borderColor || '#C8963E';
                    info.el.style.color = '#333';
                },

                dayCellDidMount: function(info) {
                    if (info.date.toISOString().split('T')[0] === today) {
                        info.el.style.backgroundColor = '#f0fdf4';
                    }
                }
            });

            calendar.render();

            // === MODAL ===
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
                document.getElementById('modal-add-event-link').href = '{{ route('events.create') }}?date=' +
                    dateStr;

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
                        li.className = 'p-2 bg-amber-50 rounded-lg text-sm';
                        const time = e.start ?
                            e.start.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) +
                            (e.end ? ' - ' + e.end.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : '') :
                            '';
                        li.innerHTML = `
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full" style="background:${e.backgroundColor || '#C8963E'}"></div>
                            <div>
                                <div class="font-medium text-[#333]">${e.title}</div>
                                <div class="text-xs text-gray-600">${time}</div>
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
