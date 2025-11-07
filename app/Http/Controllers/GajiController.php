<?php

// app/Http/Controllers/GajiController.php
namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request, default ke bulan ini
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        // Ambil semua guru
        $gurus = Guru::orderBy('nama')->get();

        // Ambil data gaji yang sudah dibayar untuk bulan/tahun ini
        $gajisDibayar = Gaji::where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->where('status', 'Sudah Dibayar')
                            ->pluck('tanggal_bayar', 'guru_id'); // [guru_id => tanggal_bayar]

        // Kirim data ke view
        return view('gaji.index', compact('gurus', 'gajisDibayar', 'bulan', 'tahun'));
    }

    public function bayar(Request $request, Guru $guru)
    {
        // Ambil bulan dan tahun dari request (pastikan ada validasi!)
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Validasi sederhana (bisa diperlengkap)
        if (!$bulan || !$tahun) {
            return back()->with('error', 'Bulan dan Tahun diperlukan.');
        }

        // Cari atau buat entri gaji
        Gaji::updateOrCreate(
            [
                'guru_id' => $guru->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ],
            [
                'jumlah_dibayar' => $guru->gaji_pokok, // Ambil dari gaji pokok guru
                'tanggal_bayar' => Carbon::now(),
                'status' => 'Sudah Dibayar',
            ]
        );

        return back()->with('success', 'Gaji untuk ' . $guru->nama . ' berhasil ditandai lunas.');
    }

    public function update(Request $request, Guru $guru)
    {
        // 👇 PASTIKAN ATURAN VALIDASI INI LENGKAP 👇
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip,' . $guru->id,
            'mapel_id' => 'nullable|exists:mapels,id', // 'nullable' agar tidak wajib diisi
            'alamat' => 'required|string',
            'telepon' => 'nullable|string',
            'gaji_pokok' => 'required|numeric|min:0', // <-- PASTIKAN BARIS INI ADA
        ]);

        // Kode ini akan menyimpan semua data yang sudah divalidasi
        $guru->update($request->all());

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }
}
