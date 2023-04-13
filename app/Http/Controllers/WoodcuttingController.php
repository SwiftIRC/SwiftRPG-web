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

    public function chop(): \Illuminate\Http\Response
    {
        try {
            return app(Woodcutting::class)->chop();
        } catch (RangeException $e) {
            return response()->error(['error' => $e->getMessage()], 200);
        }
    }
}
