<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware(['auth','verified'])->group(function() {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    });
    
    Route::resource('schedules', ScheduleController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
