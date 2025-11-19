<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        // Kita hapus semua logika query di sini karena sudah ditangani oleh Livewire
        return view('siswa.index');
    }

    public function create()
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('siswa.create', compact('kelas'));
    }

    public function store(StoreSiswaRequest $request)
    {
        // Validasi sudah ditangani oleh StoreSiswaRequest

        Siswa::create($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Tampilkan halaman detail untuk satu siswa.
     */
    public function show(Siswa $siswa)
    {
        // Muat relasi 'kelas' DAN 'ekstrakurikulers'
        $siswa->load('kelas', 'ekstrakurikulers.pembina');

        return view('siswa.show', compact('siswa'));
    }

    public function archive()
    {
        // 1. Ambil semua siswa yang statusnya 'Lulus'
        $arsipSiswa = Siswa::where('status_mukim', 'Lulus')
            ->orderBy('updated_at', 'desc') // Urutan 1: Tahun Lulus (Terbaru dulu)
            ->orderBy('nama', 'asc')       // Urutan 2: Nama Siswa (A-Z)
            ->get();

        // 2. Kelompokkan siswa berdasarkan TAHUN kelulusan mereka
        $arsipPerTahun = $arsipSiswa->groupBy(function ($siswa) {
            return $siswa->updated_at->format('Y'); // Group by year (e.g., "2025", "2024")
        });

        // 3. Kirim data yang sudah terkelompok ke view baru
        return view('siswa.arsip', compact('arsipPerTahun'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        // Validasi sudah ditangani oleh UpdateSiswaRequest

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function showImportForm()
    {
        return view('siswa.import');
    }
}
