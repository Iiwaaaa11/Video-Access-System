<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoRequestController;
use App\Http\Controllers\AdminVideoRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// ROUTE ADMIN
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Videos CRUD
    Route::resource('videos', VideoController::class);
    
    // Video Requests Management
    Route::get('/requests', [AdminVideoRequestController::class, 'index'])->name('requests.index');
    Route::post('/requests/{videoRequest}/approve', [AdminVideoRequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{videoRequest}/reject', [AdminVideoRequestController::class, 'reject'])->name('requests.reject');
    Route::delete('/access/{videoAccess}/revoke', [AdminVideoRequestController::class, 'revokeAccess'])->name('access.revoke');
});

// Routes untuk Customer Video Access
Route::middleware(['auth'])->prefix('customer')->name('video.')->group(function () {
    Route::get('/videos', [VideoRequestController::class, 'catalog'])->name('catalog');
    Route::post('/videos/{video}/request', [VideoRequestController::class, 'requestAccess'])->name('request.access');
    Route::get('/videos/{video}/watch', [VideoRequestController::class, 'watch'])->name('watch');
    Route::post('/videos/{video}/request-again', [VideoRequestController::class, 'requestAgain'])->name('request.again');
});