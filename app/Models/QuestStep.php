<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestStep extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'quest_id',
        'ticks',
        'output',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function dependencies()
    {
        return $this->hasOne(QuestStepDependency::class)
            ->selectRaw("quest_step_dependencies.*, quest_steps.*, quest_step_dependencies.id as quest_step_dependency_id, quest_steps.id as quest_step_id")
            ->leftJoin('quest_steps', 'quest_step_dependencies.quest_step_dependency_id', '=', 'quest_steps.id');
    }

    public function completeDependencies()
    {
        return $this->hasOne(QuestStepDependency::class)
            ->selectRaw("quest_step_dependencies.*, quest_steps.*, completed_quest_steps.*, quest_step_dependencies.id as quest_step_dependency_id, quest_steps.id as quest_step_id, completed_quest_steps.id as completed_quest_step_id")
            ->leftJoin('quest_steps', 'quest_step_dependencies.quest_step_dependency_id', '=', 'quest_steps.id')
            ->leftJoin('completed_quest_steps', 'quest_step_dependencies.quest_step_dependency_id', '=', 'completed_quest_steps.quest_step_id')
            ->whereNotNull('completed_quest_steps.id');
    }

    public function incompleteDependencies()
    {
        return $this->hasOne(QuestStepDependency::class)
            ->selectRaw("quest_step_dependencies.*, completed_quest_steps.*, quest_step_dependencies.id as quest_step_dependency_id, quest_steps.id as quest_step_id, completed_quest_steps.id as completed_quest_step_id")
            ->leftJoin('quest_step_dependencies', 'quest_step_dependencies.quest_step_dependency_id', '=', 'quest_steps.id')
            ->whereNotNull('quest_step_dependencies.id')
            ->whereNotIn('id', $this->completeDependencies()->get()->pluck('quest_step_id')->toArray());
    }

    public function completeSteps()
    {
        return $this->hasOne(CompletedQuestStep::class);
    }

    public function incompleteSteps($quest_id)
    {
        return $this->doesntHave('completeSteps')
            ->whereNotNull('quest_steps.quest_id')
            ->where('quest_steps.quest_id', $quest_id);
    }

}
