<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PendapatanController;
use App\Http\Controllers\Admin\PendapatanImportController;
use App\Http\Controllers\Admin\BelanjaImportController;
use App\Http\Controllers\Admin\{
    BelanjaController,
    PembiayaanController,
    RealisasiController,
    DokumenController
};
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])
    ->name('home');

Route::get('/apbdesa/{tahun}', [PublicController::class, 'apbdesa'])
    ->name('apbdesa');

Route::get('/pendapatan/{tahun}', [PublicController::class, 'pendapatan'])
    ->name('pendapatan');

Route::get('/belanja/{tahun}', [PublicController::class, 'belanja'])
    ->name('belanja');

Route::get('/pembiayaan/{tahun}', [PublicController::class, 'pembiayaan'])
    ->name('pembiayaan');

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

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            [SettingController::class, 'dashboard']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Profil Desa
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/profil-desa',
            [SettingController::class, 'profile']
        )->name('profile');

        Route::put(
            '/profil-desa',
            [SettingController::class, 'updateProfile']
        )->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | Tahun Anggaran
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/tahun-anggaran',
            [SettingController::class, 'years']
        )->name('years');

        Route::post(
            '/tahun-anggaran',
            [SettingController::class, 'storeYear']
        )->name('years.store');

        Route::patch(
            '/tahun-anggaran/{year}/aktif',
            [SettingController::class, 'activate']
        )->name('years.activate');


        /*
        |--------------------------------------------------------------------------
        | Pendapatan
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'pendapatan',
            PendapatanController::class
        )->except('show');


        // Import Excel Pendapatan
        Route::get(
            '/pendapatan/import',
            [PendapatanImportController::class, 'form']
        )->name('pendapatan.import.form');

        Route::post(
            '/pendapatan/import',
            [PendapatanImportController::class, 'import']
        )->name('pendapatan.import');


        // Download Template Excel Pendapatan
        Route::get(
            '/pendapatan/template',
            [PendapatanImportController::class, 'template']
        )->name('pendapatan.template');


        // Publikasi Pendapatan
        Route::patch(
            '/pendapatan/{pendapatan}/publikasi',
            [PendapatanController::class, 'togglePublication']
        )->name('pendapatan.publication');


        /*
        |--------------------------------------------------------------------------
        | Belanja
        |--------------------------------------------------------------------------
        */

        // Hapus semua Belanja
        Route::delete(
            'belanja/hapus-semua',
            [BelanjaController::class, 'destroyAll']
        )->name('belanja.destroyAll');


        // Resource Belanja
        Route::resource(
            'belanja',
            BelanjaController::class
        )->except('show');


        // Tambah Bidang
        Route::post(
            'belanja/bidang',
            [BelanjaController::class, 'storeBidang']
        )->name('belanja.bidang.store');


        // Tambah Kegiatan
        Route::post(
            'belanja/kegiatan',
            [BelanjaController::class, 'storeKegiatan']
        )->name('belanja.kegiatan.store');


        // Publikasi Belanja
        Route::patch(
            'belanja/{belanja}/publikasi',
            [BelanjaController::class, 'publication']
        )->name('belanja.publication');


        // Import Excel Belanja
        Route::get(
            'belanja/import',
            [BelanjaImportController::class, 'form']
        )->name('belanja.import.form');

        Route::post(
            'belanja/import',
            [BelanjaImportController::class, 'import']
        )->name('belanja.import');


        // Download Template Excel Belanja
        Route::get(
            'belanja/template',
            [BelanjaImportController::class, 'template']
        )->name('belanja.template');


        /*
        |--------------------------------------------------------------------------
        | Pembiayaan
        |--------------------------------------------------------------------------
        */

        // Hapus semua Pembiayaan
        Route::delete(
            'pembiayaan/hapus-semua',
            [PembiayaanController::class, 'destroyAll']
        )->name('pembiayaan.destroyAll');


        // Resource Pembiayaan
        Route::resource(
            'pembiayaan',
            PembiayaanController::class
        )->except('show');


        // Publikasi Pembiayaan
        Route::patch(
            'pembiayaan/{pembiayaan}/publikasi',
            [PembiayaanController::class, 'publication']
        )->name('pembiayaan.publication');


        /*
        |--------------------------------------------------------------------------
        | Dokumen Publikasi
        |--------------------------------------------------------------------------
        */

        Route::resource(
    'dokumen',
    DokumenController::class
)->except('show')
    ->parameters([
        'dokumen' => 'dokumen',
    ]);


        Route::patch(
            'dokumen/{dokumen}/publikasi',
            [DokumenController::class, 'publication']
        )->name('dokumen.publication');


        /*
        |--------------------------------------------------------------------------
        | Realisasi
        |--------------------------------------------------------------------------
        */

        // Daftar Realisasi
        Route::get(
            'realisasi',
            [RealisasiController::class, 'index']
        )->name('realisasi.index');


        // Form Tambah Realisasi
        Route::get(
            'realisasi/create',
            [RealisasiController::class, 'create']
        )->name('realisasi.create');


        // Simpan Realisasi Baru
        Route::post(
            'realisasi',
            [RealisasiController::class, 'store']
        )->name('realisasi.store');


        // Form Edit Realisasi
        Route::get(
            'realisasi/{jenis}/{id}/edit',
            [RealisasiController::class, 'edit']
        )->name('realisasi.edit');


        // Update Realisasi
        Route::put(
            'realisasi/{jenis}/{id}',
            [RealisasiController::class, 'update']
        )->name('realisasi.update');


        // Hapus Realisasi
        Route::delete(
            'realisasi/{jenis}/{id}',
            [RealisasiController::class, 'destroy']
        )->name('realisasi.destroy');


        // Publikasi / Jadikan Draft
        Route::patch(
            'realisasi/{jenis}/{id}/publikasi',
            [RealisasiController::class, 'publication']
        )->name('realisasi.publication');

    });


/*
|--------------------------------------------------------------------------
| Breeze Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';