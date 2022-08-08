<?php

use App\Models\Tile;
use App\Models\User;
use App\Map\Regenerate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoveController;
use App\Http\Controllers\ThievingController;

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
    return view('hiscores', compact('users'));
})->name('hiscores');

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

Route::get('/look', [MoveController::class, 'look']);
Route::get('/look/npcs', [MoveController::class, 'npcs']);
Route::get('/look/buildings', [MoveController::class, 'buildings']);

Route::name('stats.')->prefix('stats')->group(function () {
    Route::get('/{user}', function ($user) {
        return User::where('name', $user)->first();
    });
});

Route::name('thieving.')->prefix('thieving')->group(function () {
    Route::get('/pickpocket', [ThievingController::class, 'pickpocket']);
});

Route::get('test', function () {
    return response()->json(['response' => app(Regenerate::class)->map()]);
});

require __DIR__ . '/auth.php';
