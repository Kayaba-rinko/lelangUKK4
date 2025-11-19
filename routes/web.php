<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\userController;
use App\Http\Controllers\petugasController;
use App\Http\Controllers\barangController;
use App\Http\Controllers\lelangController;
use App\Http\Controllers\penawaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [authController::class, 'showLoginMasyarakat'])->name('login');
Route::post('/login', [authController::class, 'loginMasyarakat'])->name('login.masyarakat');

Route::get('/login-petugas', [authController::class, 'showLoginPetugas'])->name('login.petugas');
Route::post('/login-petugas', [authController::class, 'loginPetugas'])->name('login.petugas.submit');

Route::get('/register', [authController::class, 'showRegister'])->name('register');
Route::post('/register', [authController::class, 'registerMasyarakat'])->name('register.submit');

Route::post('/logout', [authController::class, 'logout'])->name('logout');

Route::middleware(['auth:masyarakat', 'isMasyarakat'])->group(function () {
    Route::get('/masyarakat/dashboard', [penawaranController::class, 'history'])->name('masyarakat.dashboard');

    Route::get('/masyarakat/bid/{id_lelang}', [penawaranController::class, 'bid'])->name('masyarakat.bid');
    Route::post('/masyarakat/placeBid/{id_lelang}', [penawaranController::class, 'placeBid'])->name('masyarakat.placebid');

    Route::get('/masyarakat/penawaran', [penawaranController::class, 'index'])->name('masyarakat.penawaran');
    Route::get('/masyarakat/penawaran/cari', [penawaranController::class, 'cari'])->name('masyarakat.penawaran.cari');

    Route::get('/masyarakat/history/{id_lelang}', [penawaranController::class, 'historyDetail'])->name('masyarakat.history.detail');
    Route::get('/history/cari', [penawaranController::class, 'historycarimasyarakat'])->name('masyarakat.history.cari');
    Route::get('masyarakat/history/cari/filter', [penawaranController::class, 'historyStatus'])->name('masyarakat.history.filter');
});
Route::middleware(['auth:petugas', 'isPetugas'])->group(function () {
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');
    Route::get('/petugas/userdata', [userController::class, 'index'])->name('petugas.userdata');
    Route::get('/petugas/userdata/create', [userController::class, 'create'])->name('petugas.userdata.create');
    Route::post('/petugas/userdata/store', [userController::class, 'store'])->name('petugas.userdata.store');
    Route::get('/petugas/userdata/{id_masyarakat}/edit', [userController::class, 'edit'])->name('petugas.userdata.edit');
    Route::put('/petugas/userdata/{id_masyarakat}', [userController::class, 'update'])->name('petugas.userdata.update');
    Route::delete('/petugas/userdata/{id_masyarakat}', [userController::class, 'destroy'])->name('petugas.userdata.destroy');

    Route::get('/petugas/datapetugas', [petugasController::class, 'index'])->name('petugas.datapetugas');
    Route::get('/petugas/datapetugas/create', [petugasController::class, 'create'])->name('petugas.datapetugas.create');
    Route::post('/petugas/datapetugas/store', [petugasController::class, 'store'])->name('petugas.datapetugas.store');
    Route::get('/petugas/datapetugas/{id_petugas}/edit', [petugasController::class, 'edit'])->name('petugas.datapetugas.edit');
    Route::put('/petugas/datapetugas/{id_petugas}', [petugasController::class, 'update'])->name('petugas.datapetugas.update');
    Route::delete('/petugas/datapetugas/{id_petugas}', [petugasController::class, 'destroy'])->name('petugas.datapetugas.destroy');

    Route::get('/petugas/barangdata', [barangController::class, 'index'])->name('petugas.barangdata');
    Route::get('/petugas/barangdata/create', [barangController::class, 'create'])->name('petugas.barangdata.create');
    Route::post('/petugas/barangdata/store', [barangController::class, 'store'])->name('petugas.barangdata.store');
    Route::get('/petugas/barangdata/{id_barang}/edit', [barangController::class, 'edit'])->name('petugas.barangdata.edit');
    Route::put('/petugas/barangdata/{id_barang}', [barangController::class, 'update'])->name('petugas.barangdata.update');
    Route::delete('/petugas/barangdata/{id_barang}', [barangController::class, 'destroy'])->name('petugas.barangdata.destroy');

    Route::put('/petugas/userdata/{id_masyarakat}/blokir', [userController::class, 'blokir'])->name('petugas.userdata.blokir');
    Route::put('/petugas/userdata/{id_masyarakat}/aktifkan', [userController::class, 'aktifkan'])->name('petugas.userdata.aktifkan');

    Route::get('/petugas/bukaTutup', [lelangController::class, 'index'])->name('petugas.bukaTutup');
    Route::get('/petugas/bukaTutup/create', [lelangController::class, 'create'])->name('petugas.bukaTutup.create');
    Route::post('/petugas/bukaTutup/store', [lelangController::class, 'store'])->name('petugas.bukaTutup.store');
    Route::get('/petugas/bukaTutup/{id_lelang}/edit', [lelangController::class, 'edit'])->name('petugas.bukaTutup.edit');
    Route::put('/petugas/bukaTutup/{id_lelang}', [lelangController::class, 'update'])->name('petugas.bukaTutup.update');
    Route::delete('/petugas/bukaTutup/{id_lelang}', [lelangController::class, 'destroy'])->name('petugas.bukaTutup.destroy');

    Route::put('/petugas/bukaTutup/{id_lelang}/tutup', [lelangController::class, 'tutuplelang'])->name('petugas.bukaTutup.tutup');
    Route::get('/petugas/bukaTutup/{id_lelang}/buka', [lelangController::class, 'bukalelang'])->name('petugas.bukaTutup.buka');

    Route::get('/petugas/barangdata/cari', [barangController::class, 'cari'])->name('petugas.barang.cari');

    Route::get('/petugas/datapetugas/cari', [petugasController::class, 'cari'])->name('petugas.petugas.cari');

    Route::get('/petugas/userdata/cari', [userController::class, 'cari'])->name('petugas.userdata.cari');

    Route::get('/petugas/laporan', [lelangController::class, 'laporan'])->name('laporan.petugas');
    Route::get('/petugas/laporan/admin', [lelangController::class, 'laporanAdmin'])->name('laporan.admin');

    Route::get('/petugas/bukaTutup/cari', [lelangController::class, 'cari'])->name('petugas.bukaTutup.cari');

    Route::get('/petugas/history', [lelangController::class, 'historypetugas'])->name('history.petugas');
    Route::get('/petugas/history/cari', [lelangController::class, 'historypetugascari'])->name('petugas.historyPetugas.cari');
    Route::get('/petugas/history/cari/filter', [lelangController::class, 'tanggal'])->name('petugas.historyPetugas.filter');
});
