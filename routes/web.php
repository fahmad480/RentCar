<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\RentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { // ceritanya bisa jadi landingpage
    return redirect()->route('dashboard');
});

Route::get('/home', function () { // ceritanya bisa jadi landingpage
    return redirect()->route('dashboard');
});

Route::middleware(['guest'])->group(function () {
    Route::prefix('/signin')->controller(AuthController::class)->name('auth.')->group(function () {
        Route::get('/', 'signin')->name('signin');
        Route::post('/', 'signin_action')->name('signin_action');
    });
    Route::prefix('/signup')->controller(AuthController::class)->name('auth.')->group(function () {
        Route::get('/', 'signup')->name('signup');
        Route::post('/', 'signup_action')->name('signup_action');
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/signout', [AuthController::class, 'signout'])->name('auth.signout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/car')->controller(CarController::class)->name('car.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'add')->name('store');
        Route::get('/update/{car?}', 'update')->name('update');
        Route::get('/delete/{car?}', 'delete')->name('delete');
    });
    
    Route::prefix('/rent')->controller(RentController::class)->name('rent.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'add')->name('store');
        // Route::get('/update/{rent?}', 'update')->name('update');
        Route::get('/delete/{rent?}', 'delete')->name('delete');
        Route::get('/return', 'return')->name('return');
    });
});