<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/mapels/{mapel}/gurus', [MapelController::class, 'showGurus'])->name('mapels.gurus');

    // 🔹 Event untuk kalender
    Route::resource('events', EventController::class)->only([
        'index', 'create', 'store', 'destroy',
    ]);
});
