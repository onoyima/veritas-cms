<?php

use App\Http\Controllers\Auth\StaffLoginController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Dashboard\StaffDashboardController;
use App\Http\Controllers\Dashboard\StudentDashboardController;
use App\Http\Controllers\Dashboard\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('staff.login');
});

use App\Http\Controllers\Dashboard\ContentBlockController;

// Admin / CMS Routes (Protected by Staff Auth & CMS Access)
Route::middleware(['auth:staff', 'cms.auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::patch('pages/{page}/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');
    Route::resource('pages', PageController::class);
    Route::patch('blocks/{block}/toggle-status', [ContentBlockController::class, 'toggleStatus'])->name('blocks.toggle-status');
    Route::resource('pages.blocks', ContentBlockController::class)->shallow();
});

// Staff Authentication Routes
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('login', [StaffLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [StaffLoginController::class, 'login']);
    Route::post('logout', [StaffLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:staff')->group(function () {
        Route::get('dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [StaffDashboardController::class, 'profile'])->name('profile');
    });
});

// Student Authentication Routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('login', [StudentLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [StudentLoginController::class, 'login']);
    Route::post('logout', [StudentLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:student')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [StudentDashboardController::class, 'profile'])->name('profile');
    });
});
