<?php

use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/admin', function () {
    return view('admin');
})->middleware(['admin']);

Route::get('/dashboard', function () {
    $inventory = Inventory::where('user_id', Auth::id())->first();
    $items = $inventory->distinctItems()->get();
    $rawItems = $inventory->items()->get();
    foreach ($items as $item) {
        $item->effects = $item->effects()->get();
        $item->quantity = count(array_filter($rawItems->all(), function ($rawItem) use ($item) {
            return $rawItem->id === $item->id;
        }));
    }
    $inventory_size = $inventory->size;
    $user = Auth::user();

    return view('dashboard', compact('inventory_size', 'items', 'user'));
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);

//     return response()->json(['token' => $token->plainTextToken]);
// })->middleware(['admin'])->name('token.create');
