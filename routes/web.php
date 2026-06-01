<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('domains', \App\Http\Controllers\DomainController::class);
    Route::resource('logs', \App\Http\Controllers\LogController::class);
    Route::get('/domains/{id}/check', [\App\Http\Controllers\DomainController::class, 'check'])
        ->name('domains.check');
});

require __DIR__.'/auth.php';
