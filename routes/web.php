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
    EkskulController,
    AgendaController,
};

// 🔹 Redirect root ke dashboard home
Route::redirect('/', '/home');

// 🔹 Dashboard (hanya untuk user login)
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth'); // Semua user yang login boleh lihat dashboard

// 🔹 Autentikasi (Rute publik, tidak perlu auth)
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth'); // Logout harus user yg login
});

// 🔹 Semua route yang butuh login
Route::middleware(['auth'])->group(function () {

    // Ubah password boleh dilakukan semua user
    Route::get('/ubah-password', [AuthController::class, 'showPasswordForm'])->name('password.edit');
    Route::post('/ubah-password', [AuthController::class, 'updatePassword'])->name('password.update');

    // -----------------------------------------------------------------
    // 🔹 MANAJEMEN SISWA (Admin & Wali Kelas)
    // -----------------------------------------------------------------
    Route::middleware(['permission:manage siswa'])->group(function () {
        Route::get('/siswa/import', [SiswaController::class, 'showImportForm'])->name('siswa.import');
        Route::get('/siswa/arsip', [SiswaController::class, 'archive'])->name('siswa.archive');
        Route::resource('siswa', SiswaController::class);
    });

    // -----------------------------------------------------------------
    // 🔹 MANAJEMEN GURU (Hanya Admin)
    // -----------------------------------------------------------------
    Route::resource('guru', GuruController::class)
         ->middleware('permission:manage guru');

    // -----------------------------------------------------------------
    // 🔹 MANAJEMEN KELAS (Hanya Admin)
    // -----------------------------------------------------------------
    Route::middleware(['permission:manage kelas'])->group(function () {
        Route::resource('kelas', KelasController::class)->parameter('kelas', 'kelas');
        Route::post('/kelas/{kelas}/reorder-absen', [KelasController::class, 'reorderAbsen'])->name('kelas.reorderAbsen');
        Route::get('/manajemen-kelas/kenaikan-kelas', [KelasController::class, 'showPromotionTool'])->name('kelas.promotionTool');
        Route::get('/manajemen-kelas/promosi/{kelas}', [KelasController::class, 'showClassPromotionForm'])->name('kelas.showPromotionForm');
        Route::post('/manajemen-kelas/promosi/proses', [KelasController::class, 'processClassPromotion'])->name('kelas.processPromotion');
    });

    // -----------------------------------------------------------------
    // 🔹 MANAJEMEN AKADEMIK
    // -----------------------------------------------------------------
    
    // Mapel (Admin)
    Route::resource('mapels', MapelController::class)
         ->middleware('permission:manage mapel');
    Route::get('/mapel/{mapel}/guru', [MapelController::class, 'showGurus'])
         ->name('mapels.gurus')
         ->middleware('permission:manage mapel');

    // Nilai (Admin, Wali, Guru)
    Route::resource('nilais', NilaiController::class)
         ->middleware('permission:manage nilai');

    // Jadwal (Split: Admin bisa manage, Guru/Wali bisa view)
    Route::resource('jadwal', JadwalController::class)
         ->except(['index', 'show']) // Admin C-U-D
         ->middleware('permission:manage jadwal');
    Route::resource('jadwal', JadwalController::class)
         ->only(['index', 'show']) // Admin, Wali, Guru R (Read)
         ->middleware('permission:view jadwal'); // Pastikan Admin juga punya izin 'view jadwal'

    // Ekskul (Admin)
    Route::middleware(['permission:manage ekskul'])->group(function () {
        Route::resource('ekskul', EkskulController::class);
        Route::post('/ekskul/{ekskul}/attach', [EkskulController::class, 'attachSiswa'])->name('ekskul.attachSiswa');
        Route::post('/ekskul/{ekskul}/detach/{siswa}', [EkskulController::class, 'detachSiswa'])->name('ekskul.detachSiswa');
    });

    // Event Kalender (Hanya Admin)
    Route::resource('events', EventController::class)
         ->middleware('role:admin');

    // -----------------------------------------------------------------
    // 🔹 LOG & RIWAYAT
    // -----------------------------------------------------------------
    
    // GuruLog (Admin, Wali, Guru)
    Route::prefix('gurulog')->name('gurulog.')
         ->controller(GuruLogController::class)
         ->middleware('permission:view gurulog') // Semua user login bisa lihat
         ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('agenda')->name('agenda.')->controller(AgendaController::class)->group(function () {
        Route::get('/', 'index')->name('index'); // Dashboard progres agenda
        Route::get('/create', 'create')->name('create'); // Form isi agenda
        Route::post('/', 'store')->name('store'); // Simpan agenda
        Route::get('/{jadwal_id}/show', 'show')->name('show'); // Riwayat per jadwal
        Route::get('/{agenda}/edit', 'edit')->name('edit'); // Edit 1 entri agenda
        Route::put('/{agenda}', 'update')->name('update'); // Update 1 entri agenda
        Route::delete('/{agenda}', 'destroy')->name('destroy'); // Hapus 1 entri agenda
        
        // Rute AJAX
        Route::get('/get-siswa-by-jadwal/{id}', 'getSiswaByJadwal')->name('getSiswa');
    });

    // -----------------------------------------------------------------
    // 🔹 ABSENSI & API
    // -----------------------------------------------------------------

    // API Sederhana (Harus dilindungi juga, sama seperti yg menggunakannya)
    Route::get('/api/siswa-by-jadwal/{id}', function($id) {
        $jadwal = App\Models\Jadwal::findOrFail($id);
        $siswas = App\Models\Siswa::where('kelas_id', $jadwal->kelas_id)->get();
        return response()->json($siswas);
    })->middleware('permission:manage absensi');
});