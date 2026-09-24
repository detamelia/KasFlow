<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
