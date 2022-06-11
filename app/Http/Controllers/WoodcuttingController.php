<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\CommandLog;
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
        $last_run = CommandLog::where('user_id', Auth::id())->where('command', 'chop')->where('created_at', '>=', now()->subMinutes(1))->get()->count();
        if ($last_run > 0) {
            return response()->json(['error' => 'You can only run this command once every minute.'], 403);
        }

        $user = Auth::user();
        $user->woodcutting += 5;
        $user->save();

        $inventory = Inventory::where('user_id', $user->id)->first();

        $item = Item::where('name', 'Logs')->first();
        $inventory->items()->attach($item);

        $logs = count($inventory->items()->where('name', 'Logs')->get()->all());

        $output = ['woodcutting' => $user->woodcutting, 'logs' => $logs];

        CommandLog::create([
            'user_id' => Auth::user()->id,
            'command' => 'chop',
            'message' => json_encode($output),
        ]);

        return response()->json($output);
    }
}
