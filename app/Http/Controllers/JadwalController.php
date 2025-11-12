<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Menampilkan halaman daftar jadwal.
     */
    public function index()
    {
        // Ambil semua jadwal, urutkan berdasarkan hari dan jam
        // 'with' digunakan untuk eager loading (optimasi query)
        $jadwals = Jadwal::with('guru', 'mapel', 'kelas')
                    ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                    ->orderBy('jam_mulai')
                    ->get();
                    
        return view('jadwal.index', compact('jadwals'));
    }

    /**
     * Menampilkan halaman form tambah jadwal.
     */
    public function create()
    {
        // Ambil data untuk mengisi <select> dropdown di form
        $gurus = Guru::orderBy('nama')->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        
        return view('jadwal.create', compact('gurus', 'mapels', 'kelas'));
    }

    /**
     * Menyimpan jadwal baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Simpan data
        Jadwal::create($request->all());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id); // ambil data jadwal berdasarkan ID
        $mapels = Mapel::all(); // ambil semua mapel untuk dropdown
        $gurus  = Guru::all();  // ambil semua guru untuk dropdown
        $kelas  = Kelas::all(); // ambil semua kelas untuk dropdown

        return view('jadwal.edit', compact('jadwal', 'mapels', 'gurus', 'kelas'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'mapel_id' => 'required',
            'guru_id' => 'required',
            'kelas_id' => 'required',
        ]);

            $jadwal = Jadwal::findOrFail($id);
            $jadwal->update($request->all());

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate!');
    }

}