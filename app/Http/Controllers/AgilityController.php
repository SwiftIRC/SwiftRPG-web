<?php

namespace App\Http\Controllers;

use App\Skills\Agility;
use Illuminate\Http\Request;
use RangeException;

class AgilityController extends Controller
{
    public function explore(Request $request)
    {
        try {
            return app(Agility::class)->explore($request->direction);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function look(Request $request)
    {
        try {
            return app(Agility::class)->look([$request->direction]);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function npcs()
    {
        return app(Agility::class)->npcs();
    }

    public function buildings()
    {
        return app(Agility::class)->buildings();
    }

}
