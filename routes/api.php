<?php

use App\Http\Controllers\AgilityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FiremakingController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\ThievingController;
use App\Http\Controllers\WoodcuttingController;
use App\Models\Npc;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['app'])->name('client.')->prefix('client')->group(function () {
    Route::post('/register', [ClientController::class, 'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::name('auth.')->prefix('auth')->group(function () {
        Route::get('/token', [AuthController::class, 'token'])->name('token');

        Route::middleware('auth:sanctum', 'abilities:login')->group(function () {
            Route::name('token.')->prefix('token')->group(function () {
                Route::get('login', [AuthController::class, 'login'])->name('login');
            });
        });
    });

    Route::name('thieving.')->prefix('thieving')->group(function () {
        Route::get('/', [ThievingController::class, 'index'])->name('index');
        Route::post('/pickpocket', [ThievingController::class, 'pickpocket'])->name('pickpocket');
        Route::post('/steal', [ThievingController::class, 'steal'])->name('steal');
        Route::post('/pilfer', [ThievingController::class, 'pilfer'])->name('pilfer');
        Route::post('/plunder', [ThievingController::class, 'plunder'])->name('plunder');
    });
    Route::name('woodcutting.')->prefix('woodcutting')->group(function () {
        Route::get('/', [WoodcuttingController::class, 'index'])->name('index');
        Route::post('/chop', [WoodcuttingController::class, 'chop'])->name('chop');
    });
    Route::name('firemaking.')->prefix('firemaking')->group(function () {
        Route::get('/', [FiremakingController::class, 'index'])->name('index');
        Route::post('/burn', [FiremakingController::class, 'burn'])->name('burn');
    });
    Route::name('stats.')->prefix('stats')->group(function () {
        Route::get('/', function () {
            return Auth::user();
        })->name('index');
        Route::get('/{user}', function ($user) {
            return User::where('name', $user)->first();
        })->name('user');
    });
    Route::name('map.')->prefix('map')->group(function () {
        Route::name('tile.')->prefix('tile')->group(function () {
            Route::get('/{x}/{y}', function ($x, $y) {
                return Tile::where('x', $x)->where('y', $y)->first();
            })->name('lookup');
            Route::get('/{x}/{y}/edges', function ($x, $y) {
                return Tile::where('x', $x)->where('y', $y)->first()->edges()->get();
            })->name('edges');
        });
        Route::name('user.')->prefix('user')->group(function () {
            Route::name('look.')->prefix('look')->group(function () {
                Route::get('/', [AgilityController::class, 'look'])->name('look');
                Route::get('/npcs', [AgilityController::class, 'npcs'])->name('npcs');
                Route::get('/buildings', [AgilityController::class, 'buildings'])->name('buildings');
                Route::get('/{direction}', [AgilityController::class, 'look'])->name('look');
            });
            Route::post('/explore', [AgilityController::class, 'explore'])->name('explore');
            Route::get('/{user}', function ($user) {
                return response()->json(User::where('name', $user)->first()->tile());
            })->name('lookup');
        });
    });
    Route::name('npc.')->prefix('npc')->group(function () {
        Route::get('/{npc}', function ($npc) {
            return Npc::id($npc)->first();
        })->name('lookup');
    });
    Route::name('quests.')->prefix('quests')->group(function () {
        Route::get('/', [QuestController::class, 'list'])->name('list');
        Route::get('/start/{quest_id}/{step_id?}', [QuestController::class, 'start'])->name('start');
        Route::get('/inspect/{quest_id}', [QuestController::class, 'inspect'])->name('inspect');
    });
    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::post('/', [EventController::class, 'engage'])->name('engage');
    });
});
