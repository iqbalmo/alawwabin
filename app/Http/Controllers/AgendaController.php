<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru; // <-- 1. IMPORT MODEL GURU
class AgendaController extends Controller
{
    public function __construct()
    {
        // Lindungi semua method dengan middleware
        $this->middleware('auth');
        $this->middleware('permission:view agenda', ['only' => ['index', 'show']]);
        $this->middleware('permission:manage agenda', ['except' => ['index', 'show', 'getSiswaByJadwal']]);
    }

    /**
     * Menampilkan dashboard "Agenda Mengajar".
     * Ini adalah halaman utama guru untuk melihat progres.
     */
    public function index(Request $request)
    {
        // ==================================================================
        // PERBAIKAN: Hapus semua logika dari sini.
        // Logika (query, filter, grouping) sudah dipindah 
        // ke app/Livewire/AgendaDashboard.php
        // ==================================================================
        
        return view('agenda.index');
    }

    /**
     * Menampilkan form untuk mengisi agenda (absensi & materi).
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        
        // Hanya tampilkan jadwal milik guru ybs (kecuali admin)
        $jadwalQuery = Jadwal::with('kelas', 'mapel');
        if (!$user->hasRole('admin')) {
            $jadwalQuery->where('guru_id', $user->guru_id);
        }
        $jadwals = $jadwalQuery->get();

        $selectedJadwalId = $request->query('jadwal_id');
        $siswas = collect();

        // Jika 'jadwal_id' dikirim dari halaman index,
        // langsung load daftar siswa
        if ($selectedJadwalId) {
            $jadwal = Jadwal::find($selectedJadwalId);
            // Cek otorisasi (pastikan guru ini mengajar jadwal tsb, atau dia admin)
            if ($jadwal && ($user->hasRole('admin') || $jadwal->guru_id == $user->guru_id)) {
                $siswas = Siswa::where('kelas_id', $jadwal->kelas_id)->orderBy('no_absen', 'asc')->get();
            } else {
                $selectedJadwalId = null; // Batalkan jika tidak berhak
            }
        }

        return view('agenda.create', compact('jadwals', 'selectedJadwalId', 'siswas'));
    }

    /**
     * Menyimpan agenda baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal' => 'required|date',
            'materi_diajarkan' => 'nullable|string',
            'absensi_siswa' => 'required|array',
            'absensi_siswa.*' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        // Pastikan guru ini berhak mengisi jadwal ini (jika bukan admin)
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            $jadwal = Jadwal::find($validated['jadwal_id']);
            if ($jadwal->guru_id !== $user->guru_id) {
                abort(403, 'Anda tidak diizinkan mengisi agenda untuk jadwal ini.');
            }
        }

        $agenda = Agenda::create([
            'user_id' => $user->id,
            'jadwal_id' => $validated['jadwal_id'],
            'tanggal' => $validated['tanggal'],
            'materi_diajarkan' => $validated['materi_diajarkan'],
            'absensi_siswa' => $validated['absensi_siswa'], // Disimpan sebagai JSON
        ]);

        // Create notification for all admins
        $jadwal = Jadwal::with('kelas', 'mapel', 'guru')->find($validated['jadwal_id']);
        $guruName = $jadwal->guru->nama ?? 'Guru';
        $tingkat = $jadwal->kelas->tingkat ?? '';
        $namaKelas = $jadwal->kelas->nama_kelas ?? 'Kelas';
        $kelasLengkap = $tingkat ? "Kelas {$tingkat} - {$namaKelas}" : $namaKelas;
        $mapelName = $jadwal->mapel->nama_mapel ?? 'Mata Pelajaran';

        $admins = \App\Models\User::role('admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'type' => 'agenda_created',
                'title' => 'Agenda Baru Ditambahkan',
                'message' => "{$guruName} mengisi agenda untuk {$kelasLengkap} - {$mapelName}",
                'data' => [
                    'agenda_id' => $agenda->id,
                    'jadwal_id' => $jadwal->id,
                    'guru_name' => $guruName,
                    'kelas_name' => $kelasLengkap,
                    'mapel_name' => $mapelName,
                ],
            ]);
        }

        return redirect()->route('agenda.index')->with('success', 'Agenda mengajar berhasil disimpan.');
    }

    /**
     * Menampilkan riwayat agenda untuk SATU jadwal.
     */
    public function show($jadwal_id)
    {
        $user = Auth::user();
        $jadwal = Jadwal::with('kelas', 'mapel', 'guru')->findOrFail($jadwal_id);

        // Otorisasi: Pastikan guru ini boleh melihat riwayat jadwal ini (jika bukan admin)
        if (!$user->hasRole('admin') && $jadwal->guru_id !== $user->guru_id) {
            abort(403, 'Anda tidak diizinkan melihat riwayat agenda ini.');
        }

        $agendas = Agenda::where('jadwal_id', $jadwal->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('agenda.show', compact('jadwal', 'agendas'));
    }

    /**
     * Menampilkan form untuk mengedit agenda.
     */
    public function edit(Agenda $agenda)
    {
        // Otorisasi (hanya pembuatnya atau admin yang bisa edit)
        $user = Auth::user();
        if (!$user->hasRole('admin') && $agenda->user_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengedit agenda ini.');
        }
        
        $agenda->load('jadwal.kelas');
        $siswas = Siswa::where('kelas_id', $agenda->jadwal->kelas_id)->orderBy('no_absen', 'asc')->get();

        return view('agenda.edit', compact('agenda', 'siswas'));
    }

    /**
     * Update agenda di database.
     */
    public function update(Request $request, Agenda $agenda)
    {
        // Otorisasi (hanya pembuatnya atau admin yang bisa edit)
        $user = Auth::user();
        if (!$user->hasRole('admin') && $agenda->user_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengedit agenda ini.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'materi_diajarkan' => 'nullable|string',
            'absensi_siswa' => 'required|array',
            'absensi_siswa.*' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        $agenda->update($validated);

        return redirect()->route('agenda.show', $agenda->jadwal_id)->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Hapus agenda.
     */
    public function destroy(Agenda $agenda)
    {
        // Otorisasi (hanya pembuatnya atau admin yang bisa hapus)
        $user = Auth::user();
        if (!$user->hasRole('admin') && $agenda->user_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan menghapus agenda ini.');
        }
        
        $jadwal_id = $agenda->jadwal_id;
        $agenda->delete();

        return redirect()->route('agenda.show', $jadwal_id)->with('success', 'Agenda berhasil dihapus.');
    }

    /**
     * API untuk mengambil siswa berdasarkan jadwal (AJAX).
     */
    public function getSiswaByJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        // Otorisasi (pastikan guru ini boleh akses, atau dia admin)
        $user = Auth::user();
        if (!$user->hasRole('admin') && $jadwal->guru_id !== $user->guru_id) {
             return response()->json(['error' => 'Unauthorized'], 403);
        }

        $siswas = Siswa::where('kelas_id', $jadwal->kelas_id)->orderBy('no_absen', 'asc')->get();
        return response()->json($siswas);
    }
}