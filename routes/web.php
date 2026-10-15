<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriSampahController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\NasabahController;
use App\Http\Controllers\Admin\TabunganController;
use App\Http\Controllers\Admin\TransaksiSetoranController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PetugasBankSampah\DashboardController as PetugasDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::post('logout', LogoutController::class)->name('logout');
Route::view('account/pending', 'auth.portal-pending')
    ->middleware('auth')
    ->name('account.pending');

Route::prefix('petugas')
    ->name('petugas.')
    ->middleware(['auth', 'role:petugas_bank_sampah'])
    ->group(function () {
        Route::get('/', [PetugasDashboardController::class, 'index'])->name('dashboard');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin.access')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class)->except('show');
        Route::resource('nasabah', NasabahController::class);
        Route::resource('kategori-sampah', KategoriSampahController::class)
            ->parameters(['kategori-sampah' => 'kategoriSampah']);
        Route::resource('transaksi', TransaksiSetoranController::class)->only(['index', 'show'])
            ->parameters(['transaksi' => 'transaksiSetoran']);
        Route::resource('tabungan', TabunganController::class)->only(['index', 'show']);
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });
