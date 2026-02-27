<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WebsiteController::class, 'index']);
Route::post('/generate', [WebsiteController::class, 'generate']);
Route::post('/generateWithGemini', [WebsiteController::class, 'generateWithGemini']);

// ✅ Component Builder Page
Route::get('/component-builder', function () {
    return view('component-builder');
});

// ✅ API Route (POST only)
Route::post('/generateComponentProject', [ProjectController::class, 'generateComponentProject']);