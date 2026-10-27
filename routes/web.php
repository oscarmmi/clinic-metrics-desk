<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PractitionerController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('practitioners', [PractitionerController::class, 'index'])->name('practitioners.index');
    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
});

require __DIR__.'/settings.php';
