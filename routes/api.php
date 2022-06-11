<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ThievingController;
use App\Http\Controllers\WoodcuttingController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['app'])->name('auth.')->prefix('auth')->group(function () {
    Route::post('/', [AuthController::class, 'check']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth:sanctum', 'app'])->group(function () {
    Route::name('thieving.')->prefix('thieving')->group(function () {
        Route::get('/', [ThievingController::class, 'index']);
        Route::post('/pickpocket', [ThievingController::class, 'pickpocket']);
        Route::post('/steal', [ThievingController::class, 'steal']);
        Route::post('/pilfer', [ThievingController::class, 'pilfer']);
        Route::post('/plunder', [ThievingController::class, 'plunder']);
    });
    Route::name('woodcutting.')->prefix('woodcutting')->group(function () {
        Route::get('/', [WoodcuttingController::class, 'index']);
        Route::post('/chop', [WoodcuttingController::class, 'chop']);
    });
});
