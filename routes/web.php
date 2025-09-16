<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Forecaster\ForecasterController;
use App\Http\Controllers\Penerbangan\PenerbanganController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes - Forecaster (Tim BMKG)
Route::middleware(['auth', 'role:forecaster'])->prefix('forecaster')->name('forecaster.')->group(function () {
    Route::get('/dashboard', [ForecasterController::class, 'dashboard'])->name('dashboard');
    
    // Dokumen Harian
    Route::get('/dokumen-harian', [ForecasterController::class, 'dokumenHarian'])->name('dokumen.index');
    Route::get('/dokumen-harian/create', [ForecasterController::class, 'createDokumen'])->name('dokumen.create');
    Route::post('/dokumen-harian', [ForecasterController::class, 'storeDokumen'])->name('dokumen.store');
    Route::get('/dokumen-harian/{id}/edit', [ForecasterController::class, 'editDokumen'])->name('dokumen.edit');
    Route::put('/dokumen-harian/{id}', [ForecasterController::class, 'updateDokumen'])->name('dokumen.update');
    Route::delete('/dokumen-harian/{id}', [ForecasterController::class, 'deleteDokumen'])->name('dokumen.delete');
    
    // Riwayat Unduhan
    Route::get('/riwayat-unduhan', [ForecasterController::class, 'riwayatUnduhan'])->name('riwayat');
    
    // Laporan Bulanan
    Route::get('/laporan-bulanan', [ForecasterController::class, 'laporanBulanan'])->name('laporan');
    
    // Info Kontak
    Route::get('/info-kontak', [ForecasterController::class, 'infoKontak'])->name('kontak');
});

// Protected Routes - Penerbangan (Staf Maskapai)
Route::middleware(['auth', 'role:penerbangan'])->prefix('penerbangan')->name('penerbangan.')->group(function () {
    Route::get('/dashboard', [PenerbanganController::class, 'dashboard'])->name('dashboard');
    
    // Dokumen Harian
    Route::get('/dokumen-harian', [PenerbanganController::class, 'dokumenHarian'])->name('dokumen.index');
    Route::get('/dokumen-harian/{id}/download', [PenerbanganController::class, 'downloadDokumen'])->name('dokumen.download');
    
    // Riwayat Unduhan
    Route::get('/riwayat-unduhan', [PenerbanganController::class, 'riwayatUnduhan'])->name('riwayat');
    
    // Laporan Bulanan
    Route::get('/laporan-bulanan', [PenerbanganController::class, 'laporanBulanan'])->name('laporan');
    
    // Info Kontak
    Route::get('/info-kontak', [PenerbanganController::class, 'infoKontak'])->name('kontak');
});