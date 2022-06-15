<?php

namespace App\Http\Controllers;

use App\Map\Move;
use App\Models\Edge;
use App\Models\Tile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoveController extends Controller
{
    public function move(Request $request)
    {
        return app(Move::class)->move(Auth::user(), $request->direction);
    }
}
