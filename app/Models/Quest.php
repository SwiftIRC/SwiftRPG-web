<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'name',
        'description',
        'gp',
        'thieving',
        'fishing',
        'mining',
        'woodcutting',
        'firemaking',
        'cooking',
        'smithing',
        'fletching',
        'crafting',
        'herblore',
        'agility',
        'farming',
        'hunter',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function steps()
    {
        return $this->hasMany(QuestStep::class);
    }

    public function itemRewards()
    {
        return $this->hasMany(QuestItemReward::class);
    }

    public function completedSteps()
    {
        return $this->hasMany(CompletedQuestStep::class);
    }

    public function start(User $user, int $quest_id, int $step_id = 1)
    {
        $quest = $this->findOrFail($quest_id)->first();
        $quest->step = $quest->steps()->orderBy('id')->offset($step_id - 1)->firstOrFail();
        $quest->step->dependencies = $quest->step->incompleteDependencies()->get();

        $quest->incompleteSteps = 0;
        if ($quest->step->dependencies->count() > 0) {
            foreach ($quest->step->dependencies as $dependency) {
                $quest->incompleteSteps += $dependency->incompleteSteps()->get()->count();
            }
        }

        if ($quest->step->completedSteps()->offset($step_id - 1)->first() === null
            && $quest->step->doesntHave('completedSteps')->get()->count() > 0
            && $quest->incompleteSteps === 0) {
            $quest->completedSteps()->create([
                'quest_step_id' => $quest->step->id,
            ]);
        }

    }
}
