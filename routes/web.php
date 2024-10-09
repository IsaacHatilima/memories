<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::patch('/download-recovery-codes', [ProfileController::class, 'copy_recovery_codes'])
        ->name('recovery.codes');
    Route::patch('/clear-two-factor-confirmed-at', [ProfileController::class, 'clear_two_factor_confirmed_at'])
        ->name('clear.2fa.confirmation');

    Route::get('/albums', [AlbumController::class, 'index'])
        ->name('albums.index');
    Route::get('/albums/archived', [AlbumController::class, 'trashed'])
        ->name('albums.trashed');
    Route::post('/albums', [AlbumController::class, 'store'])
        ->name('albums.store');
    Route::delete('/albums/delete/{album}', [AlbumController::class, 'destroy'])
        ->name('albums.destroy');
    Route::patch('/albums/archive/{album}', [AlbumController::class, 'archive'])
        ->name('albums.archive');
    Route::patch('/albums/restore/{album}', [AlbumController::class, 'restore'])
        ->name('albums.restore');
    Route::patch('/albums/{album}', [AlbumController::class, 'update'])
        ->name('albums.update');
});

require __DIR__.'/auth.php';
