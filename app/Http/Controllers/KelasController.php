<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
         $gurus = Guru::all(); // Ambil semua guru
    return view('kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'nama_kelas' => 'required|string|max:255',
        'wali_kelas' => 'required|integer', // hanya 1 guru dipilih
        ]);

        \App\Models\Kelas::create([
        'nama_kelas' => $request->nama_kelas,
        'wali_kelas' => $request->wali_kelas, // simpan guru_id
        ]);

    return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        return view('kelas.edit', ['kelas' => $kela]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'wali_kelas' => 'nullable|string'
        ]);

        $kela->update($request->all());
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
