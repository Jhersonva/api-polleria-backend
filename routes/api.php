<?php

use App\Http\Controllers\Api\Appetizer\AppetizerController;
use Illuminate\Support\Facades\Route;

// API Routes for Appetizer resource
Route::get(('appetizers'), [AppetizerController::class, 'index']);
Route::post(('appetizers'), [AppetizerController::class, 'store']);
Route::get(('appetizers/{id}'), [AppetizerController::class, 'show']);
Route::put(('appetizers/{id}'), [AppetizerController::class, 'update']);
Route::delete(('appetizers/{id}'), [AppetizerController::class, 'destroy']);
