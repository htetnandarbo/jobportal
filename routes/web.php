<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
Route::prefix('admin')->middleware(['auth','verified'])->group(function() {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    });

    Route::resource('categories', CategoryController::class);
    
    Route::resource('schedules', ScheduleController::class);

    Route::resource('chat-bot', ChatBotController::class);

    Route::resource('user', UserController::class);
    Route::get('employers', [UserController::class, 'employerIndex'])->name('employers.index');
    Route::delete('employers/{id}', [UserController::class, 'deleteEmployer'])->name('employers.delete');

    Route::get('job-seekers', [UserController::class, 'jobSeekerIndex'])->name('job-seekers.index');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
