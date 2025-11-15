@extends('layouts.app')

@section('title', 'Beranda | SITU Al-Awwabin')

@section('content')

    <div class="space-y-8">

        {{-- 1. Statistik --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                <div class="p-5 text-center">
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Jumlah Siswa</p>
                    <p class="mt-2 text-3xl font-semibold text-[#C8963E]">{{ $jumlahSiswa ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                <div class="p-5 text-center">
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Jumlah Guru</p>
                    <p class="mt-2 text-3xl font-semibold text-[#C8963E]">{{ $jumlahGuru ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                <div class="p-5 text-center">
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Jumlah Kelas</p>
                    <p class="mt-2 text-3xl font-semibold text-[#C8963E]">{{ $jumlahKelas ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- 2. Grafik Chart.js --}}
        <div class="bg-white border border-gray-200 shadow-sm rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-[#333333] text-center mb-4">📊 Grafik Data Sekolah</h3>
                <div class="">
                    <canvas id="chartData"></canvas>
                </div>
            </div>
        </div>

        {{-- 3. Kalender --}}
        <div>
            {{-- Elemen kalender --}}
            <div id="calendar"></div>
        </div>

        <div id="event-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
            <div id="modal-overlay" class="absolute inset-0 bg-black/50"></div> <div class="relative w-full max-w-lg bg-white rounded-lg shadow-xl p-6">
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
    </div>
@endsection

@push('styles')
    {{-- FullCalendar CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />

    {{-- CSS Kustom (DIROMBAK TOTAL UNTUK TEMA TERANG) --}}
    <style>
        /* * Palet "Harmoni Klasik"
         * Hijau Utama: #2C5F2D
         * Aksen Emas: #C8963E
         * Netral Latar (Body): #F9F9F9
         * Netral Sekunder (Krem): #F0E6D2
         * Teks Arang: #333333
        */

        #calendar {
            background-color: transparent;
        }

        .fc-theme-standard,
        .fc table {
            border: none !important;
        }

        /* * Toolbar Header (Oktober 2025, Tombol, dll) */
        .fc .fc-header-toolbar {
            background-color: transparent;
            padding: 1rem 0;
            border-bottom: 1px solid #e5e7eb; /* gray-200 */
            margin-bottom: 0 !important;
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2C5F2D; /* Hijau Utama */
        }

        .fc .fc-button-group,
        .fc .fc-today-button {
            margin-left: 0.5rem;
        }

        /* * Styling Tombol Toolbar (Prev, Next, Today, Month) */
        .fc .fc-button {
            background-color: #ffffff; /* Putih */
            border-color: #d1d5db; /* gray-300 */
            color: #333333; /* Teks Arang */
            font-weight: 500;
            box-shadow: none;
            font-size: 0.875rem;
            text-transform: capitalize;
            border-radius: 0.375rem;
        }

        .fc .fc-button:hover {
            background-color: #f3f4f6; /* gray-100 */
        }

        /* Tombol Aktif (Month, Week) diubah ke Aksen Emas */
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #C8963E; /* Aksen Emas */
            border-color: #C8963E;
            color: #333333; /* Teks Arang */
        }
         .fc .fc-button-primary:not(:disabled).fc-button-active:hover {
            background-color: #b58937;
            border-color: #b58937;
         }

        .fc .fc-button:focus {
            box-shadow: 0 0 0 2px rgba(200, 150, 62, 0.5); /* Fokus Emas */
        }

        /* * Styling Tombol Kustom "Add Event" diubah ke Aksen Emas */
        .fc .fc-addEventButton-button {
            background-color: #C8963E; /* Aksen Emas */
            border-color: #C8963E;
            color: #333333; /* Teks Arang */
            margin-left: 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
        }

        .fc .fc-addEventButton-button:hover {
            background-color: #b58937; /* Aksen Emas (Gelap) */
            border-color: #b58937;
        }

        /* * Grid & Border Kalender */
        .fc-theme-standard th,
        .fc-theme-standard td {
            border-color: #e5e7eb; /* gray-200 */
        }

        .fc .fc-view-harness {
            border: none;
        }

        /* * Header Hari (Mon, Tue, Wed) */
        .fc .fc-col-header {
            border: none;
        }

        .fc .fc-col-header-cell {
            background-color: transparent;
            border: none;
        }

        .fc .fc-col-header-cell-cushion {
            color: #6b7280; /* gray-500 */
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 0;
        }

        /* * Sel Tanggal (Latar Belakang) */
        .fc .fc-daygrid-day,
        .fc .fc-day-other {
            background-color: transparent;
            position: relative;
        }

        /* Latar 'Hari ini' diubah ke Krem Kuning */
        .fc .fc-day-today {
            background: #F0E6D2 !important; /* Krem Kuning */
        }

        /* * Angka Tanggal */
        .fc .fc-daygrid-day-top {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            z-index: 10;
        }

        .fc .fc-daygrid-day-number {
            color: #333333; /* Teks Arang */
            font-size: 0.875rem;
        }

        /* Angka di bulan lain (abu-abu) */
        .fc .fc-day-other .fc-daygrid-day-number {
            color: #9ca3af; /* gray-400 */
        }

        /* Angka 'Hari ini' diubah ke Hijau Utama */
        .fc .fc-day-today .fc-daygrid-day-number {
            background-color: #2C5F2D; /* Hijau Utama */
            color: #fff;
            border-radius: 9999px;
            height: 1.75rem;
            width: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* * Styling Event */
        .fc-event {
            padding: 1px 0 !important;
            cursor: pointer;
        }

        .fc-daygrid-day-events {
            position: relative;
            z-index: 5;
            padding-top: 2.5rem; /* Beri ruang di bawah angka */
        }

        .fc-list {
            border: none !important;
        }

        /* Tampilan List: Header Hari diubah ke Krem Kuning */
        .fc .fc-list-day-cushion {
            background-color: #F0E6D2; /* Krem Kuning */
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }

        .fc .fc-list-day-text {
            color: #333333; /* Teks Arang */
        }

        .fc .fc-list-day-side-text {
            color: #6b7280; /* gray-500 */
        }

        .fc .fc-list-event {
            background-color: transparent !important;
        }

        .fc .fc-list-event:hover td {
            background-color: #f9fafb !important; /* gray-50 */
        }

        .fc .fc-list-event-title a {
            color: #333333; /* Teks Arang */
        }

        .fc .fc-list-event-dot {
            border-color: var(--fc-event-bg-color, #C8963E) !important; /* Aksen Emas */
        }

        .fc .fc-list-event-time {
            color: #6b7280; /* gray-500 */
        }

        /* Tampilan Week: Header Hari */
        .fc .fc-timegrid-col-header-cell-cushion {
            color: #333333; /* Teks Arang */
            font-size: 0.875rem;
        }

        /* Tampilan Week: Garis Jam */
        .fc-theme-standard .fc-timegrid-slots tr>td,
        .fc .fc-timegrid-slot-lane {
            border-color: #e5e7eb; /* gray-200 */
        }

        /* Tampilan Week: Teks Jam */
        .fc .fc-timegrid-slot-label-cushion {
            color: #6b7280; /* gray-500 */
        }
    </style>
@endpush



@push('scripts')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- FullCalendar JS --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        // ===== Grafik Chart.js (Diubah ke Palet Harmoni Klasik) =====
        const ctx = document.getElementById('chartData').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Siswa', 'Guru', 'Kelas'],
                datasets: [{
                    label: 'Jumlah Data',
                    data: [{{ $jumlahSiswa }}, {{ $jumlahGuru }}, {{ $jumlahKelas }}],
                    backgroundColor: [
                        'rgba(44, 95, 45, 0.7)',   // Hijau Utama (#2C5F2D)
                        'rgba(200, 150, 62, 0.7)', // Aksen Emas (#C8963E)
                        'rgba(138, 154, 91, 0.7)'  // Hijau Zaitun (Pelengkap)
                    ],
                    borderColor: [
                        '#2C5F2D',
                        '#C8963E',
                        '#8A9A5B'
                    ],
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#333333' }, // Teks Sumbu Y (Gelap)
                        grid: { color: '#e5e7eb' }  // Garis Sumbu Y (Abu-abu muda)
                    },
                    x: {
                        ticks: { color: '#333333' }, // Teks Sumbu X (Gelap)
                        grid: { display: false }     // Hilangkan Garis Sumbu X
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#333333' } // Teks Legenda (Gelap)
                    }
                }
            }
        });


        // ===== Logika Kalender & Modal (Diubah ke Tema Terang) =====
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. Ambil Elemen Modal ---
            const modal = document.getElementById('event-modal');
            const modalOverlay = document.getElementById('modal-overlay');
            const modalCloseBtn = document.getElementById('modal-close-btn');
            const modalTitle = document.getElementById('modal-title');
            const modalEventList = document.getElementById('modal-event-list');
            const modalNoEvents = document.getElementById('modal-no-events');
            const modalAddEventLink = document.getElementById('modal-add-event-link');

            let calendarEl = document.getElementById('calendar');
            let calendar; // Definisikan di luar agar bisa diakses

            // --- 2. Fungsi untuk Menutup Modal ---
            const closeModal = () => modal.classList.add('hidden');
            modalCloseBtn.onclick = closeModal;
            modalOverlay.onclick = closeModal;

            // --- 3. Fungsi untuk Menampilkan Detail (Fungsi Inti) ---
            const showDateDetails = (date) => {
                // Format tanggal untuk judul (e.g., "21 Oktober 2025")
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                modalTitle.textContent = `Kegiatan pada ${formattedDate}`;

                // Siapkan link "Tambah Kegiatan"
                const dateStr = date.toISOString().split('T')[0]; // "YYYY-MM-DD"
                modalAddEventLink.href = '{{ route('events.create') }}' + '?date=' + dateStr;

                // Kosongkan daftar event sebelumnya
                modalEventList.innerHTML = '';

                // Ambil semua event & filter yang sesuai dengan tanggal diklik
                const allEvents = calendar.getEvents();
                const eventsOnDay = allEvents.filter(event => {
                    return event.start.toDateString() === date.toDateString();
                });

                // Tampilkan event atau pesan "Tidak ada kegiatan"
                if (eventsOnDay.length > 0) {
                    modalNoEvents.classList.add('hidden');
                    modalEventList.classList.remove('hidden');

                    eventsOnDay.forEach(event => {
                        const li = document.createElement('li');
                        // Item list diubah ke Krem Kuning (#F0E6D2)
                        li.className = 'p-3 bg-[#F0E6D2] rounded-lg flex items-center space-x-3';

                        // Format waktu (e.g., "09:00 - 10:30")
                        let timeString = '';
                        if (event.start) {
                            timeString = event.start.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            });
                        }
                        if (event.end) {
                            timeString += ' - ' + event.end.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            });
                        }

                        // HTML item list diubah ke teks gelap dan dot Aksen Emas
                        li.innerHTML = `
                        <div class="flex-shrink-0 h-2 w-2 bg-[#C8963E] rounded-full"></div>
                        <div>
                            <p class="text-[#333333] font-medium">${event.title}</p>
                            <p class="text-sm text-gray-700">${timeString}</p>
                        </div>
                    `;
                        modalEventList.appendChild(li);
                    });

                } else {
                    modalNoEvents.classList.remove('hidden');
                    modalEventList.classList.add('hidden');
                }

                // Tampilkan modal
                modal.classList.remove('hidden');
            };


            // --- 4. Inisialisasi FullCalendar ---
            if (calendarEl) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    height: 'auto',
                    locale: 'id',

                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next today dayGridMonth,timeGridWeek,listWeek addEventButton'
                    },

                    customButtons: {
                        addEventButton: {
                            // Teks tombol diubah ke Bahasa Indonesia
                            text: '+ Tambah Kegiatan',
                            click: function() {
                                window.location.href = '{{ route('events.create') }}';
                            }
                        }
                    },

                    events: '{{ route('events.index') }}',

                    // Aksi saat mengklik tanggal
                    dateClick: function(info) {
                        showDateDetails(info.date);
                    },

                    // Aksi saat mengklik event
                    eventClick: function(info) {
                        info.jsEvent
                            .preventDefault(); // Mencegah browser redirect (jika event punya URL)
                        showDateDetails(info.event.start); // Tampilkan detail untuk hari itu
                    },

                    // Render kustom untuk event di dalam grid
                    eventContent: function(arg) {
                        let timeText = arg.timeText;
                        let title = arg.event.title;

                        // Teks diubah ke Teks Arang (#333333) agar kontras di atas Aksen Emas
                        let titleEl =
                            '<span style="color: #333333; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' +
                            title + '</span>';
                        let timeEl = timeText ? '<span style="color: #333333; opacity: 0.8; margin-left: 0.25rem;">' +
                            timeText + '</span>' : '';

                        return {
                            html: '<div style="display: flex; justify-content: space-between; font-size: 0.75rem; width: 100%; padding: 1px 4px;">' +
                                titleEl + timeEl + '</div>'
                        };
                    },

                    // Fungsi ini dipanggil setelah event di-render
                    eventDidMount: function(info) {
                        if (info.el) {
                            // Beri background Aksen Emas pada event
                            info.el.style.backgroundColor = '#C8963E';
                            info.el.style.borderColor = '#C8963E';
                            info.el.style.borderRadius = '4px';
                        }
                    }
                });

                calendar.render();
            }
        });
    </script>
@endpush