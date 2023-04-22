<?php

namespace App\Http\Controllers;

use App\Http\Response\Skill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    public function lookup(string $name = null): array
    {
        $user = null;

        if (empty($name)) {
            $user = Auth::user();
        } else {
            $user = User::where('name', $name)->firstOrFail();
        }

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'skills' => $user->skills()->get()->map(function ($skill) {
                return (new Skill($skill))->toArray();
            }),
        ];
    }
}
