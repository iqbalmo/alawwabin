<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule untuk validasi unique

class GuruController extends Controller
{
    public function index()
    {
        // Eager load relasi 'mapel' dan urutkan berdasarkan nama
        $guru = Guru::with('mapel')
                    ->orderBy('nama', 'asc')
                    ->paginate(15);
                    
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('guru.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        // Validasi semua data baru
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100|unique:gurus,nip',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pend_terakhir_tahun' => 'nullable|string:4',
            'pend_terakhir_univ' => 'nullable|string|max:255',
            'pend_terakhir_jurusan' => 'nullable|string|max:255',
            'tahun_mulai_bekerja' => 'nullable|string:4',
            'jabatan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'nullable|in:PNS,Swasta',
            'mapel_id' => 'nullable|exists:mapels,id',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        Guru::create($validatedData);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('guru.edit', compact('guru', 'mapels'));
    }

    public function update(Request $request, Guru $guru)
    {
        // Validasi semua data baru, dengan 'ignore' untuk NIP
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('gurus')->ignore($guru->id),
            ],
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pend_terakhir_tahun' => 'nullable|string:4',
            'pend_terakhir_univ' => 'nullable|string|max:255',
            'pend_terakhir_jurusan' => 'nullable|string|max:255',
            'tahun_mulai_bekerja' => 'nullable|string:4',
            'jabatan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'nullable|in:PNS,Swasta',
            'mapel_id' => 'nullable|exists:mapels,id',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        $guru->update($validatedData);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}