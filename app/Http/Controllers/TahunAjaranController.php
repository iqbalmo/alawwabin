<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunAjarans = TahunAjaran::orderBy('tanggal_mulai', 'desc')->get();
        $activeTahunAjaran = TahunAjaran::getActive();

        return view('tahun-ajaran.index', compact('tahunAjarans', 'activeTahunAjaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tahun-ajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:tahun_ajarans,nama|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        $tahunAjaran = TahunAjaran::create($request->all());

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('tahun-ajaran.edit', compact('tahunAjaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:tahun_ajarans,nama,' . $tahunAjaran->id,
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        $tahunAjaran->update($request->all());

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        // Check if this academic year has any agendas
        if ($tahunAjaran->agendas()->count() > 0) {
            return redirect()->route('tahun-ajaran.index')
                ->with('error', 'Tidak dapat menghapus Tahun Ajaran yang memiliki data absensi.');
        }

        $tahunAjaran->delete();

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil dihapus.');
    }

    /**
     * Set a specific academic year as active
     */
    public function setActive(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->setAsActive();

        return redirect()->route('tahun-ajaran.index')
            ->with('success', "Tahun Ajaran {$tahunAjaran->nama} telah diaktifkan.");
    }
}
