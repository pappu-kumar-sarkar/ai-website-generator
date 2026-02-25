<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WebsiteController::class, 'index']);
Route::post('/generate', [WebsiteController::class, 'generate']);
Route::post('/generateWithGemini', [WebsiteController::class, 'generateWithGemini']);