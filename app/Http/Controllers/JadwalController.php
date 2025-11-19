<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Rule
use Illuminate\Validation\Rule; // <-- 1. PASTIKAN Auth DI-IMPORT

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Tentukan urutan hari yang benar
        $orderHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Ambil tipe tampilan dari URL, default-nya adalah 'hari'
        $viewType = $request->query('view', 'hari');

        // ==================================================================
        // PERBAIKAN: Tambahkan filter RBAC di sini
        // ==================================================================

        // 1. Ambil user yang sedang login
        $user = Auth::user();

        // 2. Buat query dasar untuk Jadwal
        $jadwalQuery = Jadwal::query();

        // 3. Terapkan filter RBAC
        // Jika user BUKAN admin, filter jadwal hanya untuk guru_id mereka
        if (! $user->hasRole('admin')) {
            $jadwalQuery->where('guru_id', $user->guru_id);
        }

        // ==================================================================

        if ($viewType == 'kelas') {
            // --- LOGIKA UNTUK TAMPILAN PER KELAS ---

            // 1. Ambil semua kelas (ini tidak perlu difilter, semua boleh lihat daftar kelas)
            $semuaKelas = Kelas::orderBy('tingkat', 'asc')
                ->orderBy('nama_kelas', 'asc')
                ->get();

            // 2. Ambil semua jadwal (GUNAKAN QUERY YANG SUDAH DIFILTER)
            $allJadwals = $jadwalQuery->with('mapel', 'guru') // <-- 4. GUNAKAN $jadwalQuery
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
                'jadwalsByKelas' => $jadwalsByKelas,
            ]);

        } else {
            // --- LOGIKA UNTUK TAMPILAN PER HARI (DEFAULT) ---

            // Ambil jadwal (GUNAKAN QUERY YANG SUDAH DIFILTER)
            $jadwals = $jadwalQuery->with('kelas', 'mapel', 'guru') // <-- 4. GUNAKAN $jadwalQuery
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
                'orderedJadwals' => $orderedJadwals,
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
            'jam_selesai' => 'required|after:jam_mulai', // Pastikan selesai setelah mulai
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        // 1. Cek Bentrok Ruangan/Kelas
        $bentrokKelas = Jadwal::where('hari', $request->hari)
            ->where('kelas_id', $request->kelas_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<', $request->jam_mulai)
                            ->where('jam_selesai', '>', $request->jam_selesai);
                    });
            })->exists();

        if ($bentrokKelas) {
            return back()->withErrors(['jam_mulai' => 'Jadwal bentrok! Kelas ini sedang digunakan pada jam tersebut.'])->withInput();
        }

        // 2. (Opsional) Cek Bentrok Guru - Agar guru tidak mengajar di 2 kelas berbeda bersamaan
        $bentrokGuru = Jadwal::where('hari', $request->hari)
            ->where('guru_id', $request->guru_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<', $request->jam_mulai)
                            ->where('jam_selesai', '>', $request->jam_selesai);
                    });
            })->exists();

        if ($bentrokGuru) {
            return back()->withErrors(['guru_id' => 'Guru ini sedang mengajar di kelas lain pada jam tersebut.'])->withInput();
        }

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
            'jam_selesai' => 'required|after:jam_mulai',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        // Cek Bentrok Kelas (kecuali jadwal ini sendiri)
        $bentrok = Jadwal::where('id', '!=', $jadwal->id) // Abaikan jadwal yang sedang diedit
            ->where('hari', $request->hari)
            ->where('kelas_id', $request->kelas_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<', $request->jam_mulai)
                            ->where('jam_selesai', '>', $request->jam_selesai);
                    });
            })->exists();

        if ($bentrok) {
            return back()->withErrors(['jam_mulai' => 'Jadwal bentrok dengan jam lain di kelas ini.'])->withInput();
        }

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
