<?php

namespace App\Http\Controllers;

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
        $last_run = CommandLog::where('user_id', Auth::id())->where('command', 'pickpocket')->where('created_at', '>=', now()->subMinutes(1))->get()->count();
        if ($last_run > 0) {
            return response()->json(['error' => 'You can only run this command once every minute.'], 403);
        }

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
        $last_run = CommandLog::where('user_id', Auth::id())->where('command', 'steal')->where('created_at', '>=', now()->subMinutes(1))->get()->count();
        if ($last_run > 0) {
            return response()->json(['error' => 'You can only run this command once every minute.'], 403);
        }

        $user = Auth::user();

        if ($user->thieving < 10010) { # Level 10
            return response()->json(['error' => 'You need to be level 10 to steal.'], 403);
        }

        $user->thieving += 10;
        $user->save();

        $gold = Inventory::where('user_id', $user->id)->first();
        $gold->gold += 10;
        $gold->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $gold->gold]);
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
