<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\GajiController;

// 🔹 Halaman utama redirect ke /home
Route::get('/', function () {
    return redirect()->route('home');
});

// 🔹 Dashboard Home (hanya bisa diakses setelah login)
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// 🔹 Login / Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 Semua route yang butuh login
Route::middleware(['auth'])->group(function () {

    // CRUD Data Sekolah
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class)->parameter('kelas', 'kelas');
    Route::resource('mapels', MapelController::class);
    Route::resource('nilais', NilaiController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('keuangan', KeuanganController::class);
    Route::resource('gaji', GajiController::class);

    Route::get('/mapels/{mapel}/gurus', [MapelController::class, 'showGurus'])->name('mapels.gurus');
    Route::post('/gaji/{guru}/bayar', [GajiController::class, 'bayar'])->name('gaji.bayar');

    // 🔹 Event untuk kalender
    Route::get('/events', [EventController::class, 'index'])->name('events.index');            // load data kalender
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');  // ✅ form tambah event
    Route::post('/events', [EventController::class, 'store'])->name('events.store');          // simpan event
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy'); // hapus event
});
