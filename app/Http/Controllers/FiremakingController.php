<?php

namespace App\Http\Controllers;

use App\Skills\Firemaking;
use Illuminate\Http\Request;

class FiremakingController extends Controller
{
    public function burn()
    {
        try {
            return response()->json(app(Firemaking::class)->burn());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
