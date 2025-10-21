<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::with('guru')->get();
        return view('mapels.index', compact('mapels'));
    }

    public function create()
    {
        return view('mapels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string'
        ]);

        Mapel::create([
            'nama_mapel' => $request->input('nama_mapel'),
        ]);

        return redirect()->route('mapels.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit($id) // Atau bisa juga: public function edit(Mapel $mapel)
    {
        // 🚨 DIPERBAIKI: Gunakan with('gurus') untuk memuat relasi guru
        $mapel = Mapel::with('gurus')->findOrFail($id);
        
        // Ambil semua guru untuk dropdown
        $gurus = Guru::all(); 
        
        return view('mapels.edit', compact('mapel', 'gurus'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mapels,nama_mapel,' . $mapel->id,
            'guru_id' => 'nullable|exists:gurus,id',
        ]);

        // 1. Update data dasar mata pelajaran
        $mapel->update([
            'nama_mapel' => $request->input('nama_mapel'),
            'guru_id' => $request->input('guru_id'), // Update guru utama
        ]);

        // 2. 🚨 SINKRONISASI RELASI MANY-TO-MANY
        // Jika ada guru_id yang dipilih di dropdown, sinkronkan ke tabel pivot.
        if ($request->has('guru_id') && $request->input('guru_id') != '') {
            // sync() akan menghapus semua relasi lama dan menambahkan yang baru.
            // Ini memastikan guru utama juga terdaftar sebagai pengajar.
            $mapel->gurus()->sync([$request->input('guru_id')]);
        } else {
            // Jika tidak ada guru yang dipilih, hapus semua relasi.
            $mapel->gurus()->detach();
        }

        return redirect()->route('mapels.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function showGurus(Mapel $mapel)
    {
        // Memuat relasi 'gurus' untuk mata pelajaran yang dipilih
        $mapel->load('gurus');
        
        // Mengirim data mata pelajaran (dengan daftar gurunya) ke view baru
        return view('mapels.gurus', compact('mapel'));
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return redirect()->route('mapels.index')->with('success', 'Mata Pelajaran berhasil dihapus');
    }
}
