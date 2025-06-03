<?php
use App\Http\Controllers\Api\DishCategory\DishCategoryController;
use App\Http\Controllers\Api\Appetizer\AppetizerController;
use App\Http\Controllers\Api\Dish\DishController;
use App\Http\Controllers\Api\Drink\DrinkController;
use Illuminate\Support\Facades\Route;

// API Routes for Appetizer resource
Route::get(('appetizers'), [AppetizerController::class, 'index']);
Route::post(('appetizers'), [AppetizerController::class, 'store']);
Route::get(('appetizers/{id}'), [AppetizerController::class, 'show']);
Route::put(('appetizers/{id}'), [AppetizerController::class, 'update']);
Route::delete(('appetizers/{id}'), [AppetizerController::class, 'destroy']);

// API Routes for DishCategory resource
Route::get('dish-categories', [DishCategoryController::class, 'index']);
Route::post('dish-categories', [DishCategoryController::class, 'store']);
Route::get('dish-categories/{id}', [DishCategoryController::class, 'show']);
Route::put('dish-categories/{id}', [DishCategoryController::class, 'update']);
Route::delete('dish-categories/{id}', [DishCategoryController::class, 'destroy']);

// API Routes for Dish resource
Route::get('dish', [DishController::class, 'index']);
Route::post('dish', [DishController::class, 'store']);
Route::get('dish/{id}', [DishController::class, 'show']);
Route::put('dish/{id}', [DishController::class, 'update']);
Route::delete('dish/{id}', [DishController::class, 'destroy']);

// API Routes for Drink resource
Route::get('drinks', [DrinkController::class, 'index']);
Route::post('drinks', [DrinkController::class, 'store']);
Route::get('drinks/{id}', [DrinkController::class, 'show']);
Route::put('drinks/{id}', [DrinkController::class, 'update']);
Route::delete('drinks/{id}', [DrinkController::class, 'destroy']);
