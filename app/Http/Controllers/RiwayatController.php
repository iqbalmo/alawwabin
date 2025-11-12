<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekap;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil semua rekap, eager load relasi jadwal + guru + kelas + mapel
        $rekaps = Rekap::with(['jadwal.guru', 'jadwal.kelas', 'jadwal.mapel'])
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('riwayat.index', compact('rekaps'));
    }

     public function show($id)
    {
        // Ambil rekap berdasarkan id
        $rekap = Rekap::with(['jadwal.guru', 'jadwal.kelas', 'jadwal.mapel', 'siswa'])
            ->findOrFail($id);

        // Ambil semua siswa yang ikut rekap di jadwal & tanggal yang sama
        $rekaps = Rekap::with('siswa')
            ->where('jadwal_id', $rekap->jadwal_id)
            ->where('tanggal', $rekap->tanggal)
            ->get();

        return view('riwayat.show', compact('rekap', 'rekaps'));
    }
}
