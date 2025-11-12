@extends('layouts.app')

@section('content')
<div class="space-y-8 p-6 bg-[#F9F9F9] min-h-screen">

    <!-- 1. Statistik -->
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


    <!-- 3. Grafik -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-lg">
        <div class="p-5">
            <h3 class="text-lg font-medium text-[#333333] text-center mb-4">📊 Grafik Data Sekolah</h3>
            <canvas id="chartData"></canvas>
        </div>
    </div>

    <!-- 4. Kalender -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-5">
        <h3 class="text-lg font-medium text-[#333333] text-center mb-4">📅 Kalender Kegiatan Guru</h3>
        <div id="calendar"></div>
    </div>

</div>

<!-- Script CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<!-- Chart -->
<script>
const ctx = document.getElementById('chartData').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Siswa', 'Guru', 'Kelas'],
        datasets: [{
            label: 'Jumlah Data',
            data: [{{ $jumlahSiswa ?? 0 }}, {{ $jumlahGuru ?? 0 }}, {{ $jumlahKelas ?? 0 }}],
            backgroundColor: ['#2C5F2D', '#C8963E', '#8A9A5B'],
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true, grid: { color: '#e5e7eb' }, ticks: { color: '#333333' } },
            x: { grid: { display: false }, ticks: { color: '#333333' } }
        }
    }
});
</script>

<!-- Calendar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '/events', // route ke controller yang return JSON event
    });
    calendar.render();
});
</script>
@endsection
