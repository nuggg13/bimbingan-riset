<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('register.step1');
});

// Registration Routes
Route::prefix('register')->group(function () {
    Route::get('/step1', [App\Http\Controllers\RegistrationController::class, 'showStep1'])->name('register.step1');
    Route::post('/step1', [App\Http\Controllers\RegistrationController::class, 'processStep1'])->name('register.step1.process');
    Route::get('/step2', [App\Http\Controllers\RegistrationController::class, 'showStep2'])->name('register.step2');
    Route::post('/step2', [App\Http\Controllers\RegistrationController::class, 'processStep2'])->name('register.step2.process');
    Route::get('/success', [App\Http\Controllers\RegistrationController::class, 'showStep3'])->name('register.success');
    
    // Clear session route for success page
    Route::post('/clear-session', function () {
        session()->forget('registration_success');
        return response()->json(['status' => 'success']);
    })->name('register.clear-session');
});

// Peserta Authentication Routes
Route::prefix('peserta')->group(function () {
    Route::get('/login', [App\Http\Controllers\PesertaAuthController::class, 'showLoginForm'])->name('peserta.login');
    Route::post('/login', [App\Http\Controllers\PesertaAuthController::class, 'login'])->name('peserta.login.process');
    Route::post('/logout', [App\Http\Controllers\PesertaAuthController::class, 'logout'])->name('peserta.logout');
    
    // Protected peserta routes
    Route::middleware('peserta')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\PesertaDashboardController::class, 'dashboard'])->name('peserta.dashboard');
    });
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\AdminController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
    
    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/pendaftaran', [App\Http\Controllers\PendaftaranController::class, 'index'])->name('admin.pendaftaran.index');
        Route::patch('/pendaftaran/{id}/status', [App\Http\Controllers\PendaftaranController::class, 'updateStatus'])->name('admin.pendaftaran.updateStatus');
        Route::post('/pendaftaran/{id}/schedule', [App\Http\Controllers\PendaftaranController::class, 'createSchedule'])->name('admin.pendaftaran.createSchedule');
        Route::get('/pendaftaran/export', [App\Http\Controllers\PendaftaranController::class, 'export'])->name('admin.pendaftaran.export');
        
        // Mentor Routes
        Route::resource('mentor', App\Http\Controllers\MentorController::class, ['as' => 'admin']);
        Route::get('/mentor/export', [App\Http\Controllers\MentorController::class, 'export'])->name('admin.mentor.export');
        
        // Jadwal Routes
        Route::resource('jadwal', App\Http\Controllers\JadwalController::class, ['as' => 'admin']);
        Route::patch('/jadwal/{id}/status', [App\Http\Controllers\JadwalController::class, 'updateStatus'])->name('admin.jadwal.updateStatus');
        Route::get('/jadwal/export', [App\Http\Controllers\JadwalController::class, 'export'])->name('admin.jadwal.export');
    });
});
