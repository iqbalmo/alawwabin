<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {

        $kelas = Kelas::with('wali') 
                        ->orderBy('tingkat', 'asc')
                        ->orderBy('nama_kelas', 'asc')
                        ->paginate(15);
        // -------------------------
        
        // Paginasi akan tetap berfungsi
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $gurus = Guru::orderBy('nama')->get(); // Ambil data guru untuk dropdown
        return view('kelas.create', compact('gurus'));
    }

    /**
     * Menyimpan data kelas baru ke database.
     */
    public function store(Request $request)
    {
        // 🚨 1. VALIDASI DIPERBARUI SESUAI FORM BARU
        $validated = $request->validate([
            'tingkat' => 'required|in:7,8,9', // Validasi untuk dropdown Tingkat
            'nama_kelas' => 'required|string|max:100', // Validasi untuk nama jurusan/kelas
            'wali_kelas' => 'nullable|exists:gurus,id', // Validasi untuk Wali Kelas (opsional)
        ]);

        // 🚨 2. PENYIMPANAN DATA DIPERBARUI
        // Langsung menyimpan data yang sudah divalidasi.
        // Ini mengasumsikan model Kelas Anda memiliki 'tingkat', 'nama_kelas', dan 'wali_kelas' di $fillable.
        Kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kelas.
     * Menggunakan Route Model Binding yang benar ($kelas).
     */
    public function edit(Kelas $kelas)
    {
        $gurus = Guru::orderBy('nama')->get();
        return view('kelas.edit', compact('kelas', 'gurus'));
    }

    /**
     * Mengupdate data kelas yang ada.
     */
    public function update(Request $request, Kelas $kelas)
    {
        // 🚨 VALIDASI UPDATE DIPERBARUI
        $validated = $request->validate([
            'tingkat' => 'required|in:7,8,9',
            'nama_kelas' => 'required|string|max:100',
            'wali_kelas' => 'nullable|exists:gurus,id',
        ]);

        $kelas->update($validated);
        
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data kelas.
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}

