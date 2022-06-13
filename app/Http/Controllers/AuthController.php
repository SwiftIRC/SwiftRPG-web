<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function check(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['bail', 'required', 'alpha_dash', 'max:15'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $token = Auth::guard('web')->user()->createToken('bot-managed');

            return response()->json(['token' => $token->plainTextToken]);
        }

        return abort(403);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['bail', 'required', 'unique:users,name', 'alpha_dash', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        Inventory::create([
            'user_id' => $user->id,
            'size' => 5,
            'gold' => 0,
        ]);

        event(new Registered($user));

        return response()->json(compact('user'));
    }
}
