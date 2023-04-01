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
        return $this->hasMany(QuestStepDependency::class);
    }

    public function completedSteps()
    {
        return $this->hasOne(CompletedQuestStep::class);
    }

}
