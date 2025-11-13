<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    EventController,
    GajiController,
    GuruController,
    GuruLogController,
    HomeController,
    JadwalController,
    KelasController,
    KeuanganController,
    MapelController,
    NilaiController,
    SiswaController,
    RiwayatController,
    RekapController
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

    // 🔹 CRUD Data Sekolah
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class)->parameter('kelas', 'kelas');
    Route::resource('mapels', MapelController::class);
    Route::resource('nilais', NilaiController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::post('/kelas/{kelas}/reorder-absen', [KelasController::class, 'reorderAbsen'])->name('kelas.reorderAbsen');

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
