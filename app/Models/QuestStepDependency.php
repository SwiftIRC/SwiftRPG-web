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

    public function completedSteps()
    {
        return $this->hasOne(CompletedQuestStep::class, 'quest_step_id', 'quest_step_id');
    }

    public function incompleteSteps()
    {
        return $this->doesntHave('completedSteps');
    }
}
