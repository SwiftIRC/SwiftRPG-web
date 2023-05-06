<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Skills\Questing;
use Illuminate\Http\Request;
use RangeException;

class QuestController extends Controller
{
    function list(Request $request) {
        //
        $started = $request->user()->quests()->get();
        $unstarted = Quest::whereNotIn('id', $started->pluck('id')->toArray())->get()->map(function ($quest) {
            $quest->completed = 0;
            $quest->total = $quest->steps()->count();
            return $quest;
        });
        $quests = $started->concat($unstarted)->sort(function ($a, $b) {
            return $a->id <=> $b->id;
        })->values();

        return response()->json($quests);
    }

    public function start(Request $request)
    {
        $request->validate([
            'quest_id' => 'numeric|integer',
            'step_id' => 'nullable|numeric|integer',
        ]);

        try {
            return app(Questing::class)->start($request);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }

    }

    public function inspect(Request $request)
    {
        $request->validate([
            'quest_id' => 'numeric|integer',
        ]);

        try {
            return app(Questing::class)->inspect($request->quest_id);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
}
