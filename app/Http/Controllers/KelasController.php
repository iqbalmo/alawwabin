<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use Illuminate\Http\Request;
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
    public function store(StoreKelasRequest $request)
    {
        // Validasi sudah ditangani oleh StoreKelasRequest

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
    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        // Validasi sudah ditangani oleh UpdateKelasRequest

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
                         ->withCount('siswa') // Untuk menampilkan jumlah siswa
                         ->orderBy('tingkat', 'asc')
                         ->orderBy('nama_kelas', 'asc')
                         ->get();
        
        // Kelompokkan kelas berdasarkan tingkat (untuk tampilan)
        $groupedKelas = $allKelas->groupBy('tingkat');

        return view('kelas.promosi', compact('groupedKelas'));
    }

    // --- METHOD 2: Menampilkan Halaman CHECKBOX (BARU) ---
    public function showClassPromotionForm(Kelas $kelas)
    {
        // 1. Ambil data kelas ini dan siswanya (diurutkan)
        $kelas = $kelas->load(['siswa' => function ($query) {
            $query->orderBy('nama', 'asc');
        }]);

        // 2. Siapkan daftar kelas tujuan (Target)
        $targetKelasList = collect([]); // default koleksi kosong
        
        // Jika ini BUKAN kelas akhir (bukan 9)
        if ($kelas->tingkat < 9) { // Asumsi 9 adalah tingkat akhir
            $targetTingkat = (int)$kelas->tingkat + 1;
            $targetKelasList = Kelas::where('tingkat', $targetTingkat)
                                    ->orderBy('nama_kelas', 'asc')
                                    ->get();
        }

        return view('kelas.promosi_detail', compact('kelas', 'targetKelasList'));
    }


    // --- METHOD 3: Memproses CHECKBOX (Logika tidak berubah, nama di rute berubah) ---
    public function processClassPromotion(Request $request)
    {
        $request->validate([
            'action' => 'required|in:pindahkan,luluskan,tinggal', // Tambah aksi 'tinggal'
            'siswa_ids' => 'nullable|array', // Dibuat nullable, karena 'tinggal' mungkin tidak mengirim ID
            'siswa_ids.*' => 'exists:siswas,id',
            'target_kelas_id' => 'required_if:action,pindahkan|exists:kelas,id',
            'kelas_asal_id' => 'required|exists:kelas,id', // Tambahkan ini untuk tahu kelas mana yg diproses
        ]);

        $siswaIds = $request->input('siswa_ids', []); // Default array kosong jika tidak ada yg dicentang
        $action = $request->input('action');
        $totalCount = count($siswaIds);
        $kelasAsalId = $request->input('kelas_asal_id');

        // Jika aksinya "Tinggal Kelas", tidak ada yang perlu dilakukan
        if ($action == 'tinggal') {
             return redirect()->route('kelas.showPromotionForm', $kelasAsalId)
                         ->with('success', 'Tidak ada siswa yang dipindahkan dari kelas ini.');
        }

        // Jika aksinya Pindah atau Lulus tapi tidak ada siswa yang dicentang
        if (empty($siswaIds)) {
            return redirect()->route('kelas.showPromotionForm', $kelasAsalId)
                         ->with('error', 'Anda tidak memilih siswa untuk dipindahkan atau diluluskan.');
        }

        $message = "";

        // Gunakan Transaksi Database
        DB::transaction(function () use ($siswaIds, $action, $request, &$message, $totalCount) {
            
            if ($action == 'pindahkan') {
                $targetKelasId = $request->input('target_kelas_id');
                $targetKelas = Kelas::find($targetKelasId);

                Siswa::whereIn('id', $siswaIds)
                     ->update([
                         'kelas_id' => $targetKelasId,
                         'no_absen' => null // Kosongkan no absen
                     ]);
                
                $message = "Berhasil memindahkan $totalCount siswa ke kelas $targetKelas->tingkat - $targetKelas->nama_kelas.";

            } elseif ($action == 'luluskan') {
                
                Siswa::whereIn('id', $siswaIds)
                     ->update([
                         'kelas_id' => null, 
                         'status_mukim' => 'Lulus',
                         'no_absen' => null
                     ]);
                
                $message = "Berhasil meluluskan $totalCount siswa.";
            }
        });

        // Kembalikan ke halaman checkbox TADI
        return redirect()->route('kelas.showPromotionForm', $kelasAsalId)->with('success', $message);
    }
}