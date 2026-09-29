<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/apbdesa/{tahun}', [PublicController::class, 'apbdesa'])
    ->name('apbdesa');

Route::get('/pendapatan/{tahun}', function ($tahun) {
    return redirect()->route('apbdesa', $tahun);
})->name('pendapatan');

Route::get('/belanja/{tahun}', function ($tahun) {
    return redirect()->route('apbdesa', $tahun);
})->name('belanja');

Route::get('/pembiayaan/{tahun}', function ($tahun) {
    return redirect()->route('apbdesa', $tahun);
})->name('pembiayaan');

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