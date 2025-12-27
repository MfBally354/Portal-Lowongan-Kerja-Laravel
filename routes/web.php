<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('jobs.index');
});

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobListing}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Company routes (for employers)
    Route::resource('companies', CompanyController::class)->only(['create', 'store', 'edit', 'update']);

    // Job routes
    Route::resource('jobs', JobController::class)->except(['index', 'show']);

    // Application routes
    Route::post('/jobs/{jobListing}/apply', [JobApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{application}', [JobApplicationController::class, 'show'])->name('applications.show');
    Route::patch('/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
});

require __DIR__.'/auth.php';
