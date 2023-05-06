<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = false;

    public function steps()
    {
        return $this->hasMany(QuestStep::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
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
            ->whereNotNull('quest_steps.quest_id')
            ->whereNotNull('quest_step_dependencies.quest_id');
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

    public function getSkillRewards()
    {
        return $this->reward?->skills()->get();
    }

    public function getSkillRewardsWithTotals(User $user)
    {
        return $this->getSkillRewards()?->each(function ($skill_reward) use ($user) {
            $skill_reward->total = $user->getXp($skill_reward->pivot->skill_id);
        });
    }

    public function getItemRewards()
    {
        return $this->reward?->items()->get();
    }

    public function getItemRewardsWithTotals(User $user)
    {
        return $this->getItemRewards()?->each(function ($item_reward) use ($user) {
            $item = Item::firstWhere('id', $item_reward->pivot->item_id);
            $item_reward->total = $user->numberInInventory($item);
        });
    }

    public function getAllWithTotals(User $user)
    {
        return $this->with('steps')
            ->leftJoin('completed_quest_steps', 'completed_quest_steps.quest_id', '=', 'quests.id');
    }
}
