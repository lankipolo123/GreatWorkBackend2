<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::prefix('settings')->group(function () {
    Route::get('profile', fn () => Inertia::render('Settings/Profile'));
    Route::get('password', fn () => Inertia::render('Settings/Password'));
    Route::get('appearance', fn () => Inertia::render('Settings/Appearance'));
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
