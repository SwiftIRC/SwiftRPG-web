<?php

namespace App\Http\Controllers;

use RangeException;
use App\Skills\Thieving;
use App\Models\Inventory;
use App\Models\CommandLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThievingController extends Controller
{
    public function index()
    {
        return view('thieving.index');
    }

    public function pickpocket()
    {
        try {
            return response()->json(app(Thieving::class)->pickpocket());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function steal()
    {
        try {
            if (Auth::user()->thieving < level_to_xp(10)) { # Level 10
                return response()->json(['error' => 'You need to be level 10 to steal.'], 403);
            }

            return response()->json(app(Thieving::class)->steal());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function pilfer()
    {
        $last_run = CommandLog::where('user_id', Auth::id())->where('command', 'pilfer')->where('created_at', '>=', now()->subMinutes(1))->get()->count();
        if ($last_run > 0) {
            return response()->json(['error' => 'You can only run this command once every minute.'], 403);
        }

        $user = Auth::user();

        if ($user->thieving < 80020) { # Level 20
            return response()->json(['error' => 'You need to be level 20 to pilfer.'], 403);
        }

        $user->thieving += 50;
        $user->save();

        $gold = Inventory::where('user_id', $user->id)->first();
        $gold->gold += 50;
        $gold->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $gold->gold]);
    }

    public function plunder()
    {
        $last_run = CommandLog::where('user_id', Auth::id())->where('command', 'plunder')->where('created_at', '>=', now()->subMinutes(1))->get()->count();
        if ($last_run > 0) {
            return response()->json(['error' => 'You can only run this command once every minute.'], 403);
        }

        $user = Auth::user();

        if ($user->thieving < 270030) { # Level 30
            return response()->json(['error' => 'You need to be level 30 to plunder.'], 403);
        }

        $user->thieving += 100;
        $user->save();

        $gold = Inventory::where('user_id', $user->id)->first();
        $gold->gold += 100;
        $gold->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $gold->gold]);
    }
}
