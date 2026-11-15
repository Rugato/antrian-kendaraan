<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\AntrianController;

// Redirect halaman utama ke daftar antrian
Route::get('/', function () {
    return redirect()->route('antrian.index');
});

// Route khusus tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route terproteksi (wajib login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // CRUD & Cetak PDF Data Kendaraan
    Route::resource('kendaraan', KendaraanController::class)->except(['show']);
    Route::get('/kendaraan-cetak-pdf', [KendaraanController::class, 'cetakPdf'])->name('kendaraan.pdf');

    // CRUD & Cetak PDF Data Antrian
    Route::resource('antrian', AntrianController::class)->except(['show']);
    Route::get('/antrian-cetak-pdf', [AntrianController::class, 'cetakPdf'])->name('antrian.pdf');
});