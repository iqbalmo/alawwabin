<?php

namespace App\Http\Controllers;

use App\Models\GuruLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Http\Middleware\EnsureUserIsGuru; // <-- 1. DIHAPUS: Middleware lama tidak dipakai lagi

class GuruLogController extends Controller
{
    public function __construct()
    {
        // 2. DIUBAH: Middleware 'auth' sudah cukup.
        // Perlindungan 'permission:view gurulog' sudah ada di routes/web.php
        //
        // Menghapus middleware lama (EnsureUserIsGuru) akan memperbaiki error.
        $this->middleware('auth');
    }

    // Halaman form input rekap harian
    public function create()
    {
        $user = Auth::user();
        $guru = $user->guru;
        
        return view('gurulog.create', compact('guru'));
    }

    // Simpan rekap harian
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'kehadiran' => 'required|in:hadir,izin,sakit,alfa',
            'kegiatan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        GuruLog::updateOrCreate(
            [
                'user_id' => $user->id,
                'tanggal' => $validated['tanggal'],
            ],
            [
                'guru_id' => $user->guru_id,
                'jam_masuk' => $validated['jam_masuk'] ?? null,
                'jam_keluar' => $validated['jam_keluar'] ?? null,
                'kehadiran' => $validated['kehadiran'],
                'kegiatan' => $validated['kegiatan'] ?? null,
                'catatan' => $validated['catatan'] ?? null,
            ]
        );

        return redirect()->route('gurulog.index')->with('success', 'Rekap harian berhasil disimpan!');
    }

    // Halaman riwayat rekap harian
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data log terakhir (untuk "Aktivitas Terakhir")
        $queryLogs = GuruLog::query();
        if (!$user->hasRole('admin')) {
            $queryLogs->where('user_id', $user->id);
        }
        $guruLogs = $queryLogs->with('guru')
                         ->orderBy('tanggal', 'desc')
                         ->paginate(5); // Kita batasi 5 log terakhir di dashboard

        // 2. Ambil data Jadwal Hari Ini untuk guru tersebut
        $hariIni = now()->translatedFormat('l'); // 'l' akan menghasilkan 'Senin', 'Selasa', dst.
        
        $jadwalHariIni = \App\Models\Jadwal::where('guru_id', $user->guru_id)
            ->where('hari', $hariIni)
            ->with(['kelas', 'mapel'])
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // 3. Ambil data Event untuk Kalender (sama seperti di HomeController)
        $events = \App\Models\Event::all()->map(function ($event) {
            return [
                'id' => $event->id, // Tambahkan ID untuk referensi
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'backgroundColor' => $event->color ?? '#3788d8',
                'borderColor' => $event->color ?? '#3788d8',
                'extendedProps' => [
                    'start_time' => $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : null,
                    'end_time' => $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : null,
                ]
            ];
        });
        $eventsJson = json_encode($events);

        // 4. Ambil Event Hari Ini
        $todayEvents = \App\Models\Event::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderBy('start_time')
            ->get();

        // Kirim semua data ke view
        return view('gurulog.index', compact('guruLogs', 'jadwalHariIni', 'eventsJson', 'todayEvents'));
    }

    // Edit rekap harian
    public function edit($id)
    {
        $guruLog = GuruLog::findOrFail($id);

        // 4. DIPERBAIKI: Cek kepemilikan, TAPI izinkan Admin
        if ($guruLog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Anda tidak diizinkan mengedit log ini.');
        }

        $user = Auth::user();
        $guru = $user->guru;

        return view('gurulog.edit', compact('guruLog', 'guru'));
    }

    // Update rekap harian
    public function update(Request $request, $id)
    {
        $guruLog = GuruLog::findOrFail($id);

        // 4. DIPERBAIKI: Cek kepemilikan, TAPI izinkan Admin
        if ($guruLog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Anda tidak diizinkan memperbarui log ini.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'kehadiran' => 'required|in:hadir,izin,sakit,alfa',
            'kegiatan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $guruLog->update($validated);

        return redirect()->route('gurulog.index')->with('success', 'Rekap harian berhasil diperbarui!');
    }

    // Hapus rekap harian
    public function destroy($id)
    {
        $guruLog = GuruLog::findOrFail($id);

        // 4. DIPERBAIKI: Cek kepemilikan, TAPI izinkan Admin
        if ($guruLog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Anda tidak diizinkan menghapus log ini.');
        }

        $guruLog->delete();

        return redirect()->route('gurulog.index')->with('success', 'Rekap harian berhasil dihapus!');
    }
}