<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use App\Models\Siswa;
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
     * --- METHOD INI DISIMPLIFIKASI ---
     * Menampilkan 'shell' untuk komponen Livewire.
     */
    public function show(Ekstrakurikuler $ekskul)
    {
        // Controller sekarang hanya bertugas mengirim data ekskul
        // ke view 'shell'
        return view('ekskul.show', compact('ekskul'));
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

    // --- METHOD attachSiswa DIHAPUS DARI SINI ---

    // --- METHOD detachSiswa DIHAPUS DARI SINI ---
}