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
}
