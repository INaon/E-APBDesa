<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PendapatanController;
use App\Http\Controllers\Admin\{BelanjaController,PembiayaanController,RealisasiController,DokumenController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/apbdesa/{tahun}', [PublicController::class, 'apbdesa'])
    ->name('apbdesa');

Route::get('/pendapatan/{tahun}', [PublicController::class, 'pendapatan'])
    ->name('pendapatan');

Route::get('/belanja/{tahun}', [PublicController::class, 'belanja'])->name('belanja');

Route::get('/pembiayaan/{tahun}', [PublicController::class, 'pembiayaan'])->name('pembiayaan');

Route::get('/realisasi/{tahun}', [PublicController::class, 'realisasi'])
    ->name('realisasi');

Route::get('/dokumen/{tahun}', [PublicController::class, 'documents'])
    ->name('dokumen');

Route::get('/profil-desa', [PublicController::class, 'profile'])
    ->name('profil');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [SettingController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/profil-desa', [SettingController::class, 'profile'])
            ->name('profile');

        Route::put('/profil-desa', [SettingController::class, 'updateProfile'])
            ->name('profile.update');

        Route::get('/tahun-anggaran', [SettingController::class, 'years'])
            ->name('years');

        Route::post('/tahun-anggaran', [SettingController::class, 'storeYear'])
            ->name('years.store');

        Route::patch('/tahun-anggaran/{year}/aktif', [SettingController::class, 'activate'])
            ->name('years.activate');

        Route::resource('pendapatan', PendapatanController::class)
            ->except('show');

        Route::patch('/pendapatan/{pendapatan}/publikasi', [PendapatanController::class, 'togglePublication'])
            ->name('pendapatan.publication');

        Route::resource('belanja', BelanjaController::class)->except('show');
        Route::post('belanja/bidang', [BelanjaController::class, 'storeBidang'])->name('belanja.bidang.store');
        Route::post('belanja/kegiatan', [BelanjaController::class, 'storeKegiatan'])->name('belanja.kegiatan.store');
        Route::patch('belanja/{belanja}/publikasi', [BelanjaController::class, 'publication'])->name('belanja.publication');

        Route::resource('pembiayaan', PembiayaanController::class)->except('show');
        Route::patch('pembiayaan/{pembiayaan}/publikasi', [PembiayaanController::class, 'publication'])->name('pembiayaan.publication');
        Route::resource('dokumen', DokumenController::class)->except('show');
        Route::patch('dokumen/{dokumen}/publikasi', [DokumenController::class, 'publication'])->name('dokumen.publication');
        Route::get('realisasi', [RealisasiController::class, 'index'])->name('realisasi.index');
        Route::get('realisasi/create', [RealisasiController::class, 'create'])->name('realisasi.create');
        Route::post('realisasi', [RealisasiController::class, 'store'])->name('realisasi.store');
        Route::delete('realisasi/{jenis}/{id}', [RealisasiController::class, 'destroy'])->name('realisasi.destroy');
        Route::patch('realisasi/{jenis}/{id}/publikasi', [RealisasiController::class, 'publication'])->name('realisasi.publication');
    });


/*
|--------------------------------------------------------------------------
| Breeze Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__.'/auth.php';
