<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        // Halaman ini sekarang hanya memuat 'shell'
        // Komponen Livewire 'search-guru' akan menangani semua data.
        return view('guru.index');
    }

    public function create()
    {
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('guru.create', compact('mapels'));
    }

    public function store(StoreGuruRequest $request)
    {
        $validatedData = $request->validated();

        Guru::create($validatedData);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    // --- TAMBAHKAN METHOD BARU INI ---
    /**
     * Menampilkan halaman detail untuk satu guru.
     */
    public function show(Guru $guru)
    {
        // Eager load relasi 'mapel' (Mapel yg diampu) 
        // dan 'kelasWali' (Kelas yg dia jadi walinya)
        $guru->load('mapel', 'wali'); 
        
        return view('guru.show', compact('guru'));
    }
    // ---------------------------------

    public function edit(Guru $guru)
    {
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('guru.edit', compact('guru', 'mapels'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru)
    {
        $validatedData = $request->validated();

        $guru->update($validatedData);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}