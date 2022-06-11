<?php

namespace App\Http\Controllers;

use RangeException;
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
        try {
            return response()->json(app(Woodcutting::class)->chop());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
