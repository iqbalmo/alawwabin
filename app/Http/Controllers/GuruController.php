<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index(Request $request) // <-- Tambahkan 'Request $request'
    {
        // 1. Ambil kata kunci pencarian
        $search = $request->query('search');

        // 2. Mulai query builder
        $query = Guru::with('mapel');

        // 3. Jika ada kata kunci pencarian, filter datanya
        if ($search) {
            // Kita cari di kolom 'nama' ATAU 'nip'
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%');
        }

        // 4. Lanjutkan dengan sorting dan paginasi
        $guru = $query->orderBy('nama', 'asc')->paginate(15);

        // 5. Buat link paginasi tetap membawa kata kunci pencarian
        $guru->appends($request->query());

        // 6. Kirim data guru DAN kata kunci pencarian ke view
        return view('guru.index', compact('guru', 'search'));
    }

    public function create()
    {
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('guru.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:100',
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

    public function update(Request $request, Guru $guru)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:100',
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