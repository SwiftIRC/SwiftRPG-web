<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sbine\Tenancy\HasTenancy;

class CompletedQuestStep extends Model
{
    use HasFactory, HasTimestamps, HasTenancy;

    protected $fillable = [
        'quest_id',
        'quest_step_id',
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
}
