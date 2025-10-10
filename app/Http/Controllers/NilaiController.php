<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mapel;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $nilais = Nilai::with(['siswa', 'mapel'])->get();
        return view('nilais.index', compact('nilais'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $mapels = Mapel::all();
        return view('nilais.create', compact('siswas', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'semester' => 'required|string',
            'nilai' => 'required|integer|min:0|max:100'
        ]);

        Nilai::create($request->all());
        return redirect()->route('nilais.index')->with('success', 'Nilai berhasil ditambahkan');
    }

    public function edit(Nilai $nilai)
    {
        $siswas = Siswa::all();
        $mapels = Mapel::all();
        return view('nilais.edit', compact('nilai', 'siswas', 'mapels'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'semester' => 'required|string',
            'nilai' => 'required|integer|min:0|max:100'
        ]);

        $nilai->update($request->all());
        return redirect()->route('nilais.index')->with('success', 'Nilai berhasil diupdate');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilais.index')->with('success', 'Nilai berhasil dihapus');
    }
}
