<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['bail', 'required', 'max:255'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return response("");
        }

        return abort(403);
    }
}
