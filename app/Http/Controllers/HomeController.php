<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Event; // 🚨 1. Tambahkan use statement untuk model Event

class HomeController extends Controller
{
    public function index()
    {
        // ambil jumlah masing2 tabel
        $jumlahSiswa = Siswa::where('status_mukim', '!=', 'Lulus')
                        ->orWhereNull('status_mukim')
                        ->count();
        $jumlahGuru  = Guru::count();
        $jumlahKelas = Kelas::count();

        // 🚨 2. Ambil data event dari database
        // Diurutkan berdasarkan tanggal mulai yang paling dekat
        $events = Event::orderBy('start_date', 'asc')->get(); 

        // 🚨 3. Kirim semua variabel, TERMASUK $events, ke view
        return view('home', compact('jumlahSiswa', 'jumlahGuru', 'jumlahKelas', 'events'));
    }
}
