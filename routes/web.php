<?php

use App\Http\Controllers\AgilityController;
use App\Http\Controllers\ThievingController;
use App\Models\Terrain;
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
})->name('index');

Route::get('/help', function () {
    return view('help');
})->name('help')->middleware(['auth']);

Route::get('/hiscores', function () {
    $users = User::with(['skills' => function ($query) {
        return $query->orderBy('pivot_quantity', 'desc');
    }])->get();

    dd($users);

    return view('hiscores', compact('users'));
})->name('hiscores')->middleware(['auth']);

Route::get('/usermap', function () {
    return view('map');
})->name('usermap')->middleware(['auth']);

Route::get('/map', function () {
    return view('mapguest');
})->name('mapguest');

Route::get('/user', function () {
    return view('user');
})->middleware(['auth'])->name('user');

Route::get('/admin', function () {
    return view('admin');
})->middleware(['admin'])->name('admin');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $user->items = $user->items()->get();

    return view('dashboard', compact('user'));
})->middleware(['auth'])->name('dashboard');

Route::get('/api/tiles', function () {
    $tiles = Tile::all();
    $is_admin = false;

    if (Auth::check()) {
        $is_admin = Auth::user()->getAttributes('is_admin');
    }

    $tiles->each(function ($tile) use ($is_admin) {
        $tile->terrain = $tile->terrain()->first();
        if ($tile->discovered_by !== null || $tile->terrain->name == 'Water' || $is_admin) {
            $tile->edges = $tile->edges()->get()->each(function ($edge) {
                $edge->terrain = $edge->terrain()->first();
            });
            $tile->npcs = $tile->npcs()->get();
            $tile->users = $tile->users()->whereNull('building_id')->get();
            $tile->buildings = $tile->buildings()->get()->each(function ($building) {
                $building->npcs = $building->npcs()->count();
                $building->users = $building->users()->get();
            });
        } else {
            $tile->terrain = [
                'id' => 0,
                'name' => 'Fog',
                'description' => 'You cannot see what is hidden in the fog.',
                'movement_cost' => 0,
            ];
            $tile->edges = $tile->edges()->get()->each(function ($edge) use ($tile) {
                $edge->terrain = $tile->terrain;
                $edge->pivot->is_road = false;
            });
            $tile->npcs = [];
            $tile->users = [];
            $tile->buildings = [];
            $tile->max_trees = 0;
            $tile->available_trees = 0;
        }
    });

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
    })->name('lookup');
});

Route::name('thieving.')->prefix('thieving')->group(function () {
    Route::get('/pickpocket', [ThievingController::class, 'pickpocket']);
});

require __DIR__ . '/auth.php';
