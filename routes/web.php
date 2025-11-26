<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MakePaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Request;

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
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);

    // Make payment
    Route::get('make-payments', [MakePaymentController::class, 'index'])->name('make-payments');
    Route::post('make-payments', [MakePaymentController::class, 'makePayment'])->name('make-payments.store');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Jobs
    Route::resource('jobs', JobController::class);

    // Schedules
    Route::resource('schedules', ScheduleController::class);

    Route::resource('chat-bot', ChatBotController::class);
    Route::get('chat-bot/front', [ChatBotController::class, 'front'])->name('chat-bot.front');

    Route::resource('user', UserController::class);
    Route::get('employers', [UserController::class, 'employerIndex'])->name('employers.index');
    Route::delete('employers/{id}', [UserController::class, 'deleteEmployer'])->name('employers.delete');

    Route::get('job-seekers', [UserController::class, 'jobSeekerIndex'])->name('job-seekers.index');
    Route::delete('job-seekers/{id}', [UserController::class, 'deleteJobSeeker'])->name('job-seekers.delete');

    Route::get('freelancers', [UserController::class, 'freelancerIndex'])->name('freelancers.index');
    Route::delete('freelancers/{id}', [UserController::class, 'deleteFreelancer'])->name('freelancers.delete');

    Route::resource('payments', PaymentController::class);

    Route::resource('applications', ApplicationController::class);

    Route::resource('resume', ResumeController::class);

});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
