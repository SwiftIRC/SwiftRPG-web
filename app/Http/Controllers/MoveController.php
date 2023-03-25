<?php

namespace App\Http\Controllers;

use App\Map\Move;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    public function move(Request $request)
    {
        return app(Move::class)->move($request->user(), $request->direction);
    }

    public function look(Request $request)
    {
        return app(Move::class)->look($request->user());
    }

    public function npcs(Request $request)
    {
        return app(Move::class)->npcs($request->user());
    }

    public function buildings(Request $request)
    {
        return app(Move::class)->buildings($request->user());
    }
}
