<?php

use App\Http\Controllers\AgilityController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\ThievingController;
use App\Models\Client;
use App\Models\Quest;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/help', function () {
    return view('help');
})->name('help');

Route::get('/hiscores', function () {
    $users = User::selectRaw('*, thieving + woodcutting as total')->orderByDesc('total')->get();

    return view('hiscores', compact('users'));
})->name('hiscores');

Route::get('/map', function () {
    return view('map', compact('users'));
})->name('map');

Route::get('/admin', function () {
    return view('admin');
})->middleware(['admin']);

Route::get('/dashboard', function () {
    $user = Auth::user();
    $user->items = $user->items()->get();

    return view('dashboard', compact('user'));
})->middleware(['auth'])->name('dashboard');

Route::get('/api/tiles', function () {
    $tiles = Tile::all();

    foreach ($tiles as $tile) {
        $tile->edges = $tile->edges()->get();
        $tile->terrain = $tile->terrain()->first();
        $tile->npcs = $tile->npcs()->get();
        $tile->users = $tile->users()->get();
        foreach ($tile->edges as $edge) {
            $edge->terrain = $edge->terrain()->first();
        }
    }
    return $tiles;
})->name('api.tiles');
Route::get('/api/tiles/{tile}', function (Tile $tile) {
    $tile->npcs = $tile->npcs()->count();
    $tile->buildings = $tile->buildings()->get();
    $tile->terrain = $tile->terrain()->first();
    $tile->edges = $tile->edges()->get();
    foreach ($tile->edges as $edge) {
        $edge->terrain = $edge->terrain()->first();
    }

    return $tile;
})->name('api.tiles');

Route::get('/look', [AgilityController::class, 'look']);
Route::get('/look/npcs', [AgilityController::class, 'npcs']);
Route::get('/look/buildings', [AgilityController::class, 'buildings']);

Route::name('stats.')->prefix('stats')->group(function () {
    Route::get('/{user}', function ($user) {
        return User::where('name', $user)->first();
    });
});

Route::name('thieving.')->prefix('thieving')->group(function () {
    Route::get('/pickpocket', [ThievingController::class, 'pickpocket']);
});

// The below routes are all for testing and will be removed later

Route::get('quest', function () {
    $user = Auth::user();

    if (empty($user)) {
        return response()->json('log in you fool');
    }

    return response()->json($user->quests()->get());
});

Route::get('quests', function () {
    $quests = Quest::all();

    foreach ($quests as $quest) {
        $quest->steps = $quest->steps()->get();

        foreach ($quest->steps as $step) {
            $step->dependencies = $step->dependencies()->get();
        }
    }

    return response()->json($quests);
});

Route::get('test', function () {
    $endpoints = app(Client::class)->endpoints();

    foreach ($endpoints as $endpoint) {
        post_webhook_endpoint($endpoint, 'foo');
    }

    return response()->json();
});

// Route::get('/quest/start/{quest_id}/{step_id?}', [QuestController::class, 'start']);
Route::get('/quest/inspect/{quest_id}', [QuestController::class, 'inspect']);

require __DIR__ . '/auth.php';
