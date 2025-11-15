<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use App\Models\Siswa; // <-- Pastikan Siswa di-import
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EkskulController extends Controller
{
    public function index()
    {
        $ekskuls = Ekstrakurikuler::with('pembina')
                     ->orderBy('nama_ekskul', 'asc')
                     ->get();
        return view('ekskul.index', compact('ekskuls'));
    }

    public function create()
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();
        return view('ekskul.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ekskul' => 'required|string|max:255|unique:ekstrakurikulers,nama_ekskul',
            'guru_id' => 'nullable|exists:gurus,id',
            'deskripsi' => 'nullable|string',
        ]);

        Ekstrakurikuler::create($validated);

        return redirect()->route('ekskul.index')->with('success', 'Ekstrakurikuler baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman manajemen anggota untuk satu ekskul.
     * --- METHOD INI DIPERBARUI ---
     */
    public function show(Ekstrakurikuler $ekskul)
    {
        // 1. Ambil data ekskul ini, beserta relasi pembina dan siswanya (diurutkan)
        $ekskul->load(['pembina', 'siswas' => function ($query) {
            $query->orderBy('nama', 'asc');
        }]);

        // 2. Ambil ID siswa yang SUDAH terdaftar di ekskul ini
        $siswaTerdaftarIds = $ekskul->siswas->pluck('id');

        // 3. Ambil daftar siswa yang BELUM terdaftar DAN BUKAN 'Lulus'
        $siswaTersedia = Siswa::where(function ($query) {
                                // INI LOGIKA BARU: Ambil siswa yang statusnya BUKAN 'Lulus' ATAU yang statusnya 'NULL'
                                $query->where('status_mukim', '!=', 'Lulus')
                                      ->orWhereNull('status_mukim');
                            })
                            ->whereNotIn('id', $siswaTerdaftarIds) // Filter yang sudah terdaftar
                            ->orderBy('nama', 'asc')
                            ->get();

        return view('ekskul.show', compact('ekskul', 'siswaTersedia'));
    }
    // ------------------------------------

    public function edit(Ekstrakurikuler $ekskul)
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();
        return view('ekskul.edit', compact('ekskul', 'gurus'));
    }

    public function update(Request $request, Ekstrakurikuler $ekskul)
    {
        $validated = $request->validate([
            'nama_ekskul' => [
                'required', 'string', 'max:255',
                Rule::unique('ekstrakurikulers')->ignore($ekskul->id),
            ],
            'guru_id' => 'nullable|exists:gurus,id',
            'deskripsi' => 'nullable|string',
        ]);

        $ekskul->update($validated);

        return redirect()->route('ekskul.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekskul)
    {
        $ekskul->delete();
        return redirect()->route('ekskul.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    /**
     * Menambahkan siswa ke ekskul.
     */
    public function attachSiswa(Request $request, Ekstrakurikuler $ekskul)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id'
        ]);

        if ($ekskul->siswas()->where('siswa_id', $request->siswa_id)->exists()) {
            return redirect()->route('ekskul.show', $ekskul->id)->with('error', 'Siswa ini sudah terdaftar di ekskul ini.');
        }

        $ekskul->siswas()->attach($request->siswa_id);

        return redirect()->route('ekskul.show', $ekskul->id)->with('success', 'Siswa berhasil ditambahkan ke ekskul.');
    }

    /**
     * Menghapus siswa dari ekskul.
     */
    public function detachSiswa(Ekstrakurikuler $ekskul, Siswa $siswa)
    {
        $ekskul->siswas()->detach($siswa->id);

        return redirect()->route('ekskul.show', $ekskul->id)->with('success', 'Siswa berhasil dikeluarkan dari ekskul.');
    }
}