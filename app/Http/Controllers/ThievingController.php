<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;

class ThievingController extends Controller
{
    public function index()
    {
        return view('thieving.index');
    }

    public function pickpocket()
    {
        $user = Auth::user();
        $user->thieving += 5;
        $user->save();

        $gold = Inventory::where('user_id', $user->id)->first();
        $gold->gold += 5;
        $gold->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $gold->gold]);
    }

    public function steal()
    {
        $user = Auth::user();

        $user->thieving += 10;
        $user->save();

        $gold = Inventory::where('user_id', $user->id)->first();
        $gold->gold += 10;
        $gold->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $gold->gold]);
    }

    public function pilfer()
    {
        $user = Auth::user();
        $user->thieving += 50;
        $user->save();

        $gold = Inventory::where('user_id', $user->id)->first();
        $gold->gold += 50;
        $gold->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $gold->gold]);
    }

    public function plunder()
    {
        $user = Auth::user();
        $user->thieving += 100;
        $user->save();

        $gold = Inventory::where('user_id', $user->id)->first();
        $gold->gold += 100;
        $gold->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $gold->gold]);
    }
}
