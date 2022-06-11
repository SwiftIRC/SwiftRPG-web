<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Inventory;
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
        $user = Auth::user();
        $user->woodcutting += 5;
        $user->save();

        $inventory = Inventory::where('user_id', $user->id)->first();

        $item = Item::where('name', 'Logs')->first();
        $inventory->items()->attach($item);

        $logs = count($inventory->items()->where('name', 'Logs')->get()->all());

        return response()->json(['woodcutting' => $user->woodcutting, 'logs' => $logs]);
    }
}
