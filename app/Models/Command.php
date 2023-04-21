<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    protected $fillable = [
        'reward_id',
        'class',
        'method',
        'verb',
        'emoji',
        'ticks',
        'log',
        'movement_cost',
    ];

    public $timestamps = false;

    public function reward()
    {
        return $this->belongsTo(Reward::class);
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
}
