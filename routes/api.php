<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\RentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.')->middleware(['auth:sanctum'])->group(function () {
    Route::name('car.')->prefix('car')->group(function() {
        Route::get('/', [CarController::class, 'index'])->name('index');
        Route::get('/{id?}', [CarController::class, 'show'])->name('show');
        Route::post('/', [CarController::class, 'store'])->name('store');
        Route::put('/{id?}', [CarController::class, 'update'])->name('update');
        Route::delete('/{id?}', [CarController::class, 'destroy'])->name('destroy');
    });

    Route::name('rent.')->prefix('rent')->group(function() {
        Route::get('/', [RentController::class, 'index'])->name('index');
        Route::get('/{id?}', [RentController::class, 'show'])->name('show');
        Route::post('/', [RentController::class, 'store'])->name('store');
        // Route::put('/{id?}', [RentController::class, 'update'])->name('update');
        // Route::delete('/{id?}', [RentController::class, 'destroy'])->name('destroy');
        Route::post('/calculate', [RentController::class, 'calculate'])->name('calculate');
        Route::put('/return/{rent?}', [RentController::class, 'return_car'])->name('return');
        Route::put('/return_by_plate', [RentController::class, 'return_car_by_plate'])->name('return_plate');
    });
});
