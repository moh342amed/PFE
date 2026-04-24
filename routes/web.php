<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $events = Event::latest()->get();
    return view('landing', compact('events'));
})->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Applications
    Route::get('/my-applications', [RegistrationController::class, 'index'])->name('my.applications');
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Events
    Route::get('events/{event}/export', [\App\Http\Controllers\Admin\RegistrationController::class, 'export'])->name('events.export');
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    
    // Registrations
    Route::resource('registrations', \App\Http\Controllers\Admin\RegistrationController::class)->only(['index', 'update']);
    
    // Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'destroy']);
});

require __DIR__.'/auth.php';
