<?php
use Illuminate\Support\Facades\Route; use App\Http\Controllers\PublicController;
Route::get('/',[PublicController::class,'home'])->name('home');
Route::get('/apbdesa/{tahun}',[PublicController::class,'apbdesa'])->name('apbdesa');
Route::get('/pendapatan/{tahun}',fn($tahun)=>redirect()->route('apbdesa',$tahun).'#pendapatan');
Route::get('/belanja/{tahun}',fn($tahun)=>redirect()->route('apbdesa',$tahun).'#belanja');
Route::get('/pembiayaan/{tahun}',fn($tahun)=>redirect()->route('apbdesa',$tahun).'#pembiayaan');
Route::get('/realisasi/{tahun}',[PublicController::class,'realisasi'])->name('realisasi'); Route::get('/dokumen/{tahun}',[PublicController::class,'documents'])->name('dokumen'); Route::get('/profil-desa',[PublicController::class,'profile'])->name('profil');

use App\Http\Controllers\Admin\SettingController;
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function(){ Route::get('/',[SettingController::class,'dashboard'])->name('dashboard'); Route::get('/profil-desa',[SettingController::class,'profile'])->name('profile'); Route::put('/profil-desa',[SettingController::class,'updateProfile'])->name('profile.update'); Route::get('/tahun-anggaran',[SettingController::class,'years'])->name('years'); Route::post('/tahun-anggaran',[SettingController::class,'storeYear'])->name('years.store'); Route::patch('/tahun-anggaran/{year}/aktif',[SettingController::class,'activate'])->name('years.activate'); });
