<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekap;
use App\Models\Jadwal;
use App\Models\Siswa;

class RekapController extends Controller
{
    /**
     * 1️⃣ Tampilkan semua rekap
     */
    public function index()
    {
        // Eager load relasi: jadwal -> guru, kelas, mapel + siswa
        $rekaps = Rekap::with(['jadwal.guru', 'jadwal.kelas', 'jadwal.mapel', 'siswa'])->get();
        return view('rekap.index', compact('rekaps'));
    }

    /**
     * 2️⃣ Tampilkan form tambah rekap
     */
    public function create()
    {
        $jadwals = Jadwal::with(['guru','mapel','kelas'])->get();
        return view('rekap.create', compact('jadwals'));
    }

    /**
     * 3️⃣ Simpan rekap ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal'   => 'required|date',
            'status'    => 'nullable|array', // bisa null kalau belum pilih siswa
        ]);

        $jadwal = Jadwal::with(['guru','mapel','kelas'])->findOrFail($request->jadwal_id);

        if ($request->has('status')) {
            foreach ($request->status as $siswa_id => $status) {
                Rekap::create([
                    'jadwal_id'  => $jadwal->id,
                    'siswa_id'   => $siswa_id,
                    'status'     => $status,
                    'tanggal'    => $request->tanggal,
                    'nama_guru'  => $jadwal->guru->nama ?? null,
                    'mapel'      => $jadwal->mapel->nama_mapel ?? null,
                ]);
            }
        }

        return redirect()->route('rekap.index')->with('success', 'Rekap berhasil disimpan!');
    }

    /**
     * 4️⃣ AJAX: ambil siswa berdasarkan jadwal
     */
    public function getSiswaByJadwal($jadwal_id)
    {
        $jadwal = Jadwal::with('kelas.siswa')->findOrFail($jadwal_id);
        $siswas = $jadwal->kelas->siswa;
        return response()->json($siswas);
    }

    /**
     * 5️⃣ Form edit rekap
     */
    public function edit($id)
    {
        $rekap = Rekap::findOrFail($id);
        $jadwals = Jadwal::with(['guru','mapel','kelas'])->get();
        return view('rekap.edit', compact('rekap','jadwals'));
    }

    /**
     * 6️⃣ Update rekap
     */
    public function update(Request $request, $id)
    {
        $rekap = Rekap::findOrFail($id);

        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal'   => 'required|date',
            'status'    => 'required|string',
        ]);

        $jadwal = Jadwal::with(['guru','mapel','kelas'])->findOrFail($request->jadwal_id);

        $rekap->update([
            'jadwal_id'  => $jadwal->id,
            'siswa_id'   => $rekap->siswa_id,
            'status'     => $request->status,
            'tanggal'    => $request->tanggal,
            'nama_guru'  => $jadwal->guru->nama ?? null,
            'mapel'      => $jadwal->mapel->nama_mapel ?? null,
            'catatan'   => $request->catatan[$siswa_id] ?? null,
        ]);

        return redirect()->route('rekap.index')->with('success', 'Rekap berhasil diperbarui!');
    }

    /**
     * 7️⃣ Hapus rekap
     */
    public function destroy($id)
    {
        $rekap = Rekap::findOrFail($id);
        $rekap->delete();

        return redirect()->route('rekap.index')->with('success', 'Rekap berhasil dihapus!');
    }
   public function show($id)
{
    // Ambil rekap untuk id tertentu
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
