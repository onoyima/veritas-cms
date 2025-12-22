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
use App\Http\Controllers\Dashboard\NewsController;
use App\Http\Controllers\Dashboard\EventsController;
use App\Http\Controllers\Dashboard\PersonnelController;
use App\Http\Controllers\Dashboard\StudentGroupsController;
use App\Http\Controllers\Dashboard\CoursesController;
use App\Http\Controllers\Dashboard\ProgramsController;
use App\Http\Controllers\Dashboard\FaqController;
use App\Http\Controllers\Dashboard\AZEntriesController;
use App\Http\Controllers\Dashboard\MassSchedulesController;
use App\Http\Controllers\Dashboard\PublicationsController;
use App\Http\Controllers\Dashboard\ResearchGroupsController;
use App\Http\Controllers\Dashboard\WebsiteRoleController;
use App\Http\Controllers\Dashboard\HelpController;

// Admin / CMS Routes (Protected by Staff Auth & CMS Access)
Route::middleware(['auth:staff', 'cms.auth'])->prefix('admin')->name('admin.')->group(function () {
    // Website Role Management
    Route::get('website-roles/search', [WebsiteRoleController::class, 'searchStaff'])->name('website-roles.search');
    Route::get('website-roles', [WebsiteRoleController::class, 'index'])->name('website-roles.index');
    Route::post('website-roles', [WebsiteRoleController::class, 'store'])->name('website-roles.store');
    Route::delete('website-roles/{staff}/{role}', [WebsiteRoleController::class, 'destroy'])->name('website-roles.destroy');

    Route::patch('pages/{page}/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');
    Route::resource('pages', PageController::class);
    Route::patch('blocks/{block}/toggle-status', [ContentBlockController::class, 'toggleStatus'])->name('blocks.toggle-status');
    Route::resource('pages.blocks', ContentBlockController::class)->shallow();

    // News Management
    Route::resource('news', NewsController::class);
    // Events Management
    Route::resource('events', EventsController::class);
    // Personnel Management
    Route::resource('personnel', PersonnelController::class);
    // Student Groups Management
    Route::resource('student-groups', StudentGroupsController::class);
    // Courses Management
    Route::resource('courses', CoursesController::class);
    // Programs Management
    Route::resource('programs', ProgramsController::class);
    // FAQ Management
    Route::resource('faqs', FaqController::class);
    // A-Z Entries Management
    Route::resource('az-entries', AZEntriesController::class);
    // Mass Schedules Management
    Route::resource('mass-schedules', MassSchedulesController::class);
    // Publications Management
    Route::resource('publications', PublicationsController::class);
    // Research Groups Management
    Route::resource('research-groups', ResearchGroupsController::class);
});

// Staff Authentication Routes
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('login', [StaffLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [StaffLoginController::class, 'login']);
    Route::post('logout', [StaffLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:staff')->group(function () {
        Route::get('dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [StaffDashboardController::class, 'profile'])->name('profile');
        Route::get('help', [HelpController::class, 'index'])->name('help');
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
