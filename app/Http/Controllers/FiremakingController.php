<?php

namespace App\Http\Controllers;

use App\Skills\Firemaking;
use RangeException;

class FiremakingController extends Controller
{
    public function burn()
    {
        try {
            return app(Firemaking::class)->burn();
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
