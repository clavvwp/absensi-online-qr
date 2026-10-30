<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\WaliController; 
  
Route::get('/', fn() => redirect()->route('login')); 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); 
Route::post('/login', [AuthController::class, 'login']); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 

Route::middleware(['auth', 'role:admin']) 
    ->prefix('admin')->name('admin.')->group(function () { 
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); 
    Route::get('/scan', [AdminController::class, 'scan'])->name('scan'); 
    Route::post('/scan', [AdminController::class, 'scanProcess'])->name('scan.process'); 
    Route::get('/presensi', [AdminController::class, 'presensi'])->name('presensi'); 
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('siswa'); 
    Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('siswa.store'); 
    Route::delete('/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('siswa.destroy'); 
    Route::get('/qr', [AdminController::class, 'qr'])->name('qr'); 
}); 

  

Route::middleware(['auth', 'role:wali_kelas']) 
    ->prefix('wali')->name('wali.')->group(function () { 
    Route::get('/dashboard', [WaliController::class, 'dashboard'])->name('dashboard'); 
    Route::post('/presensi/{siswaId}', [WaliController::class, 'updateStatus']) 
        ->name('presensi.update'); 
});