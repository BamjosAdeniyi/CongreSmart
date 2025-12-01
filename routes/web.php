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
});

require __DIR__.'/auth.php';

// Default dashboard (fallback)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Role-based dashboards
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard/pastor', function () {
        return view('dashboards.pastor');
    })->name('dashboard.pastor');

    Route::get('/dashboard/clerk', function () {
        return view('dashboards.clerk');
    })->name('dashboard.clerk');

    Route::get('/dashboard/superintendent', function () {
        return view('dashboards.superintendent');
    })->name('dashboard.superintendent');

    Route::get('/dashboard/coordinator', function () {
        return view('dashboards.coordinator');
    })->name('dashboard.coordinator');

    Route::get('/dashboard/financial', function () {
        return view('dashboards.financial');
    })->name('dashboard.financial');

    Route::get('/dashboard/welfare', function () {
        return view('dashboards.welfare');
    })->name('dashboard.welfare');

    Route::get('/dashboard/ict', function () {
        return view('dashboards.ict');
    })->name('dashboard.ict');
});
