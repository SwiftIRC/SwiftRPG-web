<?php

namespace App\Http\Controllers;

use App\Skills\Cooking;
use Illuminate\Http\Request;

class CookingController extends Controller
{
    public function cook(Request $request)
    {
        return app(Cooking::class)->cook();
    }
}
