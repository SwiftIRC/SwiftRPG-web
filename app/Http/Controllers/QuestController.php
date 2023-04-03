<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    function list(Request $request) {
        return response()->json($request->user()->quests()->get());
    }

    public function start(Request $request)
    {
        $request->validate([
            'quest_id' => 'numeric|integer',
            'step_id' => 'nullable|numeric|integer',
        ]);

        $response = app(Quest::class)->start($request->quest_id, $request->step_id ?? 1);

        return response()->json($response);
    }

    public function inspect(Request $request)
    {
        $request->validate([
            'quest_id' => 'numeric|integer',
        ]);

        $quest = Quest::find($request->quest_id);

        $quest->steps = $quest->steps()->get();

        foreach ($quest->steps as $step) {
            $step->dependencies = $step->dependencies()->get();
        }

        return response()->json($quest);
    }
}
