<?php

use App\Models\Npc;
use App\Models\Edge;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoveController;
use App\Http\Controllers\ThievingController;
use App\Http\Controllers\FiremakingController;
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

Route::middleware(['auth:sanctum'])->group(function () {
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
    Route::name('firemaking.')->prefix('firemaking')->group(function () {
        Route::get('/', [FiremakingController::class, 'index']);
        Route::post('/burn', [FiremakingController::class, 'burn']);
    });
    Route::name('stats.')->prefix('stats')->group(function () {
        Route::get('/', function () {
            return Auth::user();
        });
        Route::get('/{user}', function ($user) {
            return User::where('name', $user)->first();
        });
    });
    Route::name('map.')->prefix('map')->group(function () {
        Route::name('tile.')->prefix('tile')->group(function () {
            Route::get('/{x}/{y}', function ($x, $y) {
                return Tile::where('x', $x)->where('y', $y)->first();
            });
            Route::get('/{x}/{y}/edges', function ($x, $y) {
                return Tile::where('x', $x)->where('y', $y)->first()->edges()->get();
            });
        });
        Route::name('user.')->prefix('user')->group(function () {
            Route::name('look.')->prefix('look')->group(function () {
                Route::get('/', [MoveController::class, 'look']);
                Route::get('/npcs', [MoveController::class, 'npcs']);
                Route::get('/buildings', [MoveController::class, 'buildings']);
            });
            Route::post('/move', [MoveController::class, 'move']);
            Route::get('/{user}', function ($user) {
                return response()->json(User::where('name', $user)->first()->tile());
            });
        });
    });
    Route::name('npc.')->prefix('npc')->group(function () {
        Route::get('/{npc}', function ($npc) {
            return Npc::id($npc)->first();
        });
    });
});
