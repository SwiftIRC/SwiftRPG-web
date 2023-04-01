<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestItemReward extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'quest_id',
        'item_id',
        'quantity',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
