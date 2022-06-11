<?php

use App\Models\Item;
use App\Models\Inventory;
use App\Models\CommandLog;
use Illuminate\Support\Facades\Auth;

class Woodcutting
{
    public function chop()
    {
        $last_run = CommandLog::where('user_id', Auth::id())->where('command', 'chop')->where('created_at', '>=', now()->subMinutes(1))->get()->count();
        if ($last_run > 0) {
            return response()->json(['error' => 'You can only run this command once every minute.'], 403);
        }

        $user = Auth::user();
        $user->woodcutting += 5;
        $user->save();

        $item = Item::where('name', 'Logs')->first();
        $user->inventory->items()->attach($item);

        $logs = $user->inventory->items()->where('name', 'Logs')->count();

        $output = ['woodcutting' => $user->woodcutting, 'logs' => $logs];

        CommandLog::create([
            'user_id' => Auth::user()->id,
            'command' => 'chop',
            'message' => json_encode($output),
        ]);

        return $output;
    }
}
