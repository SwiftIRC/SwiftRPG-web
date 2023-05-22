<?php

namespace App\Http\Controllers;

use App\Skills\Mining;
use Illuminate\Http\Request;

class MiningController extends Controller
{
    public function mine(Request $request)
    {
        return app(Mining::class)->mine();
    }
}
