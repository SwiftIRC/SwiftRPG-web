<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user->quests()->get());
    }

    public function start(Request $request)
    {
        $request->validate([
            'quest_id' => ['required', 'integer'],
            'step_id' => ['nullable', 'integer'],
        ]);

        app(Quest::class)->start($request->quest_id, $request->step_id ?? 1);

        return $this->index($request);
    }
}
