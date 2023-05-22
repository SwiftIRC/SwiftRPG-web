<?php

namespace App\Http\Controllers;

use App\Skills\Smithing;
use Illuminate\Http\Request;

class SmithingController extends Controller
{
    public function reinforce(Request $request)
    {
        return app(Smithing::class)->reinforce();
    }

    public function smelt(Request $request)
    {
        return app(Smithing::class)->smelt();
    }

    public function smith(Request $request)
    {
        return app(Smithing::class)->smith();
    }
}
