<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FrontController::class, 'welcome'])->name('home');

Route::get('companies', [FrontController::class, 'companies'])->name('companies');
Route::get('partner-networks', [FrontController::class, 'partnerNetworks'])->name('partner-networks');
Route::get('career-resources', [FrontController::class, 'careerResources'])->name('career-resources');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    });

    Route::resource('categories', CategoryController::class);

    Route::resource('schedules', ScheduleController::class);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
