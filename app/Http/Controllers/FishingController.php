<?php

namespace App\Http\Controllers;

use App\Skills\Fishing;
use Illuminate\Http\Request;

class FishingController extends Controller
{
    public function fish(Request $request)
    {
        return app(Fishing::class)->fish();
    }
}
