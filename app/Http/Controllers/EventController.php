<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Skills\Eventing;
use Illuminate\Http\Request;
use RangeException;

class EventController extends Controller
{
    public function index()
    {
        return Event::withTrashed()->firstWhere('deleted_at', '>', now());
    }

    public function engage(Request $request)
    {
        try {
            return app(Eventing::class)->engage($request);
        } catch (RangeException $e) {
            return response()->error(['error' => $e->getMessage()], 200);
        }
    }
}
