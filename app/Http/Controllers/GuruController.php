<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('mapel')->get();
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        $mapels = Mapel::all();
        return view('guru.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20|unique:gurus,nip',
            'nama' => 'required|string|max:100',
            // 🚨 DIPERBAIKI: Diubah dari 'required' menjadi 'nullable'
            'mapel_id' => 'nullable|exists:mapels,id',
            'alamat' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:15',
       ]);


        Guru::create($request->all());
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        $mapels = Mapel::all();
        return view('guru.edit', compact('guru', 'mapels'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|string|max:20|unique:gurus,nip,' . $guru->id,
            'nama' => 'required|string|max:100',
            // 🚨 DIPERBAIKI: Diubah dari 'required' menjadi 'nullable'
            'mapel_id' => 'nullable|exists:mapels,id',
            'alamat' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:15',
        ]);

        $guru->update($request->all());
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
