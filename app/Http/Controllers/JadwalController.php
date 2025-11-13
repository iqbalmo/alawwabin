<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule
use Illuminate\Support\Collection;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // <-- Tambahkan (Request $request)
    {
        // Tentukan urutan hari yang benar
        $orderHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Ambil tipe tampilan dari URL, default-nya adalah 'hari'
        $viewType = $request->query('view', 'hari');

        if ($viewType == 'kelas') {
            // --- LOGIKA UNTUK TAMPILAN PER KELAS ---
            
            // 1. Ambil semua kelas, urutkan berdasarkan tingkat
            $semuaKelas = Kelas::orderBy('tingkat', 'asc')
                                ->orderBy('nama_kelas', 'asc')
                                ->get();
            
            // 2. Ambil semua jadwal
            $allJadwals = Jadwal::with('mapel', 'guru')
                                ->orderBy('jam_mulai', 'asc')
                                ->get();
            
            // 3. Kelompokkan jadwal berdasarkan kelas_id
            $groupedByKelas = $allJadwals->groupBy('kelas_id');

            // 4. Di dalam setiap grup kelas, kelompokkan lagi berdasarkan hari
            $jadwalsByKelas = $groupedByKelas->map(function ($jadwalsInClass) use ($orderHari) {
                
                // Kelompokkan berdasarkan hari (misal: Senin, Rabu, Selasa)
                $groupedByDay = $jadwalsInClass->groupBy('hari');
                
                // Sortir grup hari ini berdasarkan urutan $orderHari
                return $groupedByDay->sortBy(function ($_, $hari) use ($orderHari) {
                    return array_search($hari, $orderHari);
                });
            });

            // 5. Kirim data ke view
            return view('jadwal.index', [
                'viewType' => 'kelas',
                'semuaKelas' => $semuaKelas,
                'jadwalsByKelas' => $jadwalsByKelas
            ]);

        } else {
            // --- LOGIKA UNTUK TAMPILAN PER HARI (YANG SUDAH ADA) ---
            
            $jadwals = Jadwal::with('kelas', 'mapel', 'guru')
                            ->orderBy('jam_mulai', 'asc') 
                            ->get();

            $groupedJadwals = $jadwals->groupBy('hari');

            $orderedJadwals = collect([]);
            foreach ($orderHari as $hari) {
                if ($groupedJadwals->has($hari)) {
                    $orderedJadwals->put($hari, $groupedJadwals->get($hari));
                }
            }
            
            return view('jadwal.index', [
                'viewType' => 'hari',
                'orderedJadwals' => $orderedJadwals
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data untuk dropdown
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();
        $gurus = Guru::orderBy('nama')->get();
        
        return view('jadwal.create', compact('kelas', 'mapels', 'gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
            // Validasi agar tidak ada jadwal bentrok (opsional tapi bagus)
            'jam_mulai' => [
                'required',
                Rule::unique('jadwals')->where(function ($query) use ($request) {
                    return $query->where('hari', $request->hari)
                                 ->where('kelas_id', $request->kelas_id);
                }),
            ]
        ], [
            'jam_mulai.unique' => 'Jadwal bentrok! Kelas ini sudah ada pelajaran di hari dan jam yang sama.'
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();
        $gurus = Guru::orderBy('nama')->get();

        return view('jadwal.edit', compact('jadwal', 'kelas', 'mapels', 'gurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
            'jam_mulai' => [
                'required',
                Rule::unique('jadwals')->where(function ($query) use ($request) {
                    return $query->where('hari', $request->hari)
                                 ->where('kelas_id', $request->kelas_id);
                })->ignore($jadwal->id), // Abaikan ID jadwal saat ini
            ]
        ], [
            'jam_mulai.unique' => 'Jadwal bentrok! Kelas ini sudah ada pelajaran di hari dan jam yang sama.'
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}