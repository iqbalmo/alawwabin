<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // 1. Tambahkan withCount('siswas')
        $semuaKelas = Kelas::with('wali')
                        ->withCount('siswa')
                        ->orderBy('tingkat', 'asc')
                        ->orderBy('nama_kelas', 'asc')
                        ->get(); 

        // 2. Kelompokkan hasilnya
        $groupedKelas = $semuaKelas->groupBy('tingkat');
        
        // 3. Kirim data yang sudah terkelompok ke view
        return view('kelas.index', compact('groupedKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();
        return view('kelas.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|string|max:20',
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                // Aturan ini memeriksa: "nama_kelas" harus unik di tabel 'kelas'
                // DIMANA "tingkat"-nya sama dengan yang diinput.
                Rule::unique('kelas')->where(function ($query) use ($request) {
                    return $query->where('tingkat', $request->tingkat);
                }),
            ],
            'wali_kelas_id' => 'nullable|exists:gurus,id'
        ], [
            // Pesan error kustom agar lebih jelas
            'nama_kelas.unique' => 'Kombinasi Tingkat dan Nama Kelas ini sudah ada.'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    // Parameter (Kelas $kelas) sudah benar (perbaikan dari Anda)
    public function show(Kelas $kelas) 
    {
        // Eager load relasi 'waliKelas' (info guru)
        // dan 'siswas' (daftar siswa di kelas itu).
        
        // PERBAIKAN: diubah dari 'wali' menjadi 'waliKelas'
        $kelas->load(['siswa' => function ($query) {
            $query->orderBy('no_absen', 'asc')->orderBy('nama', 'asc');
        }, 'wali']);

        // PERBAIKAN: Baris '$kelas = $kelas;' dihapus karena tidak perlu
        
        return view('kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Parameter (Kelas $kelas) sudah benar (perbaikan dari Anda)
    public function edit(Kelas $kelas) 
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();
        
        // PERBAIKAN: Baris '$kelas = $kelas;' dihapus karena tidak perlu
        
        return view('kelas.edit', compact('kelas', 'gurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Parameter (Kelas $kelas) sudah benar (perbaikan dari Anda)
    public function update(Request $request, Kelas $kelas) 
    {
        $request->validate([
            'tingkat' => 'required|string|max:20',
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                // Aturan yang sama, tapi 'ignore' (abaikan) ID kelas saat ini
                Rule::unique('kelas')->where(function ($query) use ($request) {
                    return $query->where('tingkat', $request->tingkat);
                })->ignore($kelas->id), // $kela->id adalah ID kelas yg sedang diedit
            ],
            'wali_kelas_id' => 'nullable|exists:gurus,id'
        ], [
            'nama_kelas.unique' => 'Kombinasi Tingkat dan Nama Kelas ini sudah ada.'
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Parameter (Kelas $kelas) sudah benar (perbaikan dari Anda)
    public function destroy(Kelas $kelas) 
    {
        // Peringatan: Hati-hati saat menghapus kelas, 
        // pastikan relasi siswa sudah diatur (misal: onDelete('set null'))
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function reorderAbsen(Kelas $kelas)
    {
        // 1. Ambil semua siswa di kelas ini, urutkan berdasarkan NAMA (A-Z)
        $siswa = Siswa::where('kelas_id', $kelas->id)
                        ->orderBy('nama', 'asc')
                        ->get();

        // 2. Loop melalui siswa yang sudah terurut
        $nomorAbsen = 1;
        foreach ($siswa as $siswa) {
            // 3. Update nomor absen mereka satu per satu
            $siswa->no_absen = $nomorAbsen;
            $siswa->save(); // Simpan perubahan
            $nomorAbsen++; // Tambah nomor untuk siswa berikutnya
        }

        // 4. Kembalikan ke halaman detail kelas dengan pesan sukses
        return redirect()->route('kelas.show', $kelas->id)
                         ->with('success', 'Nomor absen untuk ' . $siswa->count() . ' siswa di kelas ' . $kelas->nama_kelas . ' telah berhasil diurutkan.');
    }

    public function showPromotionTool()
    {
        // Ambil semua kelas, SUDAH LENGKAP dengan relasi
        $allKelas = Kelas::with('wali')
                         ->withCount('siswa') // <-- TAMBAHKAN INI
                         ->orderBy('tingkat', 'asc')
                         ->orderBy('nama_kelas', 'asc')
                         ->get();
        
        // Kelompokkan kelas berdasarkan tingkat (untuk tampilan)
        $groupedKelas = $allKelas->groupBy('tingkat');
        
        // Siapkan daftar kelas tujuan
        $targetKelasList = $allKelas;

        return view('kelas.promosi', compact('groupedKelas', 'targetKelasList'));
    }
    // ----------------------------

    // --- METHOD INI TIDAK BERUBAH ---
    public function processPromotion(Request $request)
    {
        $request->validate([
            'promosi' => 'required|array',
        ]);

        $mappings = $request->input('promosi');
        $luluskanSiswaCount = 0;
        $pindahkanSiswaCount = 0;

        DB::transaction(function () use ($mappings, &$luluskanSiswaCount, &$pindahkanSiswaCount) {
            
            foreach ($mappings as $sourceClassId => $targetAction) {
                
                if ($targetAction == 'jangan_pindahkan') {
                    continue; 
                }

                if ($targetAction == 'luluskan') {
                    $count = Siswa::where('kelas_id', $sourceClassId)->count();
                    
                    Siswa::where('kelas_id', $sourceClassId)
                         ->update([
                             'kelas_id' => null, 
                             'status_mukim' => 'Lulus' 
                         ]);
                    
                    $luluskanSiswaCount += $count;
                }

                if (is_numeric($targetAction)) {
                    $targetClassId = (int)$targetAction;
                    $count = Siswa::where('kelas_id', $sourceClassId)->count();

                    Siswa::where('kelas_id', $sourceClassId)
                         ->update([
                             'kelas_id' => $targetClassId 
                         ]);
                    
                    $pindahkanSiswaCount += $count;
                }
            }
        });

        $message = "Proses kenaikan kelas berhasil.";
        if ($pindahkanSiswaCount > 0) {
            $message .= " $pindahkanSiswaCount siswa telah dipindahkan ke kelas baru.";
        }
        if ($luluskanSiswaCount > 0) {
            $message .= " $luluskanSiswaCount siswa telah diluluskan.";
        }

        return redirect()->route('kelas.index')->with('success', $message);
    }
}