<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->post('/auth', function(Request $request) {
    $credentials = $request->validate([
        'name' => ['bail', 'required', 'max:255'],
        'password' => ['required'],
    ]);

    if (Auth::guard('web')->attempt($credentials)) {
        return;
    }

    return abort(403);
})->name('auth.check');

Route::middleware(['auth:sanctum'])->get('/auth', function(Request $request) {
    return response()->json(['user' => $request->user()]);
});
