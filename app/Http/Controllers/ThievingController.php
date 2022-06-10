<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThievingController extends Controller
{
    public function index()
    {
        return view('thieving.index');
    }

    public function pickpocket()
    {
        return response()->json(['message' => 'Pickpocketing is not yet implemented.']);
    }
}
