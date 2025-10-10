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
        $gurus = Guru::all();
        return view('mapels.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string',
            'guru_id' => 'nullable|exists:gurus,id'
        ]);

        Mapel::create($request->all());
        return redirect()->route('mapels.index')->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    public function edit(Mapel $mapel)
    {
        $gurus = Guru::all();
        return view('mapels.edit', compact('mapel', 'gurus'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama_mapel' => 'required|string',
            'guru_id' => 'nullable|exists:gurus,id'
        ]);

        $mapel->update($request->all());
        return redirect()->route('mapels.index')->with('success', 'Mata Pelajaran berhasil diupdate');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return redirect()->route('mapels.index')->with('success', 'Mata Pelajaran berhasil dihapus');
    }
}
