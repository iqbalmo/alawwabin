<?php

namespace App\Http\Controllers;

use App\Models\GuruLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureUserIsGuru;

class GuruLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // pakai class middleware langsung (tidak perlu register di Kernel)
        $this->middleware(EnsureUserIsGuru::class);
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
        $guruLogs = GuruLog::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('gurulog.index', compact('guruLogs'));
    }

    // Edit rekap harian
    public function edit($id)
    {
        $guruLog = GuruLog::findOrFail($id);

        // cek kepemilikan manual
        if ($guruLog->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        $guru = $user->guru;

        return view('gurulog.edit', compact('guruLog', 'guru'));
    }

    // Update rekap harian
    public function update(Request $request, $id)
    {
        $guruLog = GuruLog::findOrFail($id);

        if ($guruLog->user_id !== Auth::id()) {
            abort(403);
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

        if ($guruLog->user_id !== Auth::id()) {
            abort(403);
        }

        $guruLog->delete();

        return redirect()->route('gurulog.index')->with('success', 'Rekap harian berhasil dihapus!');
    }
}