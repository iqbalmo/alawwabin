<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('mapel')->get();  // tampilkan nama mapel
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        $mapels = Mapel::all();  // ambil semua mapel untuk dropdown
        return view('guru.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'mapel_id' => 'required|exists:mapels,id',
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
            'nama' => 'required',
            'mapel_id' => 'required',
            'alamat' => 'required',
            'telepon' => 'required'
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
