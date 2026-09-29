<?php
use App\Http\Controllers\PublicDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TahunAnggaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
Route::get('/', PublicDashboardController::class)->name('home');
Route::get('/profil-desa',[PublicDashboardController::class,'profile'])->name('profile.public');
Route::view('/login','auth.login')->middleware('guest')->name('login');
Route::post('/login',[AuthenticatedSessionController::class,'store'])->middleware('guest')->name('login.store');
Route::post('/logout',[AuthenticatedSessionController::class,'destroy'])->middleware('auth')->name('logout');
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function(){
 Route::get('/',DashboardController::class)->name('dashboard');
 Route::get('/profil-desa',[ProfileController::class,'edit'])->name('profile.edit'); Route::put('/profil-desa',[ProfileController::class,'update'])->name('profile.update');
 Route::get('/tahun-anggaran',[TahunAnggaranController::class,'index'])->name('years.index'); Route::post('/tahun-anggaran',[TahunAnggaranController::class,'store'])->name('years.store'); Route::patch('/tahun-anggaran/{tahunAnggaran}/aktif',[TahunAnggaranController::class,'activate'])->name('years.activate');
});
