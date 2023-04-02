<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestStepDependency extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'quest_id',
        'quest_step_id',
        'quest_step_dependency_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function questStep()
    {
        return $this->belongsTo(QuestStep::class);
    }

    public function questStepDependency()
    {
        return $this->belongsTo(QuestStep::class);
    }

    public function completeSteps()
    {
        return $this->hasOne(CompletedQuestStep::class, 'quest_step_id', 'quest_step_id');
    }

    public function incompleteSteps($quest_id, $step_id)
    {
        return $this->doesntHave('completeSteps')
            ->where('quest_id', $quest_id);
        dd($this->completeSteps()->get()->pluck('quest_step_id')->toArray());
        return $this->hasOne(CompletedQuestStep::class, 'quest_step_id', 'quest_step_id')
            ->selectRaw("quest_step_dependencies.*, completed_quest_steps.*, quest_step_dependencies.id as quest_step_dependency_id, completed_quest_steps.id as completed_quest_step_id")
            ->leftJoin('quest_step_dependencies', 'quest_step_dependencies.quest_step_dependency_id', '=', 'quest_step_dependencies.quest_step_id')
            ->whereNotNull('quest_step_dependencies.id')
            ->whereNotIn('quest_step_id', $this->completeSteps()->get()->pluck('quest_step_id')->toArray());
    }
}
