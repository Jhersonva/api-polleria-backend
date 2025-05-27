<?php
use App\Http\Controllers\Api\DishCategory\DishCategoryController;
use App\Http\Controllers\Api\Appetizer\AppetizerController;
use Illuminate\Support\Facades\Route;

// API Routes for Appetizer resource
Route::get(('appetizers'), [AppetizerController::class, 'index']);
Route::post(('appetizers'), [AppetizerController::class, 'store']);
Route::get(('appetizers/{id}'), [AppetizerController::class, 'show']);
Route::put(('appetizers/{id}'), [AppetizerController::class, 'update']);
Route::delete(('appetizers/{id}'), [AppetizerController::class, 'destroy']);




Route::get('dish-categories', [DishCategoryController::class, 'index']);
Route::post('dish-categories', [DishCategoryController::class, 'store']);
Route::get('dish-categories/{id}', [DishCategoryController::class, 'show']);
Route::put('dish-categories/{id}', [DishCategoryController::class, 'update']);
Route::delete('dish-categories/{id}', [DishCategoryController::class, 'destroy']);
