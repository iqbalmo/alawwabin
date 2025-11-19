@extends('layouts.app')

@section('title', 'Beranda | SITU Al-Awwabin')

@section('content')
    <div class="space-y-8 animate-fade-in-up">

        {{-- 1. Welcome Section (Mobile Friendly) --}}
        <div class="bg-gradient-to-r from-[#2C5F2D] to-[#1e421f] rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}! 👋</h2>
                <p class="mt-2 text-gray-100 opacity-90 text-sm sm:text-base">
                    Berikut adalah ringkasan data statistik sekolah saat ini.
                </p>
            </div>
            {{-- Decorative Circle --}}
            <div class="absolute right-0 top-0 -mt-4 -mr-4 w-24 h-24 bg-[#C8963E] rounded-full opacity-20 blur-xl"></div>
            <div class="absolute right-10 bottom-0 -mb-8 w-32 h-32 bg-[#F0E6D2] rounded-full opacity-10 blur-xl"></div>
        </div>

        {{-- 2. Statistik Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Card Siswa --}}
            <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-5 flex items-center justify-between hover:shadow-md transition-shadow duration-300">
                <div>
                    <p class="text-sm font-medium text-[#6b7280]">Total Siswa</p>
                    <p class="mt-1 text-3xl font-bold text-[#333333]">{{ $jumlahSiswa ?? 0 }}</p>
                </div>
                <div class="p-3 bg-[#F0E6D2] rounded-full text-[#2C5F2D]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            {{-- Card Guru --}}
            <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-5 flex items-center justify-between hover:shadow-md transition-shadow duration-300">
                <div>
                    <p class="text-sm font-medium text-[#6b7280]">Total Guru</p>
                    <p class="mt-1 text-3xl font-bold text-[#333333]">{{ $jumlahGuru ?? 0 }}</p>
                </div>
                <div class="p-3 bg-[#F0E6D2] rounded-full text-[#C8963E]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            {{-- Card Kelas --}}
            <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-5 flex items-center justify-between hover:shadow-md transition-shadow duration-300">
                <div>
                    <p class="text-sm font-medium text-[#6b7280]">Total Kelas</p>
                    <p class="mt-1 text-3xl font-bold text-[#333333]">{{ $jumlahKelas ?? 0 }}</p>
                </div>
                <div class="p-3 bg-[#F0E6D2] rounded-full text-[#2C5F2D]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            {{-- 3. Grafik Chart.js --}}
            <div class="lg:col-span-3 bg-white border border-gray-100 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-semibold text-[#333333] mb-6 flex items-center">
                    <span class="w-1 h-6 bg-[#C8963E] rounded-full mr-3"></span>
                    Statistik Data Sekolah
                </h3>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-8">
                    {{-- Chart Area --}}
                    <div class="relative h-64 w-64">
                        <canvas id="chartData"></canvas>
                    </div>
                    
                    {{-- Legend / Details Area --}}
                    <div class="flex-1 w-full max-w-xs space-y-4">
                        <div class="flex items-center justify-between p-3 bg-[#F9F9F9] rounded-lg border border-gray-100">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-[#2C5F2D] mr-3"></span>
                                <span class="text-sm font-medium text-[#333333]">Siswa</span>
                            </div>
                            <span class="text-lg font-bold text-[#2C5F2D]">{{ $jumlahSiswa }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#F9F9F9] rounded-lg border border-gray-100">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-[#C8963E] mr-3"></span>
                                <span class="text-sm font-medium text-[#333333]">Guru</span>
                            </div>
                            <span class="text-lg font-bold text-[#C8963E]">{{ $jumlahGuru }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#F9F9F9] rounded-lg border border-gray-100">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-[#8A9A5B] mr-3"></span>
                                <span class="text-sm font-medium text-[#333333]">Kelas</span>
                            </div>
                            <span class="text-lg font-bold text-[#8A9A5B]">{{ $jumlahKelas }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. Kalender Mini / Agenda --}}
            <div class="lg:col-span-2 bg-white border border-gray-100 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-semibold text-[#333333] mb-4 flex items-center">
                    <span class="w-1 h-6 bg-[#2C5F2D] rounded-full mr-3"></span>
                    Kalender Kegiatan
                </h3>
                <div id="calendar" class="text-sm"></div>
            </div>
        </div>

        {{-- Modal Detail Event --}}
        <div id="event-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" x-data>
            <div id="modal-overlay" class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity"></div>
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 transform transition-all scale-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="modal-title" class="text-xl font-bold text-[#2C5F2D]">
                        Detail Kegiatan
                    </h3>
                    <button id="modal-close-btn" type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-2">
                    <div id="modal-no-events" class="text-center text-gray-500 py-8 hidden">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p>Tidak ada kegiatan.</p>
                        <a href="#" id="modal-add-event-link" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#C8963E] hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C8963E] transition-colors">
                            + Tambah Kegiatan
                        </a>
                    </div>

                    <ul id="modal-event-list" class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        {{-- JavaScript akan mengisi ini --}}
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
    <style>
        /* Custom Scrollbar for Modal List */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* FullCalendar Customization for 'Harmoni Klasik' */
        .fc {
            --fc-border-color: #f3f4f6;
            --fc-button-text-color: #333333;
            --fc-button-bg-color: #ffffff;
            --fc-button-border-color: #e5e7eb;
            --fc-button-hover-bg-color: #f9fafb;
            --fc-button-hover-border-color: #d1d5db;
            --fc-button-active-bg-color: #F0E6D2;
            --fc-button-active-border-color: #C8963E;
            --fc-event-bg-color: #C8963E;
            --fc-event-border-color: #C8963E;
            --fc-today-bg-color: #F0E6D2;
        }

        .fc-toolbar-title {
            font-size: 1.1rem !important;
            font-weight: 700;
            color: #2C5F2D;
        }

        .fc-button {
            font-size: 0.75rem !important;
            font-weight: 600;
            text-transform: capitalize;
            box-shadow: none !important;
        }
        
        .fc-daygrid-day-number {
            color: #333333;
            font-weight: 500;
        }

        .fc-col-header-cell-cushion {
            color: #6b7280;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        // ===== Grafik Chart.js =====
        const ctx = document.getElementById('chartData').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Siswa', 'Guru', 'Kelas'],
                datasets: [{
                    data: [{{ $jumlahSiswa }}, {{ $jumlahGuru }}, {{ $jumlahKelas }}],
                    backgroundColor: [
                        '#2C5F2D', // Hijau Utama
                        '#C8963E', // Aksen Emas
                        '#8A9A5B'  // Hijau Zaitun
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', // Membuat lubang tengah lebih besar
                plugins: {
                    legend: { display: false }, // Kita pakai legend custom HTML
                    tooltip: {
                        backgroundColor: '#333333',
                        padding: 12,
                        cornerRadius: 8,
                    }
                }
            }
        });

        // ===== FullCalendar =====
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('event-modal');
            const modalOverlay = document.getElementById('modal-overlay');
            const modalCloseBtn = document.getElementById('modal-close-btn');
            const modalTitle = document.getElementById('modal-title');
            const modalEventList = document.getElementById('modal-event-list');
            const modalNoEvents = document.getElementById('modal-no-events');
            const modalAddEventLink = document.getElementById('modal-add-event-link');
            let calendarEl = document.getElementById('calendar');
            let calendar;

            const closeModal = () => modal.classList.add('hidden');
            modalCloseBtn.onclick = closeModal;
            modalOverlay.onclick = closeModal;

            const showDateDetails = (date) => {
                const formattedDate = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                modalTitle.textContent = `Kegiatan: ${formattedDate}`;
                const dateStr = date.toISOString().split('T')[0];
                modalAddEventLink.href = '{{ route('events.create') }}' + '?date=' + dateStr;
                modalEventList.innerHTML = '';

                const allEvents = calendar.getEvents();
                const eventsOnDay = allEvents.filter(event => event.start.toDateString() === date.toDateString());

                if (eventsOnDay.length > 0) {
                    modalNoEvents.classList.add('hidden');
                    modalEventList.classList.remove('hidden');
                    eventsOnDay.forEach(event => {
                        const li = document.createElement('li');
                        li.className = 'p-3 bg-[#F9F9F9] rounded-lg border border-gray-100 flex items-start space-x-3';
                        
                        let timeString = '';
                        if (event.start) {
                            timeString = event.start.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                        }

                        li.innerHTML = `
                            <div class="mt-1.5 flex-shrink-0 h-2 w-2 bg-[#C8963E] rounded-full"></div>
                            <div>
                                <p class="text-[#333333] font-semibold text-sm">${event.title}</p>
                                <p class="text-xs text-[#6b7280] mt-0.5">${timeString}</p>
                            </div>
                        `;
                        modalEventList.appendChild(li);
                    });
                } else {
                    modalNoEvents.classList.remove('hidden');
                    modalEventList.classList.add('hidden');
                }
                modal.classList.remove('hidden');
            };

            if (calendarEl) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next'
                    },
                    height: 'auto',
                    events: '{{ route('events.index') }}',
                    dateClick: function(info) { showDateDetails(info.date); },
                    eventClick: function(info) { 
                        info.jsEvent.preventDefault(); 
                        showDateDetails(info.event.start); 
                    },
                    eventDidMount: function(info) {
                        info.el.style.backgroundColor = '#C8963E';
                        info.el.style.borderColor = '#C8963E';
                    }
                });
                calendar.render();
            }
        });
    </script>
@endpush
