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
            ->selectRaw("quest_step_dependencies.*, quest_steps.*, completed_quest_steps.*, quest_step_dependencies.id as quest_step_dependency_id, quest_steps.id as quest_step_id, completed_quest_steps.id as completed_quest_step_id")
            ->leftJoin('quest_steps', 'quest_step_dependencies.quest_step_dependency_id', '=', 'quest_steps.id')
            ->leftJoin('completed_quest_steps', 'quest_step_dependencies.quest_step_dependency_id', '=', 'completed_quest_steps.quest_step_id')
            ->whereNull('completed_quest_steps.id');
    }

    public function completedSteps()
    {
        return $this->hasOne(CompletedQuestStep::class);
    }

}
