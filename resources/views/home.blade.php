@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center fw-bold">Dashboard</h1>

    {{-- Statistik --}}
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <h5 class="card-title text-secondary fw-bold">Jumlah Siswa</h5>
                    <h3 class="text-primary">{{ $jumlahSiswa }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <h5 class="card-title text-secondary fw-bold">Jumlah Guru</h5>
                    <h3 class="text-success">{{ $jumlahGuru }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <h5 class="card-title text-secondary fw-bold">Jumlah Kelas</h5>
                    <h3 class="text-warning">{{ $jumlahKelas }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Chart.js --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body">
            <h5 class="card-title fw-bold text-center mb-3">📊 Grafik Data Sekolah</h5>
            <canvas id="chartData" height="120"></canvas>
        </div>
    </div>

    {{-- Kalender --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="fw-bold m-0">📅 Kalender Kegiatan</h5>
            <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">+ Tambah Event</a>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

    {{-- Daftar Event --}}
    @if(isset($events) && count($events) > 0)
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white">
                <h5 class="fw-bold m-0">📌 Daftar Kegiatan</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($events as $event)
                        <li class="list-group-item">
                            <strong>{{ $event->title }}</strong><br>
                            📅 {{ \Carbon\Carbon::parse($event->start)->format('d M Y') }}
                            @if($event->end)
                                - {{ \Carbon\Carbon::parse($event->end)->format('d M Y') }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            Belum ada kegiatan yang ditambahkan.
        </div>
    @endif
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- FullCalendar --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

{{-- Custom Style --}}
<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
    }
    .fc .fc-toolbar-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #495057;
    }
    .fc .fc-button-primary {
        background: #0d6efd;
        border: #0d6efd;
        border-radius: 6px;
    }
    .fc .fc-button-primary:hover {
        background: #0b5ed7;
        border: #0a58ca;
    }
    .fc .fc-daygrid-day:hover {
        background: #f8f9fa;
        cursor: pointer;
    }
</style>

<script>
    // ===== Grafik Chart.js =====
    const ctx = document.getElementById('chartData').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Siswa', 'Guru', 'Kelas'],
            datasets: [{
                label: 'Jumlah Data',
                data: [{{ $jumlahSiswa }}, {{ $jumlahGuru }}, {{ $jumlahKelas }}],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // ===== Kalender FullCalendar =====
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            height: 550,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            // Ambil data event dari backend
            events: '/events',

            // Ketika klik tanggal
            dateClick: function (info) {
                alert('Tanggal dipilih: ' + info.dateStr + '\nGunakan tombol "+ Tambah Event" untuk menambahkan kegiatan.');
            },

            // Tambahkan tooltip saat hover event
            eventDidMount: function (info) {
                if (info.event.title) {
                    info.el.setAttribute('title', info.event.title);
                }
            }
        });

        calendar.render();
    });
</script>
@endsection
