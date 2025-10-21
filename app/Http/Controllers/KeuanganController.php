<?php

// app/Http/Controllers/KeuanganController.php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Menampilkan daftar transaksi keuangan.
     */
    public function index()
    {
        // Ambil data terbaru dulu
        $transaksis = Keuangan::latest('tanggal_transaksi')->latest('created_at')->paginate(15); // Paginasi 15 data per halaman
        return view('keuangan.index', compact('transaksis'));
    }

    /**
     * Menampilkan form tambah transaksi.
     */
    public function create()
    {
        // Mungkin perlu data Guru jika ingin link Gaji
        // $gurus = \App\Models\Guru::orderBy('nama')->get();
        return view('keuangan.create' /*, compact('gurus')*/);
    }

    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        // 👇 UBAH VALIDASI KATEGORI DI SINI 👇
        $request->validate([
            // Izinkan semua kategori operasional yang ada di dropdown
            'kategori' => [
                'required',
                \Illuminate\Validation\Rule::in([
                    'ATK', 'Utilitas', 'Transportasi', 'Konsumsi',
                    'Perawatan Gedung', 'Kegiatan Siswa', 'Peralatan',
                    'Administrasi', 'Lain-lain'
                ])
            ],
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_transaksi' => 'required|date',
        ]);

        Keuangan::create($request->all());

        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil ditambahkan.');
    }

    // Nanti bisa tambahkan edit, update, destroy di sini
    // public function edit(Keuangan $keuangan) { ... }
    // public function update(Request $request, Keuangan $keuangan) { ... }
    // public function destroy(Keuangan $keuangan) { ... }
}