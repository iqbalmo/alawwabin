<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;

class HomeController extends Controller
{
    public function index()
    {
        // ambil jumlah masing2 tabel
        $jumlahSiswa = Siswa::count();
        $jumlahGuru  = Guru::count();
        $jumlahKelas = Kelas::count();

        // kirim ke view dengan NAMA VARIABEL persis seperti di view
        return view('home', compact('jumlahSiswa', 'jumlahGuru', 'jumlahKelas'));
    }
}
