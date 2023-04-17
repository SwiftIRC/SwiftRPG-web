<?php

namespace App\Http\Controllers;

use App\Skills\Woodcutting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RangeException;

class WoodcuttingController extends Controller
{
    public function index()
    {
        return view('woodcutting.index');
    }

    public function chop(Request $request): Response
    {
        try {
            return app(Woodcutting::class)->chop($request);
        } catch (RangeException $e) {
            return response()->error(['error' => $e->getMessage()], 200);
        }
    }
}
