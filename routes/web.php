<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CekLogin;
use App\Http\Middleware\CekAdmin;

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Semua yang login bisa akses kasir + riwayat + cetak
Route::middleware([CekLogin::class])->group(function () {
    Route::get('/', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/tambah-pesanan', [KasirController::class, 'tambahPesanan'])->name('kasir.tambah');
    Route::post('/simpan-pesanan', [KasirController::class, 'simpanPesanan'])->name('kasir.simpan');
    Route::get('/riwayat', [TransaksiController::class, 'index']);
    Route::get('/cetak/{id}', [TransaksiController::class, 'cetak']);
    Route::post('/batal/{id}', [TransaksiController::class, 'batal']);

    // KHUSUS ADMIN DOANG - Kelola Menu, Dashboard, Laporan
    Route::middleware([CekAdmin::class])->group(function () {
        Route::get('/dashboard', [TransaksiController::class, 'dashboard']);
        Route::get('/menu', [MenuController::class, 'index']);
        Route::get('/menu/tambah', [MenuController::class, 'create']);
        Route::post('/menu/simpan', [MenuController::class, 'store']);
        Route::get('/menu/edit/{id}', [MenuController::class, 'edit']);
        Route::post('/menu/update/{id}', [MenuController::class, 'update']);
        Route::get('/menu/hapus/{id}', [MenuController::class, 'destroy']);
        Route::get('/laporan/export', [LaporanController::class, 'export']);
        Route::get('/laporan', [LaporanController::class, 'index']);
    });
});
