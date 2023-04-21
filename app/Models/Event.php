<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'reward_id',
        'name',
        'description',
        'ticks',
    ];

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
