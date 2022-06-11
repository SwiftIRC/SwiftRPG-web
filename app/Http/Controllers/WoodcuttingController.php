<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\CommandLog;
use App\Skills\Woodcutting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WoodcuttingController extends Controller
{
    public function index()
    {
        return view('woodcutting.index');
    }

    public function chop()
    {
        return response()->json(app(Woodcutting::class)->chop());
    }
}
