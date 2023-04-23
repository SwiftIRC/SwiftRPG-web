<?php

namespace App\Http\Controllers;

use App\Skills\Firemaking;
use Illuminate\Http\Request;

class FiremakingController extends Controller
{
    public function burn(Request $request)
    {
        return app(Firemaking::class)->burn();
    }
}
