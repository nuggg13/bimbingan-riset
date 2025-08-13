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
    return view('welcome');
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
        Route::patch('/pendaftaran/{pendaftaran}/status', [App\Http\Controllers\PendaftaranController::class, 'updateStatus'])->name('admin.pendaftaran.updateStatus');
        Route::get('/pendaftaran/export', [App\Http\Controllers\PendaftaranController::class, 'export'])->name('admin.pendaftaran.export');
        
        // Mentor Routes
        Route::resource('mentor', App\Http\Controllers\MentorController::class, ['as' => 'admin']);
        Route::get('/mentor/export', [App\Http\Controllers\MentorController::class, 'export'])->name('admin.mentor.export');
    });
});
