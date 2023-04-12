<?php

namespace App\Http\Controllers;

use App\Skills\Woodcutting;
use RangeException;

class WoodcuttingController extends Controller
{
    public function index()
    {
        return view('woodcutting.index');
    }

    public function chop(): \Illuminate\Http\JsonResponse
    {
        try {
            return app(Woodcutting::class)->chop();
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
}
