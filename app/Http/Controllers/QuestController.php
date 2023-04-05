<?php

namespace App\Http\Controllers;

use App\Skills\Questing;
use Illuminate\Http\Request;
use RangeException;

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

        try {
            return app(Questing::class)->start($request);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
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
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
