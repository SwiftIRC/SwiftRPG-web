<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestStepDependency extends Model
{
    use HasFactory;

    protected $fillable = [
        'quest_id',
        'quest_step_id',
        'quest_step_dependency_id',
    ];

    public $timestamps = false;

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
    }
}
