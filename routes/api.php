<?php

use App\Http\Controllers\Api\PageContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API Routes for Next.js
Route::get('/pages', [PageContentController::class, 'index']);
Route::get('/pages/{slug}', [PageContentController::class, 'show']);

// Resources Routes
Route::get('/student-groups', [\App\Http\Controllers\Api\ResourcesController::class, 'getStudentGroups']);
Route::get('/events', [\App\Http\Controllers\Api\ResourcesController::class, 'getEvents']);
Route::get('/research-groups', [\App\Http\Controllers\Api\ResourcesController::class, 'getResearchGroups']);
