<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::with('gurus')->get();
        return view('mapels.index', compact('mapels'));
    }

    public function create()
    {
        $gurus = Guru::all();
        return view('mapels.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'guru_ids' => 'nullable|array',
            'guru_ids.*' => 'exists:gurus,id',
        ]);

        $mapel = Mapel::create([
            'nama_mapel' => $request->input('nama_mapel'),
        ]);

        // Attach selected gurus to this mapel
        if ($request->has('guru_ids')) {
            $mapel->gurus()->attach($request->input('guru_ids'));
        }

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
            'guru_ids' => 'nullable|array',
            'guru_ids.*' => 'exists:gurus,id',
        ]);

        // Update mapel data
        $mapel->update([
            'nama_mapel' => $request->input('nama_mapel'),
        ]);

        // Sync gurus (remove old relationships, add new ones)
        $mapel->gurus()->sync($request->input('guru_ids', []));

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
