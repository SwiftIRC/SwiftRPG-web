<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = false;

    public function steps()
    {
        return $this->hasMany(QuestStep::class);
    }

    public function skillRewards()
    {
        return $this->hasMany(Reward::class)->withPivot('quantity');
    }

    public function itemRewards()
    {
        return $this->hasMany(Reward::class)->withPivot('quantity');
    }

    public function completeSteps()
    {
        return $this->hasMany(CompletedQuestStep::class);
    }

    public function incompleteSteps()
    {
        return $this->doesntHave('completeSteps')
            ->selectRaw('quest_step_dependencies.*')
            ->leftJoin('quest_steps', 'quest_steps.quest_id', '=', 'quests.id')
            ->leftJoin('quest_step_dependencies', 'quest_step_dependencies.quest_step_id', '=', 'quest_steps.id')
            ->groupBy('quest_step_dependencies.quest_id')
        ;
    }

    public function start(int $quest_id, int $step_id = 1)
    {
        $quest = $this->inspect($quest_id, $step_id);

        if ($quest->completeStep === null
            && $quest->incompleteSteps->count() > 0
            && $quest->incompleteDependencies === 0) {
            $quest->completeSteps()->create([
                'quest_step_id' => $quest->step->id,
            ]);
        }

        return $quest;
    }

    public function inspect(int $quest_id, int $step_id = 1)
    {
        $quest = $this->where('id', $quest_id)->firstOrFail();
        $quest->step = $quest->steps()->where('quest_id', $quest_id)->orderBy('id')->offset($step_id - 1)->firstOrFail();
        $quest->requested_step_id = $step_id;
        $quest->incompleteSteps = $quest->step->incompleteSteps($quest->id)->get();
        $quest->dependencies = $quest->step->dependencies()->get();
        $quest->completeStep = $quest->completeSteps()->where('quest_id', $quest_id)->where('quest_step_id', $quest->step->id)->first();
        $quest->completeSteps = $quest->completeSteps()->where('quest_id', $quest_id)->get();

        $completeStepsIds = $quest->completeSteps->pluck('quest_step_id');

        $quest->incompleteDependencies = $quest->dependencies->pluck('quest_step_id')->filter(function ($dependency_id, $key) use ($completeStepsIds) {
            return !$completeStepsIds->contains($dependency_id);
        })->count();

        return $quest;
    }

}
