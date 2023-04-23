<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Generate a token for the user to use when
     * logging into a client (e.g. Discord or IRC bot)
     */
    public function token(Request $request): JsonResponse
    {
        $token = $request->user()->createToken('client-auth', ['login']);

        return response()->json(['token' => $token->plainTextToken]);
    }

    /**
     * Log the user into a client (e.g. Discord or IRC bot)
     * without passing a username/password plain-text
     * in a chat application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        $token = $request->user()->createToken('bot-managed');

        return response()->json(['token' => $token->plainTextToken, 'name' => $request->user()->name]);
    }

}
