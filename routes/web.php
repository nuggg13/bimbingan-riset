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
        Route::get('/profile/edit', [App\Http\Controllers\PesertaDashboardController::class, 'editProfile'])->name('peserta.profile.edit');
        Route::put('/profile/update', [App\Http\Controllers\PesertaDashboardController::class, 'updateProfile'])->name('peserta.profile.update');
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
        
        // Catatan Bimbingan Routes
        Route::resource('catatan-bimbingan', App\Http\Controllers\CatatanBimbinganController::class, ['as' => 'admin']);
        Route::get('/catatan-bimbingan/export', [App\Http\Controllers\CatatanBimbinganController::class, 'export'])->name('admin.catatan-bimbingan.export');
        Route::post('/catatan-bimbingan/{id}/progress', [App\Http\Controllers\CatatanBimbinganController::class, 'addProgress'])->name('admin.catatan-bimbingan.addProgress');
        Route::put('/catatan-bimbingan/{catatanId}/progress/{progressId}', [App\Http\Controllers\CatatanBimbinganController::class, 'updateProgress'])->name('admin.catatan-bimbingan.updateProgress');
        Route::delete('/catatan-bimbingan/{catatanId}/progress/{progressId}', [App\Http\Controllers\CatatanBimbinganController::class, 'deleteProgress'])->name('admin.catatan-bimbingan.deleteProgress');
    });
});

// Mentor Routes
Route::prefix('mentor')->group(function () {
    Route::get('/login', [App\Http\Controllers\MentorAuthController::class, 'showLoginForm'])->name('mentor.login');
    Route::post('/login', [App\Http\Controllers\MentorAuthController::class, 'login'])->name('mentor.login.process');
    Route::post('/logout', [App\Http\Controllers\MentorAuthController::class, 'logout'])->name('mentor.logout');
    
    // Protected mentor routes
    Route::middleware('mentor')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\MentorDashboardController::class, 'dashboard'])->name('mentor.dashboard');
        Route::get('/participants', [App\Http\Controllers\MentorDashboardController::class, 'participants'])->name('mentor.participants');
        Route::get('/participants/{id}', [App\Http\Controllers\MentorDashboardController::class, 'participantDetail'])->name('mentor.participants.detail');
        Route::get('/schedules', [App\Http\Controllers\MentorDashboardController::class, 'schedules'])->name('mentor.schedules');
        
        // Catatan Bimbingan Routes for Mentor
        Route::resource('catatan-bimbingan', App\Http\Controllers\MentorCatatanBimbinganController::class, ['as' => 'mentor']);
        Route::get('/catatan-bimbingan/export', [App\Http\Controllers\MentorCatatanBimbinganController::class, 'export'])->name('mentor.catatan-bimbingan.export');
        Route::post('/catatan-bimbingan/{id}/progress', [App\Http\Controllers\MentorCatatanBimbinganController::class, 'addProgress'])->name('mentor.catatan-bimbingan.addProgress');
        Route::put('/catatan-bimbingan/{catatanId}/progress/{progressId}', [App\Http\Controllers\MentorCatatanBimbinganController::class, 'updateProgress'])->name('mentor.catatan-bimbingan.updateProgress');
        Route::delete('/catatan-bimbingan/{catatanId}/progress/{progressId}', [App\Http\Controllers\MentorCatatanBimbinganController::class, 'deleteProgress'])->name('mentor.catatan-bimbingan.deleteProgress');
    });
});