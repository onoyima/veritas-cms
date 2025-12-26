<?php

use App\Http\Controllers\Api\PageContentController;
use App\Http\Controllers\Api\ResourcesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API Routes for Next.js
Route::get('/pages', [PageContentController::class, 'index']);
Route::get('/pages/{slug}', [PageContentController::class, 'show']);

// Resources Routes
Route::get('/news', [ResourcesController::class, 'getNews']);
Route::get('/news/{slug}', [ResourcesController::class, 'showNews']);
Route::get('/student-groups', [ResourcesController::class, 'getStudentGroups']);
Route::get('/events', [ResourcesController::class, 'getEvents']);
Route::get('/research-groups', [ResourcesController::class, 'getResearchGroups']);
Route::get('/management', [ResourcesController::class, 'getManagement']);
Route::get('/management/{slug}', [ResourcesController::class, 'getPersonnel']);
Route::get('/programs', [ResourcesController::class, 'getPrograms']);
Route::get('/programs/{slug}', [ResourcesController::class, 'getProgram']);
Route::get('/faqs', [ResourcesController::class, 'getFaqs']);
