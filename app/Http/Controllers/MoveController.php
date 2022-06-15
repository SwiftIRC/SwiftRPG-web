<?php

namespace App\Http\Controllers;

use App\Map\Move;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoveController extends Controller
{
    public function move(Request $request)
    {
        return app(Move::class)->move(Auth::user(), $request->direction);
    }

    public function look(Request $request)
    {
        return app(Move::class)->look(Auth::user());
    }
}
