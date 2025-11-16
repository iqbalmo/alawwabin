<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    EventController,
    GuruController,
    GuruLogController,
    HomeController,
    JadwalController,
    KelasController,
    MapelController,
    NilaiController,
    SiswaController,
    RiwayatController,
    RekapController,
    EkskulController
};

// 🔹 Redirect root ke dashboard home
Route::redirect('/', '/home');

// 🔹 Dashboard (hanya untuk user login)
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// 🔹 Autentikasi
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// 🔹 Semua route yang butuh login
Route::middleware(['auth'])->group(function () {

    Route::get('/ubah-password', [AuthController::class, 'showPasswordForm'])->name('password.edit');
    Route::post('/ubah-password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::get('/siswa/import', [SiswaController::class, 'showImportForm'])->name('siswa.import');

    Route::get('/siswa/arsip', [SiswaController::class, 'archive'])->name('siswa.archive');

    // 🔹 CRUD Data Sekolah
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class)->parameter('kelas', 'kelas');
    Route::resource('mapels', MapelController::class);
    Route::resource('nilais', NilaiController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('ekskul', EkskulController::class);
    
    // --- TAMBAHKAN DUA RUTE INI ---
    Route::post('/ekskul/{ekskul}/attach', [EkskulController::class, 'attachSiswa'])->name('ekskul.attachSiswa');
    Route::post('/ekskul/{ekskul}/detach/{siswa}', [EkskulController::class, 'detachSiswa'])->name('ekskul.detachSiswa');

    Route::post('/kelas/{kelas}/reorder-absen', [KelasController::class, 'reorderAbsen'])->name('kelas.reorderAbsen');

    Route::get('/manajemen-kelas/kenaikan-kelas', [KelasController::class, 'showPromotionTool'])->name('kelas.promotionTool');
    
    // RUTE BARU (untuk menampilkan halaman checkbox per kelas)
    Route::get('/manajemen-kelas/promosi/{kelas}', [KelasController::class, 'showClassPromotionForm'])->name('kelas.showPromotionForm');
    
    // Rute LAMA (dulu 'processPromotion', sekarang kita ganti nama agar lebih jelas)
    // Ini adalah tujuan form checkbox
    Route::post('/manajemen-kelas/promosi/proses', [KelasController::class, 'processClassPromotion'])->name('kelas.processPromotion');

    // 🔹 Relasi Mapel -> Guru
    Route::get('/mapel/{mapel}/guru', [MapelController::class, 'showGurus'])
        ->name('mapels.gurus');

    // 🔹 Event untuk kalender
    Route::resource('events', EventController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    // 🔹 GuruLog
    Route::prefix('gurulog')->name('gurulog.')->controller(GuruLogController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // 🔹 Riwayat
    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');


    // 🔹 Rekap Absensi
    // 🔹 Rekap Absensi
Route::prefix('rekap')->name('rekap.')->group(function () {
    Route::get('/', [RekapController::class, 'index'])->name('index'); // List semua rekap
    Route::get('/create', [RekapController::class, 'create'])->name('create'); // Form tambah rekap
    Route::post('/', [RekapController::class, 'store'])->name('store'); // Simpan rekap
    Route::get('/get-siswa-by-jadwal/{id}', [RekapController::class, 'getSiswaByJadwal']); // AJAX
    Route::get('/{id}/edit', [RekapController::class, 'edit'])->name('edit'); // Edit rekap
    Route::put('/{id}', [RekapController::class, 'update'])->name('update'); // Update rekap
    Route::delete('/{id}', [RekapController::class, 'destroy'])->name('destroy'); // Hapus rekap
});


    // 🔹 API sederhana (optional, bisa hapus kalau sudah ada AJAX)
    Route::get('/api/siswa-by-jadwal/{id}', function($id) {
        $jadwal = App\Models\Jadwal::findOrFail($id);
        $siswas = App\Models\Siswa::where('kelas_id', $jadwal->kelas_id)->get();
        return response()->json($siswas);
    });
});
